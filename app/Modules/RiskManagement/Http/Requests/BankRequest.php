<?php

namespace App\Modules\RiskManagement\Http\Requests;

use App\Modules\RiskManagement\Entities\BankTranslation;
use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Config;

class BankRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $rules = [
            "is_active" => "in:0,1",
        ];

        foreach (config('translatable.locales') as $locale) {
            $rules["$locale"] = "array";
            $rules["$locale.name"] = "required|min:2|max:100|regex:/^[\pL\pN\s\-\_]+$/u|unique:rm_bank_translations,name," . @$this->bank . ",bank_id";
        }

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
