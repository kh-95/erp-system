<?php

namespace App\Modules\Governance\Http\Requests;

use App\Modules\Governance\Entities\Committee;
use App\Modules\Governance\Entities\Succession;
use App\Modules\HR\Entities\Job;
use App\Modules\HR\Entities\Management;
use Illuminate\Foundation\Http\FormRequest;

class SuccessionRequest extends FormRequest
{



    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $managementTable = Management::getTableName();
        $jobTable = Job::getTableName();
        $plan_from = $this->plan_from;
        $plan_to = $this->plan_to;
        $management_id = $this->management_id;
        $job_id = $this->job_id;


        $Succession_managment = Succession::where(function($q) use($plan_from,$plan_to,$management_id,$job_id){
            $q->whereBetween('plan_from', [$plan_from, $plan_to])
            ->where(['management_id'=> $management_id,]);
            $q->whereBetween('plan_to', [$plan_from, $plan_to])
            ->where(['management_id'=> $management_id,]);
      })->first();

      $Succession_job = Succession::where(function($q) use($plan_from,$plan_to,$management_id,$job_id){
        $q->whereBetween('plan_from', [$plan_from, $plan_to])
        ->where(['job_id'=> $job_id,]);
        $q->whereBetween('plan_to', [$plan_from, $plan_to])
        ->where(['job_id'=> $job_id,]);
       })->first();

        $rules = [
            "is_active" => ["in:0,1",function ($attribute, $value, $fail) use($Succession_managment,$Succession_job){
                if ($Succession_managment) {
                    $fail(trans('governance::messages.succession.canot_active_succession_has_managment'));
                }
                elseif($Succession_job)
                {
                    $fail(trans('governance::messages.succession.canot_active_succession_has_job'));

                }
            }],
            'plan_from' => 'required',
            'plan_to' => 'required|after_or_equal:plan_from',
            'file_type' => 'required|in:' . implode(',', Succession::FILE_TYPES),
            'percentage' => 'required|between:0,100',
            'attachments' => 'nullable|array|required_with:file_type',
            'items' => 'required|array|min:1',
            'items.*.item' => 'required|regex:/^[\pL\pN\s\-\_]+$/u',
            'management_id' => "required|exists:{$managementTable},id",
            'job_id' => "nullable|exists:{$jobTable},id",
        ];
        foreach (config('translatable.locales') as $locale) {
            $rules["$locale"] = "array";
            $rules["$locale.name"] = "required|min:2|max:100|regex:/^[\pL\pN\s\-\_]+$/u|unique:gc_succession_translations,name," . @$this->succession . ",succession_id";
        }

        if (request()->file_type == Succession::VIDEO) {
            $rules['attachments.*'] = 'nullable|mimes:mp4,mov,wmv,avi,flv|max:100000';
        } elseif (request()->file_type == Succession::DOCUMENT) {
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
