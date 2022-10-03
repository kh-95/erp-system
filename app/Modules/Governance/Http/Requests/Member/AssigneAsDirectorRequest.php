<?php

namespace App\Modules\Governance\Http\Requests\Member;

use Illuminate\Foundation\Http\FormRequest;

class AssigneAsDirectorRequest extends FormRequest
{
    public function rules()
    {
        return [
            'is_president' => 'required|in:0,1'
        ];
    }

    public function authorize()
    {
        return true;
    }
}
