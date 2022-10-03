<?php

namespace App\Modules\HR\Http\Requests;


use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Config;
class NationalityRequest extends FormRequest
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
       $rules = RuleFactory::make([
            '%name%' => 'required',
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
        $messages = [] ;
            foreach($langs as $lang) {
                $messages += [
                     $lang.'.name.required' => __('hr::validation.nationality.name.required'),
                ];
            }
        return $messages;
    
    }
}
