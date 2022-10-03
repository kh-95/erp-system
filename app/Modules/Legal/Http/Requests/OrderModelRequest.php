<?php

namespace App\Modules\Legal\Http\Requests;

use App\Modules\HR\Entities\Employee;
use App\Modules\HR\Entities\Management;
use Illuminate\Foundation\Http\FormRequest;

class OrderModelRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $managment_table = Management::getTableName();
        $employee_table = Employee::getTableName();

        $arr_files = 'required|array';
        $files = 'required|mimes:jpeg,png,jpg,docx,pdf|max:2048';
        if ($this->order_model) {
            $arr_files = 'nullable|array';
            $files = 'nullable|mimes:jpeg,png,jpg,docx,pdf|max:2048';
        }

        return [
            'management_id' => "required|exists:$managment_table,id",
            'employee_id' => "required|exists:$employee_table,id",
            'request_subject' => "required|regex:/^[\pL\pN\s\-\_]+$/u",
            'request_text' => 'required|array',
            'request_text.*.text' => 'required|between:10,1000',
            'request_date' => 'required|date',
            'files' => $arr_files,
            'files.*' => $files,
            'islamic_date' => 'required|date'
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
