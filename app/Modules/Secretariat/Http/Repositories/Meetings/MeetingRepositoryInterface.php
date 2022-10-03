<?php

namespace App\Modules\Secretariat\Http\Repositories\Meetings;

use App\Modules\Secretariat\Http\Requests\MeetingRequest;
use App\Repositories\CommonRepositoryInterface;

interface MeetingRepositoryInterface extends CommonRepositoryInterface
{
    public function index();
    public function store(MeetingRequest $request);
    public function editMeeting($id);
    public function edit(MeetingRequest $request, $id);
    public function show($id);
    public function destroy($id);
}
