<?php

namespace App\Modules\Governance\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NotificationResponseRequest extends FormRequest
{
    public function rules()
    {
        return [
            'response' => 'required|min:10|max:500|regex:/(^[a-zA-Z0-9_ ]+$)+/',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
