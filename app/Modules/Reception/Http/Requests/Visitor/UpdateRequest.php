<?php

namespace App\Modules\Reception\Http\Requests\Visitor;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'identity_number' => 'sometimes',
            'name' => 'required|max:150',
        ];
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
        // use trans instead on Lang
        return [
            'name.required' => __('reception::validation.visit.visitors.name'),
        ];
    }
}
