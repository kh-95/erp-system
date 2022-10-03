<?php

namespace App\Modules\HR\Http\Requests;


use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Config;

class ResignationupdateRequest extends FormRequest
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
            'management_id' => 'sometimes|nullable',
            'employee_id'=>'sometimes|nullable',
            'job_id'=>'sometimes|nullable',
            'resignation_date'=>'sometimes|nullable',
            'attach' => 'sometimes|nullable',

        ];
        $rules += RuleFactory::make([
            '%reason.*%' => 'sometimes|nullable',
            '%notes%'=>'sometimes|nullable',
        ]);
        return $rules;
    }

    /**
     * Get validation messages.
     *
     * @return array
     */
    public function messages(): array
    {
        $langs = Config::get('translatable.locales');
        $messages =[
        'management_id.required' => __('hr::validation.resignation.management_id.required'),
        'employee_id.required' => __('hr::validation.resignation.employee_id.required'),
                ];
            foreach($langs as $lang) {
                $messages += [
                    $lang.'.reason.required' => __('hr::validation.resignation.reason.required')
                ];
            }
        return $messages;
    }
}
