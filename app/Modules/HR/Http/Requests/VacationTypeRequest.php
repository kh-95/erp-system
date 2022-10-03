<?php

namespace App\Modules\HR\Http\Requests;


use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Config;

class VacationTypeRequest extends FormRequest
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
            'number_days' => 'required|integer'
        ];

        $rules += RuleFactory::make([
            '%name%' => 'required'
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
            'number_days.required' => __('hr::validation.vacationtype.number_days.required'),
            'number_days.integer' => __('hr::validation.vacationtype.number_days.integer')
                   ];
            foreach($langs as $lang) {
                $messages += [
                     $lang.'.name.required' => __('hr::validation.vacationtype.name.required')
                ];
            }
        return $messages;
    
    }
}
