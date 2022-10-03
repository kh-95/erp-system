<?php

namespace App\Modules\RiskManagement\Http\Requests;

use App\Modules\RiskManagement\Entities\NotificationVendor;
use App\Modules\RiskManagement\Entities\TakenAction;
use Illuminate\Foundation\Http\FormRequest;

class TakenActionRequest extends FormRequest
{
    public function rules()
    {
        $rules =  [
            'taken_action' => 'required|in:' . implode(',', NotificationVendor::TAKEN_ACTIONS),
            'reasons' => 'required',
            'attachments' => 'nullable|array|required_with:file_type',
        ];

        if (request()->file_type == TakenAction::VIDEO) {
            $rules['attachments.*'] = 'nullable|mimes:mp4,mov,wmv,avi,flv|max:100000';
        } elseif (request()->file_type == TakenAction::DOCUMENT) {
            $rules['attachments.*'] = 'nullable|mimes:txt,doc,docx,pdf,xlsx,rar|max:100000';
        } else
            $rules['attachments.*'] = 'nullable|mimes:jpg,jpeg,png|max:100000';

        return $rules;
    }

    public function authorize()
    {
        return true;
    }
}
