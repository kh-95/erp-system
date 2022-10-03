<?php

namespace App\Modules\HR\Http\Requests\Attendance;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAttendanceRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'leaved_at' => 'required',
            'date'      => 'required|date|date_format:Y-m-d'
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
            'leaved_at.required' => __('hr::validation.attendes.leaved_at.required'),
            'date.required' => __('hr::validation.attendes.date.required'),
            'date.date_format' => __('hr::validation.attendes.date.date_format'),
        ];

    }
}
