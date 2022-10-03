<?php

namespace App\Modules\HR\Http\Requests;

use App\Modules\HR\Entities\Employee;
use App\Modules\HR\Entities\EmployeeEvaluation;
use App\Modules\HR\Entities\Items\Item;
use App\Modules\HR\Entities\Job;
use App\Modules\HR\Entities\Management;
use Illuminate\Foundation\Http\FormRequest;

class EvaluateEmployeeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $managementTable = Management::getTableName();
        $employeeTable = Employee::getTableName();
        $jobTable = Job::getTableName();
        $itemTable = Item::getTableName();
        $recommndation = join(',',EmployeeEvaluation::RECOMMENDATION);

        return [
            'management_id' => "required|exists:{$managementTable},id",
            'evaluation_date' => "required|date|date_equals:today",
            'started_at' => "required|date",
            'notes' =>'required|max:500|regex:/^[a-zA-Z0-9 ]+$/',
            'ended_at' => "required|after:started_at",
            'employee_id' => "required|exists:{$employeeTable},id",
            'job_id' => "required|exists:{$jobTable},id",
            'recommndation' => "required|in:{$recommndation}",
            'items' => "required|array",
            'items.*.item_id' => "required|exists:{$itemTable},id",
            // 'items.*.employee_evaluation_id' => "required|exists:{$employeeEvaluationTable},id",
            'items.*.is_passed' => "required|in:0,1",
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
