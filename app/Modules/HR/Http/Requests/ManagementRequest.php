<?php

namespace App\Modules\HR\Http\Requests;

use App\Modules\HR\Entities\Management;
use App\Modules\HR\Entities\ManagementTranslation;
use App\Modules\HR\Rules\DeactivateManagementRule;
use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Config;


class ManagementRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $rules = [
            'parent_id' => 'sometimes|nullable|integer',
            'status' => 'nullable',
            'deactivated_at' => [
                'sometimes',
                'nullable',
                'boolean',
                new DeactivateManagementRule($this->route('management'))
            ],
        ];

        $rules += RuleFactory::make([
            '%name%' => 'required|max:100|string|unique:'.ManagementTranslation::getTableName().',name,'.$this->management,
            '%description%' => 'sometimes|nullable|max:500|string',
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
        $messages = [];
        foreach ($langs as $lang) {
            $messages += [
                $lang . '.name.required' => __("hr::validation.management.name.required"),
                $lang . '.name.string' => __("hr::validation.management.name.string"),
                $lang . '.name.max' => __('hr::validation.management.name.max'),
                $lang . '.name.regex' => __('hr::validation.management.name.regex'),
                $lang . '.name.unique' => __('hr::validation.management.name.unique'),
                $lang . '.description.max' => __('hr::validation.management.description.max')

            ];

        }
        return $messages;
    }
}
