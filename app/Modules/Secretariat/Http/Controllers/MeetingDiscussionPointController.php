<?php

namespace App\Modules\Secretariat\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Modules\Secretariat\Http\Repositories\Meetings\MeetingDiscussionPointRepositoryInterface;
use App\Modules\Secretariat\Http\Requests\DecisionRequest;

class MeetingDiscussionPointController extends Controller
{

    private MeetingDiscussionPointRepositoryInterface $discussionPointRepository;

    public function __construct(MeetingDiscussionPointRepositoryInterface $discussionPointRepository)
    {
        $this->discussionPointRepository = $discussionPointRepository;
    }

    public function store(DecisionRequest $request, $meeting_id)
    {
        return $this->discussionPointRepository->store($request->validated(),$meeting_id);
    }

    public function update(DecisionRequest $request, $id)
    {
        return $this->discussionPointRepository->editDissusion($request->validated(),$id);
    }

    public function destroy($id)
    {
        return $this->discussionPointRepository->deleteDissusion($id);
    }

    public function activities($id)
    {
        return $this->discussionPointRepository->recordActivities($id);
    }
}
