<?php

namespace App\Modules\HR\Http\Requests\ServiceRrequest;

use App\Modules\HR\Entities\Employee;
use App\Modules\HR\Entities\Management;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Mail;
use Astrotomic\Translatable\Validation\RuleFactory;

class StoreResponseRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = RuleFactory::make([
            '%note%' => 'required|between:10,5000',
            'attachments' => 'nullable|array',
            'attachments.*' => 'nullable|mimes:jpg,png,jpeg,doc,docx,pdf,wma,wmv,mp3|max:100000'
        ]);
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
            'ar.note.required' => __('hr::validation.service.notes.required'),
            'attachments.array' => __('hr::validation.service.attachments.array'),
        ];

    }
}
