<?php

namespace App\Modules\RiskManagement\Http\Requests;

use App\Modules\RiskManagement\Entities\NotificationTerm;
use Illuminate\Foundation\Http\FormRequest;

class NotificationRequest extends FormRequest
{
    public function rules()
    {
        $rules =  [
            'title'   => 'required|string|min:2|max:100',
            'body'    => 'required|string|min:10|max:300',
            'is_active' => 'required|in:0,1',
            'terms' => 'required|array|min:1',
            'terms.*.field'  => 'required|in:' . implode(',', NotificationTerm::FIELDS),
            'terms.*.operator'  => 'required|in:' . implode(',', NotificationTerm::OPERATORS),
            'terms.*.join_operator'  => 'nullable',
            'terms.*.order'  => 'required|numeric',
            'terms.*.value'  => ['required', 'max:20'],
        ];

        if ($this->isMethod('PUT')) {
            $rules['terms.*.id'] = 'exists:risk_management_notification_terms,id';
        }

        return $rules;
    }

    public function authorize()
    {
        return true;
    }
}
