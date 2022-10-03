<?php

namespace App\Modules\Governance\Http\Requests;

use App\Modules\Governance\Entities\MeetingPlace;
use App\Modules\Governance\Entities\MeetingPlaceTranslation;
use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Config;

class MeetingPlaceRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $meetingPlaceTranslationTable = MeetingPlaceTranslation::getTableName();
        $rules = [
            "is_active" => "in:0,1",
        ];

        foreach (config('translatable.locales') as $locale) {
            $rules["$locale"] = "array";
            $rules["$locale.name"] = "required|min:2|max:100|regex:/^[\pL\pN\s\-\_]+$/u|unique:{$meetingPlaceTranslationTable},name," . @$this->meeting_place . ",meeting_place_id";
        }

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
