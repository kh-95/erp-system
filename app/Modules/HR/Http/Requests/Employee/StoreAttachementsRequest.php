<?php

namespace App\Modules\HR\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class StoreAttachementsRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'attachments' => 'required|array',
            'attachments.*' => 'image|mimes:jpg,png,jpeg|required|max:3000',
            'attachments.identity_photo' => 'required',
            'attachments.qualification_photo' => 'required',
        ];
    }

    protected function failedValidation(Validator $validator)
    { 
        throw (new ValidationException($validator, response(['error' => $validator->errors()->first()])));
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
