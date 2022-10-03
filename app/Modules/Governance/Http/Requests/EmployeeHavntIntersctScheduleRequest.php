<?php

namespace App\Modules\Governance\Http\Requests;

use App\Modules\HR\Entities\Management;
use Illuminate\Foundation\Http\FormRequest;

class EmployeeHavntIntersctScheduleRequest extends FormRequest
{

    use PublicMeetingRequest;
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $managementTable = Management::getTableName();
        return [
            'start_at' => ["required",function ($attribute, $value, $fail) {
                if(!$this->validateDateTime($value)){
                    $fail('The '.$attribute.' is invalid format.');
                }
            },],
            'end_at' => ["required","after_or_equal:start_at",function($attribute, $value, $fail){
                if(!$this->validateDateTime($value)){
                    $fail('The '.$attribute.' is invalid format.');
                }
            }],
            'management_id'=> "required|exists:{$managementTable},id",
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
