<?php

namespace App\Modules\HR\Http\Requests\PermissionRequest;

use Illuminate\Foundation\Http\FormRequest;

class updateHrPermissionRequestRequest extends FormRequest
{
    public function rules()
    {
        return [
            'status' => 'required|in:accepted_with_deduct,accepted_without_deduct,rejected'
        ];
    }


    public function authorize()
    {
        return true;
    }
}
