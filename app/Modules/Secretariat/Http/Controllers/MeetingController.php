<?php

namespace App\Modules\Secretariat\Http\Controllers;

use App\Foundation\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Modules\Secretariat\Http\Repositories\Meetings\MeetingRepositoryInterface;
use App\Modules\Secretariat\Http\Requests\MeetingRequest;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    use ApiResponseTrait;

    private MeetingRepositoryInterface $meetingRepository;

    public function __construct(MeetingRepositoryInterface $meetingRepository)
    {
        $this->meetingRepository = $meetingRepository;
        $this->middleware('permission:list-meeting')->only(['index']);
        $this->middleware('permission:create-meeting')->only('store');
        $this->middleware('permission:edit-meeting')->only('update');
        $this->middleware('permission:delete-meeting')->only('destroy');
    }

    public function index(Request $request)
    {
        return $this->meetingRepository->index($request);
    }

    public function store(MeetingRequest $request)
    {
        return $this->meetingRepository->store($request->validated());
    }

    public function show($id)
    {
        return $this->meetingRepository->show($id);
    }

    public function edit($id)
    {
        return $this->meetingRepository->editMeeting($id);
    }

    public function update(MeetingRequest $request, $id)
    {
        return $this->meetingRepository->edit($request->validated(), $id);
    }

    public function destroy($id)
    {
        return $this->meetingRepository->destroy($id);
    }

    public function activities($id)
    {
        return $this->meetingRepository->recordActivities($id);
    }
}
