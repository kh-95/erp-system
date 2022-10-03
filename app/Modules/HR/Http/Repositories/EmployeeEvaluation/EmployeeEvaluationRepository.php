<?php

namespace App\Modules\HR\Http\Repositories\EmployeeEvaluation;

use App\Foundation\Traits\ApiResponseTrait;
use App\Foundation\Traits\ImageTrait;
use App\Modules\HR\CustomSorts\BonusManagementSort;
use App\Modules\HR\Entities\Employee;
use App\Modules\HR\Entities\EmployeeEvaluation;
use App\Modules\HR\Entities\EmployeeJobInformation;
use App\Modules\HR\Entities\Job;
use App\Modules\HR\Entities\JobTranslation;
use App\Modules\HR\Entities\Management;
use App\Modules\HR\Entities\ManagementTranslation;
use App\Modules\HR\Http\Requests\EvaluateEmployeeRequest;
use App\Modules\HR\Transformers\EmployeeEvaluationResource;
use App\Repositories\CommonRepository;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class EmployeeEvaluationRepository extends CommonRepository implements EmployeeEvaluationRepositoryInterface
{
    use ImageTrait, ApiResponseTrait;
    protected function filterColumns(): array
    {
        return [
            'management_id',
            'employee_id',
            'job_id',
            'evaluation_date',
            'recommndation',
            'started_at',
            'ended_at'
        ];
    }
    public function sortColumns()
    {
        return [

            $this->sortUsingRelationship('employee-name',Employee::getTableName().'.'. EmployeeEvaluation::getTableName().'.'.'employee_id.first_name'),
            $this->sortUsingRelationship('management-name',ManagementTranslation::getTableName().'.'. EmployeeEvaluation::getTableName().'.'.'management_id.name'),
            $this->sortUsingRelationship('job-name',JobTranslation::getTableName().'.'. EmployeeEvaluation::getTableName().'.'.'job_id.name'),
            'evaluation_date',
            'started_at',
            'recommndation',
        ];
    }

    public function employeeJob(Request $request)
    {
        $empJobInfoTable = EmployeeJobInformation::getTableName();
        $jobTable = Job::getTableName();
        $jobTranslationTable = JobTranslation::getTableName();

        $job = \DB::table($jobTable)->distinct()
            ->join($empJobInfoTable, "{$empJobInfoTable}.job_id", "{$jobTable}.id")
            ->join($jobTranslationTable, "{$jobTranslationTable}.job_id", "{$jobTable}.id")
            ->where("{$empJobInfoTable}.employee_id", $request->employee_id)
            ->select("{$jobTable}.id", "{$jobTranslationTable}.name")
            ->first();
        if (!$job) {
            return $this->errorResponse(null, false, '', 404);
        }
        return $job;
    }

    public function model()
    {
        return EmployeeEvaluation::class;
    }

    public function show($id)
    {
        $employee_evaluation = $this->find($id);
        return $this->apiResource(EmployeeEvaluationResource::make($employee_evaluation));
    }
    public function updateEmployeeEvaluation(EvaluateEmployeeRequest $request, $id)
    {
        $employee_evaluation = $this->find($id);
        $evaluate_items = $request->except('items');

        $arr = $this->formatRequestData($request);
        $employee_evaluation->update($evaluate_items);
        $employee_evaluation->items()->sync($arr);
        $employee_evaluation->load(['management', 'employee', 'employeeeEvaluatiuons']);
        return $this->apiResource(EmployeeEvaluationResource::make($employee_evaluation), true, __('Common::message.success_update'));
    }




    public function store(EvaluateEmployeeRequest $request)
    {

        $evaluate_items = $request->except('items');

        $arr = $this->formatRequestData($request);
        $employee_evaluation = $this->create($evaluate_items);

        $employee_evaluation->items()->attach($arr);
        $employee_evaluation->load(['management', 'employee', 'employeeeEvaluatiuons']);
        return $this->apiResource(EmployeeEvaluationResource::make($employee_evaluation), true, __('Common::message.success_create'), code: 201);
    }


    private function formatRequestData($request)
    {
        foreach ($request->items as $item) {
            $arr[$item['item_id']] = ['is_passed' => $item['is_passed']];
        }
        return $arr;
    }

    public function edit($id)
    {
        $employee_evaluation = $this->find($id);
        return $this->apiResource(EmployeeEvaluationResource::make($employee_evaluation));
    }

    public function destroy($id)
    {
        $type = $this->find($id);
        $this->delete($id);
        return $this->successResponse(['message'=>__('finance::messages.employee_evaluation.deleted_successfuly')]);
    }

}
