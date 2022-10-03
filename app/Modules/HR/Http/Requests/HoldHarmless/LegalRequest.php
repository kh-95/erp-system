<?php

namespace App\Modules\HR\Http\Requests\HoldHarmless;

use Illuminate\Foundation\Http\FormRequest;
use Astrotomic\Translatable\Validation\RuleFactory;

class LegalRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = RuleFactory::make([
            'legal_response' => 'required|in:accepted,rejected',
            '%legal_note%' => 'required|max:500',
            '%legal_rejection_reason%' => 'required_if:legal_response,==,rejected|max:150',
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
