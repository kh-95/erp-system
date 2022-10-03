<?php

namespace App\Modules\HR\Http\Requests\HoldHarmless;

use Illuminate\Foundation\Http\FormRequest;
use Astrotomic\Translatable\Validation\RuleFactory;

class ItRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = RuleFactory::make([
            'it_response' => 'required|in:accepted,rejected',
            '%it_note%' => 'required|max:500',
            '%it_rejection_reason%' => 'required_if:it_response,==,rejected|max:150',
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
