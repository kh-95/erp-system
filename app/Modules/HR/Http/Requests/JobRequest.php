<?php

namespace App\Modules\HR\Http\Requests;

use App\Modules\HR\Entities\Job;
use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Config;
use Illuminate\Validation\Rules\Enum;

class JobRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $salary_types = join(',', Job::SALARY_TYPES);
        $rules = [
            'management_id' => 'required|integer',
            'is_manager' => 'sometimes|nullable|boolean',
            'employees_job_count' => 'sometimes|nullable|integer',
            'deactivated_at' => 'sometimes|nullable|boolean',
            'salary_type' => "required|in:{$salary_types}",
        ];

        $rules += RuleFactory::make([
            '%name%' => 'required|max:100',
            '%description%' => 'sometimes|nullable|max:1000|string'
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
        $langs = Config::get('translatable.locales');
        $messages = [
            'management_id.required' => __('hr::validation.job.management.requierd'),
            'salary_types.in' => __('hr::validation.job.salary_types.in'),
        ];
        foreach($langs as $lang) {
            $messages += [
                 $lang.'name.required' => __('hr::validation.job.name.requierd'),
                 $lang.'name.max' => __('hr::validation.job.name.max'),
                 $lang.'name.regex' => __('hr::validation.name.regex'),
            ];
        }
        return $messages ;
    }
}
