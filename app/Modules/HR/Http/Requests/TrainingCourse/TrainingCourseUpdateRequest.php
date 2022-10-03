<?php

namespace App\Modules\HR\Http\Requests\TrainingCourse;

use Illuminate\Foundation\Http\FormRequest;
use Astrotomic\Translatable\Validation\RuleFactory;

class TrainingCourseUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'management_id'              => 'integer',
            'employee_id'                => 'integer',
            'attachments'                => 'nullable|array',
            "number"                     => 'max:20',
            "from_date"                  => 'date',
            "to_date"                    => 'date',
            "actual_from_date"           => 'date',
            "actual_to_date"             => 'date',
            "expected_fees"              => 'nullable',
        ];

        $rules += RuleFactory::make([
            "%notes%"              => 'nullable',
            "%rejection_cause%"    => 'nullable',
            "%course_name%"        => 'max:100',
            "%organization_type%"  => 'string',
            "%organization_name%"  => 'string',
            "%status%"             => 'nullable',
            "%actual_start_status%"=> 'nullable'
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
