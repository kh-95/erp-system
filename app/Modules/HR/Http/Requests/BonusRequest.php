<?php

namespace App\Modules\HR\Http\Requests;

use App\Modules\HR\Entities\DeductBonus;
use App\Modules\HR\Entities\Employee;
use App\Modules\HR\Entities\Management;
use Illuminate\Foundation\Http\FormRequest;

class BonusRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $action_types = join(',', DeductBonus::ACTION_TYPE);
        $duration_type = join(',', DeductBonus::DURATION_TYPE);
        $managements_table = Management::getTableName();
        $employees_table = Employee::getTableName();

        return [
            'employee_number' => 'required|max:15',
            'management_id' => "required|exists:$managements_table,id",
            'employee_id' => "required|exists:$employees_table,id",
            'action_type' => "required|in:{$action_types}",
            "amount" => ['required', 'regex:/^\\d{1,4}$|^\\d{1,4}\\.\\d{0,2}$/', 'numeric','gt:0'],
            'duration_type' => "nullable|required_if:action_type,duration|in:{$duration_type}",
            'duration' => ['required_with:duration_type','regex:/^\\d{1,2}$|^\\d{1,2}\\.\\d{0,2}$/','numeric','gt:0'],
            'notes' => "nullable|regex:/^[A-Za-z0-9()\]\s\[#%&*_=~{}^:`.,$!@+\/-]+$/|min:10|max:300",
            'is_active' => "nullable|in:0,1"

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
