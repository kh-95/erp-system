<?php

namespace App\Modules\HR\Http\Requests\PermissionRequest;

use Illuminate\Foundation\Http\FormRequest;

class updatePermissionRequestRequest extends FormRequest
{
    public function rules()
    {
        return [
            'status' => 'required|in:accepted,rejected'
        ];
    }


    public function authorize()
    {
        return true;
    }
}
