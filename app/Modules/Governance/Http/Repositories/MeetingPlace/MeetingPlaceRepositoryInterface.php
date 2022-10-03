<?php

namespace App\Modules\Governance\Http\Repositories\MeetingPlace;

use App\Modules\Governance\Http\Requests\MeetingPlaceRequest;
use App\Repositories\CommonRepositoryInterface;

interface MeetingPlaceRepositoryInterface extends CommonRepositoryInterface
{
    public function show($id);
    public function edit($id);
    public function store(MeetingPlaceRequest $request);
    public function updateMeetingPlace(MeetingPlaceRequest $request,$id);
    public function destroy($id);

}
