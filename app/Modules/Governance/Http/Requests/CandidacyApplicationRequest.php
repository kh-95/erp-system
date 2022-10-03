<?php

namespace App\Modules\Governance\Http\Requests;

use App\Modules\Governance\Entities\CandidacyApplication;
use App\Modules\HR\Entities\BlackList;
use Illuminate\Foundation\Http\FormRequest;

class CandidacyApplicationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $qulification_level = join(',', CandidacyApplication::QULAIFICATION_LEVELS);
        $order_status = join(',', CandidacyApplication::ORDER_STATUSES);


        $rules= [
            'candidate_name' => ['required', 'regex:/(^[a-zA-Z0-9 ]+$)+/', 'max:100', 'min:2' ,function ($attribute, $value, $fail) {
                if (count(explode(" ", $value)) != 4) {
                    $fail("The {$attribute} must consists of 4 words.");
                }
            }],
            'identity_number' => ['required', 'digits:10', 'numeric', "unique:governance_candidacy_applications,identity_number", function ($attribute, $value, $fail) {
                if (BlackList::where('identity_number', $value)->exists()) {
                    $fail("The {$attribute} are in the blacklist");
                }
            }],

            'phone' => [
                "required", "numeric", "digits:10", 'starts_with:9665,05', "unique:governance_candidacy_applications,phone", function ($attribute, $value, $fail) {
                    if (BlackList::where('phone', $value)->exists()) {
                        $fail("The {$attribute} are in the blacklist");
                    }
                }
            ],

            'nationality' => 'required|exists:hr_nationalities,id',
            'qualification_level' => "required|in:{$qulification_level}",
            'qualification_name' => "required|regex:/(^[a-zA-Z0-9 ]+$)+/|min:2|max:100",
            'order_status'   =>"required|in:{$order_status}",
            'record_number' => 'required_if:order_status,accepted,refused|digits:10|numeric|unique:governance_candidacy_applications,record_number',
            'record_subject' =>'required_with:record_number',
            'reason_refuse' =>"nullable|required_if:order_status,refused|in:{$order_status}|regex:/(^[a-zA-Z0-9 ]+$)+/|min:10|max:300"

        ];

        if (request()->file_type == CandidacyApplication::VIDEO) {
            $rules['attachments.*'] = 'nullable|mimes:mp4,mov,wmv,avi,flv|max:100000';
        } elseif (request()->file_type == CandidacyApplication::DOCUMENT) {
            $rules['attachments.*'] = 'nullable|mimes:txt,doc,docx,pdf,xlsx,rar|max:100000';
        } else {
            $rules['attachments.*'] = 'nullable|mimes:jpg,jpeg,png|max:100000';
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
