<?php

namespace App\Modules\Collection\Http\Requests;

use App\Modules\Collection\Entities\Order ;
use Astrotomic\Translatable\Validation\RuleFactory;
use Config;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class OrderRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $order_types = join(',', Order::ORDER_TYPES);
        $rules = [
            'order_date' => 'required|date_format:Y-m-d|after_or_equal:today',
            'customer_id' => 'required|int',
            'order_type' => "required|in:$order_types",
            'customer_type' => 'required|in:mobile,identity',
            'mobile' => 'required_if:customer_type,=,mobile',
            'identity' => 'required_if:customer_type,=,identity',
            'attachments' => 'sometimes|array|max:25000',
            'attachments.*' => 'mimes:jpg,png,jpeg,pdf,docx,txt,video/avi,video/mpeg,mp3,mp4
                                video/quicktime,zip|required|max:1000',
        ];

        $rules += RuleFactory::make([
            '%order_subject%' => 'required|max:100',
            '%order_text%' => 'required|nullable|max:1000|string'
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

    public function messages()
    {
        $langs = Config::get('translatable.locales');
        $messages = [
            'customer_id.required' => __('collection::validation.order.customer.required'),
            'order_types.in' => __('collection::validation.order.order_types.in'),
            'customer_type.in' => __('collection::validation.order.customer_type.in'),
            'order_subject.required' => __('collection::validation.order.order_subject.required'),
            'order_subject.max' => __('collection::validation.order.order_subject.max'),
        ];

        return $messages ;
    }
}
