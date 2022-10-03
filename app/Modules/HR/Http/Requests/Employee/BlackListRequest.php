<?php

namespace App\Modules\HR\Http\Requests\Employee;

use App\Modules\HR\Entities\BlackList;
use Illuminate\Foundation\Http\FormRequest;

class BlackListRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $employee_types = join(',', BlackList::EMPLOYEE_TYPE);

        return [
            'reason' => 'required|max:500|regex:/(^[a-zA-Z0-9_ ]+$)+/',
            'full_name' => ['required', 'regex:/(^[a-zA-Z0-9 ]+$)+/', 'max:100', function ($attribute, $value, $fail) {
                if (count(explode(" ", $value)) != 4) {
                    $fail("The {$attribute} must consists of 4 words.");
                }
            }],
            'identity_number' => ['required', 'digits:10', 'numeric', "unique:hr_black_lists,identity_number,{$this->blacklist}"],
            'phone' => ["required", "numeric", "digits:10", 'starts_with:9665,05', "unique:hr_black_lists,phone,{$this->blacklist}"],
            'employee_type' => "required|in:{$employee_types}",

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
