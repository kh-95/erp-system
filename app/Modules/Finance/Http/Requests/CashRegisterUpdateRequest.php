<?php

namespace App\Modules\Finance\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CashRegisterUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'tranfer_number' => 'required',
            'date' => 'required|date_format:Y-m-d',
            'money' => 'required',
            'from_register' => 'required|int',
            'to_register' => 'required|int',
            'note' => 'sometimes|String|max:500',
            'bank_id' => 'required|int',
            'check_number' => 'required|digits:10',
            'check_number_date' => 'required|date_format:Y-m-d',
            'attachments' => 'sometimes|array|max:25000',
            'attachments.*' => 'mimes:jpg,png,jpeg,pdf,docx,txt|required|max:1000',
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
