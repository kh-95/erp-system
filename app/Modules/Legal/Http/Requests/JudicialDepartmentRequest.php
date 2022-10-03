<?php

namespace App\Modules\Legal\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JudicialDepartmentRequest extends FormRequest
{
    public function rules()
    {
        foreach (config('translatable.locales') as $locale) {
            $rules["$locale"]  = "array";
            $rules["$locale.name"] = "required|string|max:50";
            $rules["$locale.description"] = "required|max:1000";
        }

        $rules["email"]  = "nullable|email|max:50";
        $rules["court"]  = "required|string|max:50";
        $rules["area"]   = "nullable|string|max:50";
        return $rules;
    }

    public function authorize()
    {
        return true;
    }
}