<?php

namespace App\Modules\Governance\Http\Repositories\Meeting;

use App\Foundation\Classes\Helper;
use App\Foundation\Traits\ApiResponseTrait;
use App\Foundation\Traits\ImageTrait;
use App\Modules\Governance\Entities\Meeting;
use App\Modules\Governance\Entities\MeetingAttendance;
use App\Modules\Governance\Entities\MeetingPlace;
use App\Modules\Governance\Http\Requests\EmployeeHavntIntersctScheduleRequest;
use App\Repositories\CommonRepository;
use App\Modules\Governance\Http\Requests\MeetingPlaceRequest;
use App\Modules\Governance\Http\Requests\MeetingRequest;
use App\Modules\Governance\Transformers\MeetingResource;
use App\Modules\HR\Entities\Employee;
use App\Repositories\AttachesRepository;
use Arr;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MeetingRepository extends CommonRepository implements MeetingRepositoryInterface
{
    use ImageTrait, ApiResponseTrait, EmployeeDoesntHaveMeetings;

    public function model()
    {
        return Meeting::class;
    }

    public function filterColumns()
    {
        return [
            'subject',
            'meeting_types',
            'meetingPlace.translations.name',
            'attendances.status',
            'attendances.employee.first_name',
            'attendances.employee.second_name',
            'attendances.employee.third_name',
            'attendances.employee.last_name',
            'id'
        ];
    }


    public function sortColumns()
    {
        return [
            'id',
            'subject',
            'start_at',
        ];
    }

    public function index(Request $request)
    {
        $meetings = $this->getMeetingsForSuperAdminOrForAuth($request)
            ->setFilters()
            ->defaultSort('-created_at')
            ->customDateFromTo($request, 'start_at', 'end_at')
            ->allowedSorts($this->sortColumns())
            ->paginate(Helper::getPaginationLimit($request));
        // dd($meetings);
        $data = MeetingResource::collection($meetings);
        return $this->paginateResponse($data, $meetings);
    }

    private function getMeetingsForSuperAdminOrForAuth($request)
    {
        $this->model()::when($request->meeting_types, function ($q) use ($request) {
                switch ($request->meeting_types) {
                    case 'sent_meetings':
                        $q->whereHas('employees', function ($query) {
                            $query->where(['employee_id' => auth()->id(), 'status' => 'pending']);
                        })->orWhereDoesntHave('employees.user', function ($q) {
                            $q->where('employee_number', '123456');
                        });
                        break;
                    default:
                        $q->whereHas('employees', function ($query) {
                            $query->where('employee_id', auth()->id());
                        })->orWhereDoesntHave('employees.user', function ($q) {
                            $q->where('employee_number', '123456');
                        });
                }
            });
        return $this;
    }

    public function acceptMeetingFromSuperAdmin($meeting_id, $employee_id)
    {
        if(auth()->user()->employee_number == '123456'){
            $meeting = $this->find($meeting_id);
            $meeting->employees()->where(['employee_id'=>$employee_id,'status' =>'pending'])->update(['status' =>'accepted']);
            $meeting->load(['points', 'attachments', 'meetingPlace', 'employees']);
            return $this->apiResource(MeetingResource::make($meeting));
        }



    }

    public function rejectMeetingFromSuperAdmin($meeting_id, $employee_id)
    {
        if(auth()->user()->employee_number == '123456'){
            $meeting = $this->find($meeting_id);
            $meeting->employees()->where(['employee_id'=>$employee_id,'status' =>'pending'])->update(['status' =>'rejected']);
            $meeting->load(['points', 'attachments', 'meetingPlace', 'employees']);
            return $this->apiResource(MeetingResource::make($meeting));
        }
    }

    public function acceptMeeting($meeting_id)
    {
        $meeting = $this->find($meeting_id);

        $meeting->employees()->where(['employee_id'=> auth()->user()->employee?->id,'status' =>'pending'])->update(['status' =>'accepted']);

        $meeting->load(['points', 'attachments', 'meetingPlace', 'employees']);
        return $this->apiResource(MeetingResource::make($meeting));
    }

    public function rejectMeeting($meeting_id)
    {
        $meeting = $this->find($meeting_id);
        $meeting->employees()->where(['employee_id'=> auth()->user()->employee?->id,'status' =>'pending'])->update(['status' =>'rejected']);
        $meeting->load(['points', 'attachments', 'meetingPlace', 'employees']);
        return $this->apiResource(MeetingResource::make($meeting));
    }

    public function cancelMeeting($meeting_id)
    {
        $meeting = $this->find($meeting_id);
        if($meeting->start_at > now()){
            $meeting->employees()->where(['employee_id'=> auth()->user()->employee?->id,'status' =>'accepted'])->update(['status' =>'canceled']);
        }
        $meeting->load(['points', 'attachments', 'meetingPlace', 'employees']);
        return $this->apiResource(MeetingResource::make($meeting));
    }

    public function getEmployees(EmployeeHavntIntersctScheduleRequest $request)
    {
        return $this->getFreeEmployees($request->management_id, $request->start_at, $request->end_at);
    }

    public function getMeetingPlaces()
    {
        $meetingPlaces = MeetingPlace::latest()->withTranslation('name')->get();
        return $this->successResponse(data: $meetingPlaces);
    }



    public function show($id)
    {
        $meeting = $this->find($id);
        $meeting->load(['points', 'attachments', 'meetingPlace', 'employees']);
        return $this->apiResource(MeetingResource::make($meeting));
    }

    public function store(MeetingRequest $request)
    {
        $data = $request->validated();
        if ($request->meeting_place_id == null) {
            $data['is_online'] = true;
        }
        $meeting = $this->model()::make()->fill(Arr::except($data, ['points', 'attachments', 'attendances', 'file_type']));
        $meeting->save();


        $points = $this->formatPointsData($request->points);


        $this->storeRelations($meeting, $points, $request->attendances);

        if (array_key_exists('attachments', $request->validated())) {
            $attaches = new AttachesRepository('meeting_attachments', $request, $meeting);
            $attaches->addAttaches();
        }
        $meeting->load(['points', 'attachments', 'meetingPlace', 'employees']);
        return $this->apiResource(MeetingResource::make($meeting), true, __('Common::message.success_create'));
        // return $committee;
    }

    public function edit($id)
    {
        $meeting = $this->find($id);
        $meeting->load(['points', 'attachments', 'meetingPlace', 'employees']);
        return $this->apiResource(MeetingResource::make($meeting));
    }



    public function updateMeeting(MeetingRequest $request, $id)
    {
        $meeting = $this->find($id);
        $data = $request->validated();
        if ($request->meeting_place_id == null) {
            $data['is_online'] = true;
        }
        $meeting->update(Arr::except($data, ['points', 'attachments', 'attendances', 'file_type']));


        $points = $this->formatPointsData($request->points);
        $this->updateRelations($meeting, $points, $request->attendances);

        if (array_key_exists('attachments', $request->validated())) {

            $attaches = new AttachesRepository('meeting_attachments', $request, $meeting);
            $attaches->deleteAttachment($meeting->attachments);
            $meeting = $attaches->addAttaches();
        }
        $meeting->load(['points', 'attachments', 'meetingPlace', 'employees']);
        return $this->apiResource(MeetingResource::make($meeting), true, __('Common::message.success_update'));
    }

    private function formatPointsData($points_request)
    {
        $points = array_map(function ($point) {
            $arr['point'] = $point;
            return $arr;
        }, $points_request);
        return $points;
    }

    private function storeRelations($meeting, $points, $attendances)
    {
        $meeting->points()->createMany($points);
        $meeting->attendances()->createMany($attendances);
    }

    private function updateRelations($meeting, $points, $attendances)
    {
        $meeting->points()->delete();
        $meeting->points()->createMany($points);
        $meeting->attendances()->delete();
        $meeting->attendances()->createMany($attendances);
    }
}
