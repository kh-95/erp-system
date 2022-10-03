<?php

namespace App\Modules\Governance\Http\Requests;

use App\Modules\Governance\Entities\Committee;
use App\Modules\Governance\Entities\CommitteeTranslation;
use Illuminate\Foundation\Http\FormRequest;

class CommitteeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            "is_active" => "in:0,1",
            'creation_date' => 'required|date',
            'file_type' => 'required|in:' . implode(',', Committee::FILE_TYPES),
            'attachments' => 'nullable|array|required_with:file_type',
            "employees"    => "required|array|min:1",
            'employees.*.id' => 'required',
            'employees.*.is_president' => 'required|in:0,1',
        ];
        foreach (config('translatable.locales') as $locale) {
            $rules["$locale"] = "array";
            $rules["$locale.name"] = "required|min:2|max:100|regex:/^[\pL\pN\s\-\_]+$/u|unique:" . CommitteeTranslation::getTableName() . ",name," . @$this->committee . ",committee_id";
        }

        if (request()->file_type == Committee::VIDEO) {
            $rules['attachments.*'] = 'nullable|mimes:mp4,mov,wmv,avi,flv|max:100000';
        } elseif (request()->file_type == Committee::DOCUMENT) {
            $rules['attachments.*'] = 'nullable|mimes:txt,doc,docx,pdf,xlsx,rar|max:100000';
        } else
            $rules['attachments.*'] = 'nullable|mimes:jpg,jpeg,png|max:100000';

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
