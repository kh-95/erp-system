<?php

namespace App\Modules\Legal\Http\Requests;

use App\Modules\Legal\Entities\Order;
use Illuminate\Foundation\Http\FormRequest;

class DraftRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $request_types = join(',',Order::REQUEST_TYPES);

        return [
            'job_id'=>'required|exists:hr_jobs,id',
            'employee_id' => 'required|exists:hr_employees,id',
            'request_subject'=>'required|max:100',
            'request_text' => 'required|max:1000',
            'type' => "required|in:{$request_types}",
            'attachments' => 'nullable|array',
            'attachments.*' => 'nullable|mimes:jpg,png,jpeg,doc,docx,pdf|max:20000'

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
