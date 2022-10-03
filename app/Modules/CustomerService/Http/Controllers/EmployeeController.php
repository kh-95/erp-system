<?php

namespace App\Modules\CustomerService\Http\Controllers;

use App\Foundation\Classes\Helper;
use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\CustomerService\Entities\Call;
use App\Modules\CustomerService\Http\Repositories\Employee\EmployeeRepositoryInterface;
use App\Modules\CustomerService\Transformers\EmployeeResource;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class EmployeeController extends Controller
{
    use ApiResponseTrait;
    public function __construct(private EmployeeRepositoryInterface $employeeRepository) {
        $this->middleware('permission:list-customer_service_employees')->only(['index']);
        $this->middleware('permission:show-customer_service_employees')->only(['show']);
    }

    public function index(Request $request)
    {
        $employees = $this->employeeRepository
            ->setFilters()
            ->defaultSort('-created_at')
            ->allowedSorts($this->employeeRepository->sortColumns())
            ->where(['deactivated_at' => null, 'is_customer_service' => true])
            ->paginate(Helper::getPaginationLimit($request));
        $data = EmployeeResource::collection($employees);
        return $this->paginateResponse($data, $employees);
    }

    public function show($id)
    {
        return $this->employeeRepository->show($id);
    }



}
