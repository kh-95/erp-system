<?php

namespace App\Modules\Finance\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NotificationUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type' => 'required|in:adding, equation, discount',
            'way' => 'required|in:customer, customerWithService',
            'notification_number' => 'required',
            'date' => 'required|date_format:Y-m-d',
            'management_id' => 'required|int',
            'notification_name' => 'required',
            'price' => 'required',
            'complaint_number' => 'required',
            'customer_id' => 'required|int',
            'to_customer_id' => 'required_if:type,==,equation|int',
            'attachments' => 'sometimes|array|max:25000',
            'attachments.*' => 'mimes:jpg,png,jpeg,pdf,docx,txt,video/avi,video/mpeg,mp3,mp4
                                video/quicktime,zip|required|max:1000',
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
