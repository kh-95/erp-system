<?php

namespace App\Modules\Secretariat\Http\Repositories\Meetings;

use App\Modules\Secretariat\Entities\MeetingDiscussionPoint;
use App\Modules\Secretariat\Entities\Meeting;
use App\Modules\Secretariat\Transformers\Meetings\{MeetingDiscussionPointResource,MeetingResource};
use App\Repositories\CommonRepository;
use App\Foundation\Traits\ApiResponseTrait;

class MeetingDiscussionPointRepository extends CommonRepository implements MeetingDiscussionPointRepositoryInterface
{

    use ApiResponseTrait;

    public function model()
    {
        return MeetingDiscussionPoint::class;
    }

    public function store($data, $meeting_id){
     $meeting =  Meeting::find($meeting_id);
     $meeting->discussionPoints()->create($data);
     $meeting->load(['employees','discussionPoints','room']);
     return $this->successResponse(data:MeetingResource::make($meeting), message:'created');
    }

    public function editDissusion($data, $id){
        $decussion_point = $this->update($data, $id);
        return $this->successResponse(new MeetingDiscussionPointResource($decussion_point), message : 'updated');
    }

    public function deleteDissusion($id){
      $this->delete($id);
      return $this->successResponse( message : 'deleted');
    }

}
