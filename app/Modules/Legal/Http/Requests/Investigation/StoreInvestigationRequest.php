<?php

namespace App\Modules\Legal\Http\Requests\Investigation;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvestigationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'month_one'               => 'required|date|date_format:Y-m-d',
            'month_one_hijri'         => 'required|date|date_format:Y-m-d',
            'month_two'               => 'required|date|date_format:Y-m-d',
            "month_two_hijri"         => 'required|date|date_format:Y-m-d',
            'old_investigation_count' => "nullable|numeric",
            'subject'                 => "required|regex:/^[A-Za-z0-9()\]\s\[#%&*_=~{}^:`.,$!@+\/-]+$/|max:100",
            'reason'                  => "required|regex:/^[A-Za-z0-9()\]\s\[#%&*_=~{}^:`.,$!@+\/-]+$/|max:1000",
            'asigned_employee'        => "required|exists:hr_employees,id",
            'management_id'           => 'required|exists:hr_management,id',
            'employee_id'             => 'required|exists:hr_employees,id',
            'attachments'             => 'nullable|array',
            'attachments.*'           => 'nullable|mimes:pdf,docx,jpg,jpeg,png|max:100000'

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
