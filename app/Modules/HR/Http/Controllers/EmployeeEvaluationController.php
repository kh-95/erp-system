<?php

namespace App\Modules\HR\Http\Controllers;

use App\Foundation\Classes\Helper;
use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\HR\Http\Repositories\EmployeeEvaluation\EmployeeEvaluationRepositoryInterface;
use App\Modules\HR\Http\Requests\EvaluateEmployeeRequest;
use App\Modules\HR\Transformers\EmployeeEvaluationResource;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class EmployeeEvaluationController extends Controller
{
    use ApiResponseTrait;

    public function __construct(private EmployeeEvaluationRepositoryInterface $employeeEvaluationRepository)
    {
        $this->employeeEvaluationRepository = $employeeEvaluationRepository;
        $this->middleware('permission:list-employee_evaluation')->only('index');
        $this->middleware('permission:show-employee_evaluation')->only(['show']);
        $this->middleware('permission:create-employee_evaluation')->only('store');
        $this->middleware('permission:edit-employee_evaluation')->only('update');
        $this->middleware('permission:edit-employee_evaluation')->only('destroy');

    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $employee_evaluations = $this->employeeEvaluationRepository->setFilters()
            ->defaultSort('-created_at')
            ->allowedSorts($this->employeeEvaluationRepository->sortColumns())
            ->paginate(Helper::getPaginationLimit($request));
        $data = EmployeeEvaluationResource::collection($employee_evaluations);
        return $this->paginateResponse($data, $employee_evaluations);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(EvaluateEmployeeRequest $request)
    {
        return $this->employeeEvaluationRepository->store($request);
    }


    public function getJobForEmpolyee(Request $request)
    {
        return $this->employeeEvaluationRepository->employeeJob($request);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return $this->employeeEvaluationRepository->show($id);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return $this->employeeEvaluationRepository->show($id);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(EvaluateEmployeeRequest $request, $id)
    {
        return $this->employeeEvaluationRepository->updateEmployeeEvaluation($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id): JsonResponse
    {
        return $this->employeeEvaluationRepository->destroy($id);
    }
}
