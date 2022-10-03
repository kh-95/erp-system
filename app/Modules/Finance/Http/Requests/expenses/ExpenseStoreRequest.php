<?php

namespace App\Modules\Finance\Http\Requests\expenses;

use Illuminate\Foundation\Http\FormRequest;

class ExpenseStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'pay_status' => 'required|in:check,bank',
            'customer_type' => 'required|in:cutomer,customer_with_service,account',
            'date' => 'required|date_format:Y-m-d',
            'certificate_number' => 'required|digits:10',
            'money' => 'required',
            'from_cash_register' => 'required|int',
            'to_cash_register' => 'required|int',
            'management_id' => 'required|int',

            'attachments' => 'sometimes|array|max:25000',
            'attachments.*' => 'mimes:jpg,png,jpeg,pdf,docx,txt,video/avi,video/mpeg,mp3,mp4
                                video/quicktime,zip|required|max:1000',

            'expensesCustomer' =>'required_if:customer_type,==,cutomer|array',
            'expensesCustomer.customer_id' =>'required_if:customer_type,==,cutomer|int',
            'expensesCustomer.customer_identity' =>'required_if:customer_type,==,cutomer|digits:13',
            'expensesCustomer.phone' =>'required_if:customer_type,==,cutomer',
            'expensesCustomer.premium' =>'required_if:customer_type,==,cutomer|in:waiting, late , owed',
            'expensesCustomer.his_money' => 'required_if:customer_type,==,cutomer',

           'expensesCustomerService' => 'required_if:customer_type,==,customer_with_service|array',
           'expensesCustomerService.customer_id' => 'required_if:customer_type,==,customer_with_service|int',
           'expensesCustomerService.register_id' => 'required_if:customer_type,==,customer_with_service|int',
           'expensesCustomerService.tax_id' => 'required_if:customer_type,==,customer_with_service|int',
           'expensesCustomerService.iban' => 'required_if:customer_type,==,customer_with_service',

           'expensesCustomerAccount' => 'required_if:customer_type,==,account|array',
           'expensesCustomerAccount.account_sympolize' => 'required_if:customer_type,==,account',
           'expensesCustomerAccount.iban' => 'required_if:customer_type,==,account'
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
