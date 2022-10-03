<?php

namespace App\Modules\Governance\Http\Controllers;

use App\Foundation\Classes\Helper;
use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\Governance\Http\Repositories\Meeting\MeetingRepositoryInterface;
use App\Modules\Governance\Http\Requests\EmployeeHavntIntersctScheduleRequest;
use App\Modules\Governance\Http\Requests\MeetingRequest;
use App\Modules\Governance\Transformers\MeetingResource;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class MeetingController extends Controller
{
    use ApiResponseTrait;
    public function __construct(private MeetingRepositoryInterface $meeting_repository)
    {
    }

    public function index(Request $request)
    {
        // $meetingAttendanceTable = MeetingAttendance::getTableName();
        // $meetingTable = Meeting::getTableName();
        // $userTable = User::getTableName();
        // ->join($meetingAttendanceTable,"{$meetingAttendanceTable}.meeting_id","{$meetingTable}.id")
        return $this->meeting_repository->index($request);
    }

    public function store(MeetingRequest $request)
    {
        return $this->meeting_repository->store($request);
    }

    public function acceptMeetingFromSuperAdmin($meeting_id, $employee_id)
    {
        return $this->meeting_repository->acceptMeetingFromSuperAdmin($meeting_id,$employee_id);
    }

    public function rejectMeetingFromSuperAdmin($meeting_id, $employee_id)
    {
        return $this->meeting_repository->rejectMeetingFromSuperAdmin($meeting_id,$employee_id);
    }

    public function acceptMeeting($meeting_id)
    {
        return $this->meeting_repository->acceptMeeting($meeting_id);
    }

    public function rejectMeeting($meeting_id)
    {
        return $this->meeting_repository->rejectMeeting($meeting_id);
    }

    public function cancelMeeting($meeting_id)
    {
        return $this->meeting_repository->cancelMeeting($meeting_id);
    }


    public function getEmployees(EmployeeHavntIntersctScheduleRequest $request)
    {
        return $this->meeting_repository->getEmployees($request);
    }

    public function getMeetingPlaces()
    {
        return $this->meeting_repository->getMeetingPlaces();
    }


    public function show($id)
    {
        return $this->meeting_repository->show($id);
    }

    public function edit($id)
    {
        return $this->meeting_repository->edit($id);
    }


    public function update(MeetingRequest $request, $id)
    {
        return $this->meeting_repository->updateMeeting($request, $id);
    }


}
