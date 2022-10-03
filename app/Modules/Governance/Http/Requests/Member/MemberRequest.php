<?php

namespace App\Modules\Governance\Http\Requests\Member;

use App\Modules\HR\Entities\Nationality;
use Illuminate\Foundation\Http\FormRequest;

class MemberRequest extends FormRequest
{
    public function rules()
    {
        return [
            'first_name' => 'required|string',
            'second_name' => 'required|string',
            'third_name' => 'required|string',
            'last_name' => 'required|string',
            'identification_number' => 'numeric',
            'nationality_id' => 'exists:' . Nationality::getTableName() . ',id',
            'phone' => 'numeric',
            'identity_date' => '',
            'identity_source' => '',
            'date_of_birth' => '',
            'marital_status' => '',
            'email' => '',
            'gender' => '',
            'qualification' => '',
            'address' => '',
            'company' => '',
            'attachments' => 'nullable|array',
            'attachments.*' => 'nullable|mimes:jpg,png,jpeg,doc,docx,pdf|max:20000',
            'another_certifications' => 'nullable|array',
            'another_certifications.*certificate_name' => 'nullable|string|max:100|min:10|regex:/^[A-Za-z0-9()\]\s\[#%&*_=~{}^:`.,$!@+\/-]+$/',
            'courses' => 'nullable|array',
            'courses.*.course_name' => 'nullable|string|max:100|min:10|regex:/^[A-Za-z0-9()\]\s\[#%&*_=~{}^:`.,$!@+\/-]+$/'
        ];
    }

    public function authorize()
    {
        return true;
    }
}
