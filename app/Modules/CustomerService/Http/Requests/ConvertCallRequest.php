<?php

namespace App\Modules\CustomerService\Http\Requests;

use App\Modules\HR\Entities\Employee;
use Illuminate\Foundation\Http\FormRequest;

class ConvertCallRequest extends FormRequest
{
    public function rules()
    {
        return [
            'employee_id' => 'required|exists:' . Employee::getTableName() . ',id'
        ];
    }

    public function authorize()
    {
        return true;
    }
}
