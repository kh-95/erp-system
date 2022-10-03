<?php

namespace App\Modules\HR\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\EmployeesExport;
use Illuminate\Routing\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\HR\Http\Requests\Employee\StoreRequest;
use App\Modules\HR\Http\Requests\Employee\UpdateRequest;
use App\Modules\HR\Http\Requests\Employee\FirstStepRequest;
use App\Modules\HR\Http\Requests\Employee\ForthStepRequest;
use App\Modules\HR\Http\Requests\Employee\ThirdStepRequest;
use App\Modules\HR\Http\Requests\Employee\SecondStepRequest;
use App\Modules\HR\Http\Requests\Employee\StoreCustodiesRequest;
use App\Modules\HR\Http\Requests\Employee\StoreAllowancesRequest;
use App\Modules\HR\Http\Requests\Employee\StoreAttachementsRequest;
use App\Modules\HR\Http\Requests\Employee\StoreJobInformationRequest;
use App\Modules\HR\Http\Repositories\Employee\EmployeeRepositoryInterface;

class EmployeeController extends Controller
{
    use ApiResponseTrait;

    private EmployeeRepositoryInterface $employeeRepository;

    public function __construct(EmployeeRepositoryInterface $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
        $this->middleware('permission:list-employee')->only(['index', 'show']);
        $this->middleware('permission:create-employee')->only(['store', 'uniqueEmployeeNumber']);
        $this->middleware('permission:edit-employee')->only('update');
    }

    public function index(Request $request)
    {
        return $this->employeeRepository->index($request);
    }

    public function store(StoreRequest $request)
    {
        return $this->employeeRepository->store($request);
    }

    /*-------------deviding store employee into four steps --------------------------*/

    public function storeJobInformation(int $employeeId, StoreJobInformationRequest $request)
    {
        return $this->successResponse($this->employeeRepository->storeJobInformation($employeeId, $request->validated()));
    }

    public function storeAttachements(int $employeeId, StoreAttachementsRequest $request)
    {
        return $this->employeeRepository->storeAttachements($employeeId, $request->validated());
    }

    public function storeAllowence(int $employeeId, StoreAllowancesRequest $request)
    {
        return $this->employeeRepository->storeAllowence($employeeId, $request->validated());
    }

    public function storeCustodies(int $employeeId, StoreCustodiesRequest $request)
    {
        return $this->employeeRepository->storeCustodies($employeeId, $request->validated());
    }

    /*-------------end deviding store employee into four steps -----------------------*/

    // public function storeEmployeeMetaData($step, FirstStepRequest $firstStepRequest, SecondStepRequest $secondStepRequest, ThirdStepRequest $thirdStepRequest, ForthStepRequest $forthStepRequest)
    // {
    //     switch ($step) {
    //         case 1:
    //             $data = $firstStepRequest->validated();
    //             break;
    //         case 2:
    //             $data = $secondStepRequest->validated();
    //             break;
    //         case 3:
    //             $data = $thirdStepRequest->validated();
    //             break;
    //         case 4:
    //             $data = $forthStepRequest->validated();
    //             break;
    //     }

    //     $this->employeeRepository->storeEmployeeMetaData($data);

    //     return $this->successResponse();
    // }


    public function show($id)
    {
        return $this->employeeRepository->show($id);
    }

    public function update(UpdateRequest $request, $id)
    {
        return $this->employeeRepository->edit($request, $id);
    }

    public function uniqueEmployeeNumber()
    {
        return $this->employeeRepository->uniqueEmployeeNumber();
    }

    public function listCustomerServiceEmployees()
    {
        return $this->employeeRepository->listCustomerServiceEmployees();
    }

    public function export()
    {
        return Excel::download(new EmployeesExport, 'employees.xlsx');
    }
}
