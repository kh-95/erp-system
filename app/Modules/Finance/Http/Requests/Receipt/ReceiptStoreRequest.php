<?php

namespace App\Modules\Finance\Http\Requests\Receipt;

use Illuminate\Foundation\Http\FormRequest;

class ReceiptStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'pay_status' => 'required|in:check,moneyOrder',
            'customer_type' => 'required|in:cutomer,customer_with_service,account',
            'check_number' => 'required_if:pay_status,==,check|digits:10',
            'money_order_number' => 'required_if:pay_status,==,moneyOrder|digits:10',
            'receipt_date' => 'required|date_format:Y-m-d',
            'certificate_number' => 'required|digits:10',
            'certificate_date' => 'required|date_format:Y-m-d',
            'money' => 'required',
            'cash_register' => 'required|int',
            'management_id' => 'required|int',
            'Receipt_request_number' => 'required|digits:10',

            'attachments' => 'sometimes|array|max:25000',
            'attachments.*' => 'mimes:jpg,png,jpeg,pdf,docx,txt,video/avi,video/mpeg,mp3,mp4
                                video/quicktime,zip|required|max:1000',
            'receiptCustomer' =>'required_if:customer_type,==,cutomer|array',
            'receiptCustomer.customer_id' =>'required|int',
            'receiptCustomer.customer_identity' =>'required|digits:13',
            'receiptCustomer.phone' =>'required',
            'receiptCustomer.premium' =>'required|in:waiting, late , owed',
            'receiptCustomer.premium_number' =>'required_if:premium,==,waiting|
                                                  required_if:premium,==,late|
                                                  required_if:premium,==,owed',
            'receiptCustomer.premium_date' =>'required_if:premium,==,waiting|
                                                  required_if:premium,==,late|
                                                  required_if:premium,==,owed|date_format:Y-m-d',

           'receiptCustomer.premium_value' =>'required_if:premium,==,waiting|
                                                 required_if:premium,==,late|
                                                 required_if:premium,==,owed',
           'receiptCustomerService' => 'required_if:customer_type,==,customer_with_service|array',
           'receiptCustomerService.customer_id' => 'required|int',
           'receiptCustomerService.register_id' => 'required|int',
           'receiptCustomerService.tax_id' => 'required|int',
           'receiptCustomerService.iban' => 'required',

           'receiptCustomerAccount' => 'required_if:customer_type,==,account|array',
           'receiptCustomerAccount.account_sympolize' => 'required',
           'receiptCustomerAccount.iban' => 'required'
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
