<?php

namespace App\Modules\Reception\Http\Requests\Visit;

use Illuminate\Foundation\Http\FormRequest;
use Astrotomic\Translatable\Validation\RuleFactory;

class StoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = RuleFactory::make([
            '%type%' => 'required|max:150',
            '%note%' => 'sometimes|max:500',
            'date' => 'required|date_format:Y-m-d|after_or_equal:today',
            'time'=>'required|date_format:H:i',
            'time_type'=>'required|in:pm,am',
            'management_id'=> 'required|int',
            'status' => 'required|in:new,underway,finished,canceled',
            'visitors' => 'required|array',
            'visitors.*.identity_number' => 'required',
            'visitors.*.name' => 'required',
            'employees' => 'required|array',
            'employees.*.employee_id' => 'required|int',
        ]);

        return  $rules;
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
            'date.required' => __('reception::validation.visit.date.required'),
            'date.after_or_equal' => __('reception::validation.visit.date.after_or_equal'),
            'time.required' => __('reception::validation.visit.time'),
            'time_type.required' => __('reception::validation.visit.time_type'),
            'management_id.required' => __('reception::validation.visit.management_id'),
            'type.required' => __('reception::validation.visit.type.requierd'),
            'type.max' => __('reception::validation.visit.type.max'),
            'status.required' => __('reception::validation.visit.status'),
            'visitors.required' => __('reception::validation.visit.visitors.requierd'),
            'visitors.*.name.required' => __('reception::validation.visit.visitors.name'),
            'visitors.*.identity_number.required' => __('reception::validation.visit.visitors.identity_number'),
            'employees.required' => __('reception::validation.visit.employees.requierd'),
            'employees.*.employee_id.required' => __('reception::validation.visit.employee_id'),
        ];
    }
}
