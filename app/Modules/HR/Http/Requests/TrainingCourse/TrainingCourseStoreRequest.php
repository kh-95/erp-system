<?php

namespace App\Modules\HR\Http\Requests\TrainingCourse;

use Illuminate\Foundation\Http\FormRequest;
use Astrotomic\Translatable\Validation\RuleFactory;

class TrainingCourseStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'management_id'              => 'required|integer',
            'employee_id'                => 'required|integer',
            'attachments'                => 'nullable|array',
            "number"                     => 'required|max:20',
            "from_date"                  => 'required|date',
            "to_date"                    => 'required|date',
            "actual_from_date"           => 'required|date',
            "actual_to_date"             => 'required|date',
            "expected_fees"              => 'required',
        ];

        $rules += RuleFactory::make([
            "%notes%"              => 'nullable',
            "%rejection_cause%"    => 'nullable',
            "%course_name%"        => 'required|max:100',
            "%organization_type%"  => 'required|string',
            "%organization_name%"  => 'required|string',
            "%status%"             => 'required',
            "%actual_start_status%"=> 'required'
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
}
