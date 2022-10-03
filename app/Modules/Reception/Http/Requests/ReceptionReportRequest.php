<?php

namespace App\Modules\Reception\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Astrotomic\Translatable\Validation\RuleFactory;

class ReceptionReportRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = RuleFactory::make([
            '%title%' => 'required|max:150',
            'management_id' => 'required|integer',
            '%description%' => 'sometimes|nullable|max:500|string',
            'date' => 'required|date_format:Y-m-d|after_or_equal:today',
            'time' => 'required',
            'time_type' => 'required',
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
            'title.required' => __('reception::validation.reception_report.title.requierd'),
            'title.max' => __('reception::validation.reception_report.title.max'),
            'title.regex' => __('reception::validation.reception_report.regex'),
            'management_id.required' => __('reception::validation.reception_report.management.requierd'),
            'date.required' => __('reception::validation.reception_report.date.requierd'),
            'date.after_or_equal' => __('reception::validation.reception_report.date.after_or_equal'),
        ];
    }
}
