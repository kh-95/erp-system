<?php

namespace App\Modules\Finance\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CashRegisterStoreRequest extends FormRequest
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
            'attachments' => 'required|array|max:25000',
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

    public function messages()
    {
        // use trans instead on Lang
        return [
            'tranfer_number.required' => __('finance::validations.cashRegister.tranfer_number.required'),
            'money.required' => __('finance::validations.cashRegister.money.required'),
            'date.required' => __('finance::validations.cashRegister.date.required'),
            'from_register.required' => __('finance::validations.cashRegister.from_register.required'),
            'to_register.required' => __('finance::validations.cashRegister.to_register.required'),
            'bank_id.required' => __('finance::validations.cashRegister.bank_id.required'),
            'check_number.required' => __('finance::validations.cashRegister.check_number.required'),
            'check_number_date.required' => __('finance::validations.cashRegister.check_number_date.required'),
            'attachments.required' => __('finance::validations.cashRegister.attachments.required'),
        ];
    }
}
