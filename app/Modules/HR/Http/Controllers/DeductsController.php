<?php

namespace App\Modules\HR\Http\Controllers;

use App\Foundation\Classes\Helper;
use App\Modules\HR\Entities\DeductBonus;
use App\Foundation\Traits\ApiResponseTrait;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Modules\HR\Http\Repositories\Deduct\DeductRepositoryInterface;
use App\Modules\HR\Http\Requests\DeductRequest;
use App\Modules\HR\Transformers\DeductResource;
use App\Modules\HR\Http\Repositories\Employee\EmployeeRepositoryInterface;
use App\Modules\HR\Http\Repositories\Management\ManagementRepositoryInterface;
use App\Modules\HR\Http\Requests\DeductStatusRequest;


class DeductsController extends Controller
{
    use ApiResponseTrait;

    public function __construct(
        private DeductRepositoryInterface $deductRepository,
        private ManagementRepositoryInterface $managementRepository,
        private EmployeeRepositoryInterface $employeeRepository)
    {
        // $this->middleware('permission:list-deducts')->only('index');
        // $this->middleware('permission:show-deducts')->only(['show']);
        // $this->middleware('permission:create-deducts')->only('store');
        // $this->middleware('permission:edit-deducts')->only('update');
    }

    public function index(Request $request)
    {

        $deducts = $this->deductRepository->setFilters()->defaultSort('-created_at')
            ->allowedIncludes('employee')
            ->where('type', 'deduct')
            ->allowedSorts($this->deductRepository->sortColumns())
            ->with(['employee', 'addedBy', 'management'])
            ->paginate(Helper::getPaginationLimit($request));


        $data = DeductResource::collection($deducts);
        return $this->paginateResponse($data, $deducts);
    }

    public function store(DeductRequest $request)
    {
        $data = $this->deductRepository->store($request);
        return $this->apiResource(data: DeductResource::make($data) , message: __('Common::message.success_create'));
    }


    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $data = DeductResource::make($this->deductRepository->find($id));
        return $this->apiResource(data: $data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */


    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(DeductRequest $request, $id)
    {
        $data = $request->all();
        $deduct = $this->deductRepository->update($data, $id);
        return DeductResource::make($deduct)->additional([
            'status' => true,
            'message' =>  __('Common::message.success_update'),
        ]);
    }

    public function deductStatus(DeductStatusRequest $request, $id)
    {
        $data = $this->deductRepository->deductStatus($request, $id);
        return $this->apiResource(data: DeductResource::make($data), message: __('Common::message.success_update'));
    }

    public function destroy($id)
    {
        return $this->deductRepository->destroy($id);
    }

    public function getEmployeeByNumber($employee_number)
    {
        return $this->successResponse($this->deductRepository->getEmployeeByNumber($employee_number));
    }

    public function listActiveManagements()
    {
        return $this->successResponse($this->managementRepository->listManagement());
    }

    public function listActiveEmployees(Request $request)
    {
        return $this->successResponse($this->employeeRepository->listEmployees($request));
    }


}
