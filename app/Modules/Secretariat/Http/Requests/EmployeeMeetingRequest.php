<?php

namespace App\Modules\Secretariat\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeMeetingRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'status' => 'required|bool',
            'rejected_reason' => 'required_if:status,false',
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
}
