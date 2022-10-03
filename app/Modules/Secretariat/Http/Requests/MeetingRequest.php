<?php

namespace App\Modules\Secretariat\Http\Requests;

use App\Foundation\Classes\Helper;
use App\Modules\Secretariat\Rules\{AvailableMeetingRoomRule,UpdateAvailableMeetingRoomRule};
use Illuminate\Foundation\Http\FormRequest;
use Astrotomic\Translatable\Validation\RuleFactory;

class MeetingRequest extends FormRequest
{

    public function rules()
    {
        return request()->method() === 'POST' ? $this->storeRules() : $this->updateRules();
    }

    private function storeRules() :array
    {

        $dateTime = Helper::ConcatenateDateTime($this->date, $this->time, $this->time_format);
        $rules = RuleFactory::make([
            '%title%' => 'required|max:150',
            'employee_id' => 'required',
            'date' => ['required','date_format:d-m-Y', new AvailableMeetingRoomRule($this->meeting_room_id, $this->meeting_duration, $dateTime)],
            'time' => ['required', 'date_format:H:i'],
            'time_format' => 'required|in:AM,PM',
            'meeting_room_id' => 'required|int',
            'type' => 'required|in:cyclic,sudden,suitable',
            'meeting_duration' => 'required|int|max:999',
            '%note%' => 'required|max:500',
            'employees' => 'required_if:type,=,cyclic|required_if:type,=,sudden|array',
            'discussion_points' => 'required|array',
            'discussion_points.*.%content%' => 'required',
            'decisions' => 'sometimes|array',
            'decisions.*.%content%' => 'required',
        ]);

        return $rules;
    }

    private function updateRules() :array
    {
        $meeting_id = request('id');
        $dateTime = Helper::ConcatenateDateTime($this->date, $this->time, $this->time_format);
        $rules = RuleFactory::make([
            '%title%' => 'required|max:150',
            'employee_id' => 'required',
            'date' => ['required','date_format:d-m-Y', new UpdateAvailableMeetingRoomRule($this->meeting_room_id, $this->meeting_duration, $dateTime, $meeting_id)],
            'time' => ['required', 'date_format:H:i'],
            'time_format' => 'required|in:AM,PM',
            'meeting_room_id' => 'required',
            'type' => 'required',
            'meeting_duration' => 'required|int|max:999',
            '%note%' => 'required|max:500',
            'employees' => 'sometimes|array',
            'discussion_points' => 'sometimes|array',
            'discussion_points.*.%content%' => 'required',
            'decisions' => 'sometimes|array',
            'decisions.*.%content%' => 'required',
        ]);

        return $rules;
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
