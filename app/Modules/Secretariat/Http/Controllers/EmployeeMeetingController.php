<?php

namespace App\Modules\Secretariat\Http\Controllers;

use App\Foundation\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Modules\Secretariat\Http\Repositories\Meetings\EmployeeMeetingRepositoryInterface;
use App\Modules\Secretariat\Http\Requests\EmployeeMeetingRequest;
use Illuminate\Http\Request;

class EmployeeMeetingController  extends Controller
{
    use ApiResponseTrait;

    private EmployeeMeetingRepositoryInterface $employeeMeetingRepository;

    public function __construct(EmployeeMeetingRepositoryInterface $employeeMeetingRepository)
    {
        $this->employeeMeetingRepository = $employeeMeetingRepository;
    }

    public function index(Request $request)
    {
        return $this->employeeMeetingRepository->index($request);
    }

    public function update(EmployeeMeetingRequest $request, $id)
    {
        return $this->employeeMeetingRepository->edit($request, $id);
    }

}
