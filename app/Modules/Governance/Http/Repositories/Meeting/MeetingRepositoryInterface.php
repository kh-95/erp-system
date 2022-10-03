<?php

namespace App\Modules\Governance\Http\Repositories\Meeting;

use App\Modules\Governance\Http\Requests\MeetingRequest;
use App\Repositories\CommonRepositoryInterface;
use Illuminate\Http\Request;

interface MeetingRepositoryInterface extends CommonRepositoryInterface
{
    public function index(Request $request);
    public function show($id);
    public function edit($id);

    public function store(MeetingRequest $request);

    public function updateMeeting(MeetingRequest $request,$id);
    public function acceptMeetingFromSuperAdmin($meeting_id,$employee_id);
    public function rejectMeetingFromSuperAdmin($meeting_id,$employee_id);
    public function acceptMeeting($meeting_id);
    public function rejectMeeting($meeting_id);
    public function cancelMeeting($meeting_id);
}
