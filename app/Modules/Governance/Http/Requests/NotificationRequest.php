<?php

namespace App\Modules\Governance\Http\Requests;

use App\Modules\Governance\Entities\Committee;
use App\Modules\HR\Entities\Employee;
use App\Modules\HR\Entities\Management;
use Illuminate\Foundation\Http\FormRequest;

class NotificationRequest extends FormRequest
{
    public function rules()
    {
        $rules =  [
            'title' => 'required|min:3|max:100|regex:/(^[a-zA-Z0-9_ ]+$)+/',
            'body' => 'required|min:10|max:500',
            'management_id' => 'required|exists:' . Management::getTableName() . ',id',
            'employee_id' => 'required|exists:' . Employee::getTableName() . ',id',
        ];

        if (request()->file_type == Committee::VIDEO) {
            $rules['attachments.*'] = 'nullable|mimes:mp4,mov,wmv,avi,flv|max:100000';
        } elseif (request()->file_type == Committee::DOCUMENT) {
            $rules['attachments.*'] = 'nullable|mimes:txt,doc,docx,pdf,xlsx,rar|max:100000';
        } else {
            $rules['attachments.*'] = 'nullable|mimes:jpg,jpeg,png|max:100000';
        }

        return $rules;
    }


    public function authorize()
    {
        return true;
    }
}
