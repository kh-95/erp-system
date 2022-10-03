<?php

namespace App\Modules\Legal\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StaticTextRequest extends FormRequest
{
    public function rules()
    {
        foreach (config('translatable.locales') as $locale) {
            $rules["$locale"]  = "array";
            $rules["$locale.name"] = "required|string|max:50|";
            $rules["$locale.description"] = "required|max:1000";
        }

        if ($this->isMethod('PUT')) {
            $rules['is_active'] = 'nullable|in:0,1';
        }

        return $rules;
    }

    public function authorize()
    {
        return true;
    }
}
