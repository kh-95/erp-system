<?php

namespace App\Modules\Governance\Http\Requests;

use App\Modules\HR\Entities\Employee;
use Illuminate\Foundation\Http\FormRequest;

class RegulationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $arr_files = 'required|array';
        $files = 'required|mimes:jpeg,png,jpg,docx,pdf,xlsx,rar,mp4,mov,wmv,avi,flv,txt|max:2048';
        if ($this->regulation) {
            $arr_files = 'nullable|array';
            $files = 'nullable|mimes:jpeg,png,jpg,docx,pdf,xlsx,rar,mp4,mov,wmv,avi,flv,txt|max:2048';
        }

        $rules = [];
        foreach (config('translatable.locales') as $locale) {
            $rules["$locale"] = "array";
            $rules["$locale.title"] = "required|regex:/(^[a-zA-Z0-9_ ]+$)+/|between:2,100"; //
            $rules["$locale.description"] = 'required|regex:/(^[a-zA-Z0-9_ ]+$)+/|between:10,500'; //
        }

        return [
                'from_year' => 'required|numeric|digits:4|min:2000|max:2100',
                'to_year' => ['required', 'numeric', 'digits:4', 'min:2000', 'max:2100', function ($attribute, $value, $fail) {
//            $rr = Regulation::where('from_year','>=', $this->from_year)->where('to_year','<=', $this->to_year)->first();
//            dd($rr);
                    if ($value < $this->from_year) {
                        $fail('The ' . $attribute . ' younger than ' . $this->from_year);
                    }
                }],
                'files' => $arr_files,
                'files.*' => $files,
                'is_active' => 'required|in:0,1',
            ] + $rules;
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
