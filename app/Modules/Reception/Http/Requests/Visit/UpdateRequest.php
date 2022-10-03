<?php

namespace App\Modules\Reception\Http\Requests\Visit;

use Illuminate\Foundation\Http\FormRequest;
use Astrotomic\Translatable\Validation\RuleFactory;

class UpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = RuleFactory::make([
            'date' => 'sometimes|date_format:Y-m-d|after_or_equal:today',
            'time'=>'sometimes|date_format:H:i',
            'time_type'=>'sometimes|in:pm,am',
            'management_id'=> 'sometimes|int',
            '%type%' => 'sometimes|max:150',
            '%note%' => 'sometimes|max:500',
            'status' => 'sometimes|in:new,underway,finished,canceled',
            'employees' => 'required|array',
            'employees.*.employee_id' => 'required|int',
        ]);
        return $rules;
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

    public function messages()
    {
        // use trans instead on Lang
        return [
            'employees.required' => __('reception::validation.visit.employees.requierd'),
            'employees.*.employee_id.required' => __('reception::validation.visit.employee_id'),
        ];
    }
}
