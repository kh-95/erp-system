<?php

namespace App\Modules\Secretariat\Http\Repositories\Meetings;

use App\Foundation\Classes\Helper;
use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\Secretariat\Entities\Meeting;
use App\Modules\Secretariat\Entities\MeetingDiscussionPoint;
use App\Modules\HR\Entities\Employee;
use App\Modules\Secretariat\Http\Requests\MeetingRequest;
use App\Modules\Secretariat\Transformers\Meetings\MeetingResource;
use App\Repositories\CommonRepository;

class MeetingRepository extends CommonRepository implements MeetingRepositoryInterface
{
    use ApiResponseTrait;

    public function filterColumns()
    {
        return [
            'id',
            $this->translated('title'),
            'meeting_duration',
            $this->translated('type'),
            'employee.first_name',
            $this->translated('note'),
            $this->translated('room.name'),
        ];
    }

    public function model()
    {
        return Meeting::class;
    }

    public function index()
    {
        $meetings = $this->setFilters()->with(['discussionPoints', 'decisions', 'employees'])
        ->defaultSort('-created_at')
        ->allowedSorts(['id', $this->sortingTranslated('title','title'), $this->sortingTranslated('type','type'),$this->sortingTranslated('note','note'),
        'meeting_duration', $this->sortingTranslated('room.name','room.name')])->paginate(Helper::PAGINATION_LIMIT);
        $data = MeetingResource::collection($meetings);
        return $this->paginateResponse($data, $meetings);
    }

    public function store($request)
    {
        try {

            $data = collect($request)->except('date', 'time', 'time_format')->toArray();

            $data['meeting_date'] = Helper::ConcatenateDateTime($request['date'],
                                            $request['time'], $request['time_format']);

            $meeting = $this->create($data);

            if($data['type'] == 'suitable'){
                $employees = Employee::where('deactivated_at',null)->get('id');
                $request['employees'] = $employees;
            }
            $meeting->employees()->sync($request['employees']);

            $meeting->discussionPoints()->createMany($request['discussion_points']);
            if (isset($request['decisions'])) {
                $meeting->decisions()->createMany($request['decisions']);
            }
            $meeting->load(['employees','discussionPoints','room', 'activities']);
            return $this->successResponse(data:MeetingResource::make($meeting), message:'craeted');

        } catch (\Exception $exception) {
            return $this->errorResponse(null, 500, $exception->getMessage());
        }
    }

    public function editMeeting($id){
      $meeting = $this->find($id);
      $meeting->load(['employees', 'discussionPoints', 'room']);
      return $this->successResponse(MeetingResource::make($meeting));
    }

    public function edit($request, $id)
    {
        try {
            $data = collect($request)->except('date', 'time', 'time_format')->toArray();
             $data['meeting_date'] = Helper::ConcatenateDateTime($request['date'],
                                             $request['time'], $request['time_format']);

            $meeting = $this->update($data, $id);

            if (isset($request['employees'])) {
                if($data['type'] == 'suitable'){
                    $employees = Employee::where('deactivated_at',null)->get('id');
                    $request['employees'] = $employees;
                }
                $meeting->employees()->sync($request['employees']);
            }
            if(isset($request['discussion_points'])){
                $meeting->discussionPoints()->delete();
                $meeting->discussionPoints()->createMany($request['discussion_points']);
            }
            $meeting->load(['employees', 'discussionPoints', 'room', 'activities']);

            return $this->successResponse(data:MeetingResource::make($meeting), message:'updated');
        } catch (\Exception $exception) {
            return $this->errorResponse(null, 500, $exception->getMessage());
        }
    }

    public function show($id)
    {
        $meeting = $this->find($id)->load(['discussionPoints', 'employees', 'room']);
        return $this->successResponse(new MeetingResource($meeting));
    }

    public function destroy($id)
    {
        try {
            $this->delete($id);
            return $this->successResponse('deleted');
        } catch (\Exception $exception) {
            return $this->errorResponse(null, 500, $exception->getMessage());
        }
    }

}
