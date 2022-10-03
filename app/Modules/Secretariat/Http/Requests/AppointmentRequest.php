<?php

namespace App\Modules\Secretariat\Http\Requests;
use App\Foundation\Classes\Helper;
use Illuminate\Foundation\Http\FormRequest;
use Astrotomic\Translatable\Validation\RuleFactory;

class AppointmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return request()->method() === 'POST' ? $this->storeRules() : $this->updateRules();
    }

    private function storeRules() :array
    {
        $dateTime = Helper::ConcatenateDateTime($this->date, $this->time, $this->time_format);
        $rules = [
            'employee_id' => 'required',
            'date' => 'required|date_format:d-m-Y',
            'time' => 'required|date_format:H:i',
            'time_format' => 'required|in:AM,PM',
        ];

        $rules += RuleFactory::make([
            '%title%' => 'required|max:150|string|regex:/^[A-Za-z0-9()\]\s\[\/-]+$/',
            '%details%'=>'sometimes|max:1000|string|regex:/^[A-Za-z0-9()\]\s\[\/-]+$/'
        ]);


        return $rules;
    }

    private function updateRules() :array
    {
        $dateTime = Helper::ConcatenateDateTime($this->date, $this->time, $this->time_format);
        $rules = [
            'employee_id' => 'required',
            'date' => 'required|date_format:d-m-Y',
            'time' => 'required|date_format:H:i',
            'time_format' => 'required|in:AM,PM',
        ];

        $rules += RuleFactory::make([
            '%title%' => 'required|max:150|string',
            '%details%'=>'sometimes|max:1000|string'
        ]);
        return $rules;

    }

    /**
     * Get validation messages.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            "employee_id.required" => __("secretariat::validation.appointment.employee_id.required"),
            'date.required' => __("secretariat::validation.appointment.appointment_date.required"),
            'date.date' => __("secretariat::validation.appointment.appointment_date.date"),
            'time.required' => __("secretariat::validation.appointment.appointment_time.required"),
            'time_format.required' => __("secretariat::validation.appointment.appointment_am.required"),
            "title.required" => __("secretariat::validation.appointment.title.required"),
            "title.max" => __("secretariat::validation.appointment.title.max"),
            "title.string" => __("secretariat::validation.appointment.title.string"),
        ];
    }
}
