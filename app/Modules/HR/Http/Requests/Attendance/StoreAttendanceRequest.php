<?php

namespace App\Modules\HR\Http\Requests\Attendance;

use App\Modules\HR\Entities\AttendanceFingerprint;
use Illuminate\Foundation\Http\FormRequest;

class StoreAttendanceRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'employee_id' => 'required',
            'attended_at' => 'required',
            'method' => 'required',
            'branch' => 'required'
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

    public function messages()
    {
        return [
            'employee_id.required' => __('hr::validation.attendes.employee.required'),
            'attended_at.required' => __('hr::validation.attendes.attended_at.required'),
            'method.required' => __('hr::validation.attendes.method.required'),
            'branch.required' => __('hr::validation.attendes.branch.required'),
        ];

    }
}
