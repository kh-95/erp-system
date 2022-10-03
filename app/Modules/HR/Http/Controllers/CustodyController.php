<?php

namespace App\Modules\HR\Http\Controllers;

use App\Foundation\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Modules\HR\Http\Repositories\Employee\CustodyRepositoryInterface;
use App\Modules\HR\Http\Requests\Employee\CustodyRequest;

class CustodyController extends Controller
{
    use ApiResponseTrait;

    private CustodyRepositoryInterface $custodyEmployeeRepository;

    public function __construct(CustodyRepositoryInterface $custodyEmployeeRepository)
    {
        $this->custodyEmployeeRepository = $custodyEmployeeRepository;
    }

    public function store(CustodyRequest $request, $id)
    {
        try
        {
            $this->custodyEmployeeRepository->create(array_merge(['employee_id'=> $id], $request->all()));
            return $this->successResponse(true);
        } catch (\Exception $exception) {
            return $this->errorResponse(null, 500 , $exception->getMessage());
        }
    }

    public function update(CustodyRequest $request, $id)
    {
        try
        {
            $this->custodyEmployeeRepository->update($request->all(), $id);
            return $this->successResponse(true);
        } catch (\Exception $exception) {
            return $this->errorResponse(null, 500 , $exception->getMessage());
        }
    }

    public function destroy($id)
    {
        try
        {
            $this->custodyEmployeeRepository->delete($id);
            return $this->successResponse(true);
        } catch (\Exception $exception) {
            return $this->errorResponse(null, 500 , $exception->getMessage());
        }
    }
}
