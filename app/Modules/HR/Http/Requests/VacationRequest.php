<?php

namespace App\Modules\HR\Http\Requests;


use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Config;

class VacationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules =[
            'number_days' => 'required|integer',
            'vacation_from_date'=>'required|date',
            'vacation_to_date'=>'sometimes|nullable',
            'vacation_employee_id'=>'sometimes|nullable',
            'vacation_type_id'=>'sometimes|nullable',
            'vacation_to_date'=>'sometimes|nullable',
            'alter_employee_id'=>'sometimes|nullable',
        ];

        return $rules;
    }

    /**
     * Get validation messages.
     *
     * @return array
     */
    public function messages(): array
    {
        $messages =[
            'number_days.required' => __('hr::validation.vacation.number_days.required'),
            'number_days.integer' => __('hr::validation.vacation.number_days.integer'),
            'vacation_from_date.required' => __('hr::validation.vacation.vacation_from_date.required'),
            'vacation_from_date.date' => __('hr::validation.vacation.vacation_from_date.date')
                  ];
    
        return $messages;
    }
}
