<?php

namespace App\Modules\Governance\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StrategicPlanRequest extends FormRequest
{

    public function rules()
    {
        $rules = [
            'from' => 'required|numeric|min:2000|max:2100',
            'to' => 'required|numeric|min:2000|max:2100|gte:from',
            'is_active' => 'nullable|in:0,1',
            'achieved' => 'nullable|min:0|max:100',
            'tasks' => 'array|required',
            'tasks.*.value' => 'required|string|min:10|max:100',
            'goals' => 'array|required',
            'goals.*.value' => 'required|string|min:10|max:100',
            'terms' => 'array|required',
            'terms.*.value' => 'required|string|min:10|max:100',
            'requirements' => 'array|required',
            'requirements.*.value' => 'required|string|min:10|max:100',
            'requirements.*.achievement_method' => 'required|string|min:10|max:100',
            'file_type' => 'required_with:attachments|in:video,image,document',
            'attachments' => 'nullable|array|required_with:file_type',

        ];


        if ($this->isMethod('PUT')) {
            $rules['tasks.*.id'] = 'exists:gc_strategic_plan_attributes,id';
            $rules['goals.*.id'] = 'exists:gc_strategic_plan_attributes,id';
            $rules['terms.*.id'] = 'exists:gc_strategic_plan_attributes,id';
            $rules['requirements.*.id'] = 'exists:gc_strategic_plan_attributes,id';
        }


        foreach (config('translatable.locales') as $locale) {
            $rules["$locale"]  = "array";
            $rules["$locale.title"] = "required|string|min:2|max:100|unique:gc_strategic_plan_translations,title";
            $rules["$locale.vision"] = "required|string|min:10|max:500";
        }


        if (request()->file_type == "video") {
            $rules["attachments.*"] = "nullable|mimes:mp4,mov,wmv,avi,flv|max:10240";
        } elseif (request()->file_type == "document") {
            $rules["attachments.*"] = "nullable|mimes:txt,doc,docx,pdf,xlsx,rar|max:10240";
        } else
            $rules["attachments.*"] = "nullable|mimes:jpg,jpeg,png|max:10240";

        return $rules;
    }

    public function authorize()
    {
        return true;
    }
}
