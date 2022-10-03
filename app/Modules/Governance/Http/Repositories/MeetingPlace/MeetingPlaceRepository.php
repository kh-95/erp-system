<?php

namespace App\Modules\Governance\Http\Repositories\MeetingPlace;

use App\Foundation\Traits\ApiResponseTrait;
use App\Foundation\Traits\ImageTrait;
use App\Modules\Governance\Entities\MeetingPlace;
use App\Repositories\CommonRepository;
use App\Modules\Governance\Http\Requests\MeetingPlaceRequest;




class MeetingPlaceRepository extends CommonRepository implements MeetingPlaceRepositoryInterface
{
    use ImageTrait, ApiResponseTrait;

    public function model()
    {
        return MeetingPlace::class;
    }

    public function filterColumns()
    {
        return [
            $this->translated('name'),
            $this->createdAtBetween('created_to'),
            $this->createdAtBetween('created_from'),
            'status',

        ];
    }


    public function sortColumns()
    {
        return [
            'name',
            'created_at',
            'status',
        ];
    }


    public function show($id)
    {
        return $this->model()::findOrFail($id);
    }

    public function store(MeetingPlaceRequest $request)
    {
        return $this->create($request->validated() + ['added_by_id' => auth()->id()]);
    }

    public function edit($id)
    {
        return $this->model()::findOrFail($id);
    }

    public function updateMeetingPlace(MeetingPlaceRequest $request, $id)
    {
        $meetingPlace = $this->find($id);
        $meetingPlace->update($request->validated());
        return $this->apiResource($meetingPlace, true, __('Common::message.success_update') );
    }


    public function destroy($id)
    {
        if ($this->doesntHaveRelations($id, ['meetings'])) {
            $this->delete($id);
            return $this->successResponse(['message' => __('governance::messages.general.successfully_deleted')]);
        }
        return $this->errorResponse(['message' => __('governance::messages.meeting_places.meetings_found')]);

     }
}
