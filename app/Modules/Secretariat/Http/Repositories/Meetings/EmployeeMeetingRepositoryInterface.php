<?php

namespace App\Modules\Secretariat\Http\Repositories\Meetings;

use App\Modules\Secretariat\Http\Requests\EmployeeMeetingRequest;
use App\Repositories\CommonRepositoryInterface;
use Illuminate\Http\Request;

interface EmployeeMeetingRepositoryInterface extends CommonRepositoryInterface
{
    public function index(Request $request);
    public function edit(EmployeeMeetingRequest $request, $id);

}
