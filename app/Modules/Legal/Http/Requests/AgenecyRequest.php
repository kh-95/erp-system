<?php

namespace App\Modules\Legal\Http\Requests;

use App\Modules\HR\Entities\Employee;
use App\Modules\HR\Entities\Management;
use App\Modules\Legal\Entities\Agenecy;
use App\Modules\Legal\Entities\AgenecyTerm\AgenecyTerm;
use App\Modules\Legal\Entities\AgenecyType\AgenecyType;
use App\Modules\Legal\Entities\StaticText\StaticText;
use Illuminate\Foundation\Http\FormRequest;

class AgenecyRequest extends FormRequest
{
    public function rules()
    {
        return [
            'client_management_id' => 'required|exists:' . Management::getTableName()  . ',id',
            'client_employee_id' => 'required|exists:' . Employee::getTableName() . ',id',
            'client_agenecy_as' => 'required|in:' . implode(',', Agenecy::AGENECY_AS),
            'previous_agenecy_id' => 'nullable|numeric|digits_between:10,20|exists:' . Agenecy::getTableName() . ',id',
            'agent_management_id' => 'required|exists:' . Management::getTableName()  . ',id',
            'agent_employee_id' => 'required|exists:' . Employee::getTableName() . ',id',
            'agenecy_number' => 'numeric|digits_between:10,20',
            'country_id' => 'required|exists:countries,id',
            'agency_type_id' => 'array|min:1',
            'agency_type_id.*' => 'nullable|exists:' . AgenecyType::getTableName() . ',id',
            'agenecy_type_term_id' => 'required|array|min:1',
            'agenecy_type_term_id.*' => 'nullable|exists:' . AgenecyTerm::getTableName() .  ',id',
            'static_text_id' => 'nullable|array',
            'static_text_id.*' => 'nullable|exists:' . StaticText::getTableName() . ',id',
            'duration_type' => 'required|in:' . implode(',', Agenecy::DURATION_TYPE),
            'duration' => 'required|string',
            'hijiry_end_date' => 'required_if:duration_type,' . Agenecy::END_DATE_OF_MONTH,
            'milady_end_date' => 'required_if:duration_type,' . Agenecy::END_DATE_OF_MONTH,
            'attachments' => 'nullable|array',
            'attachments.*' => 'nullable|mimes:jpg,png,jpeg,doc,docx,pdf|max:20000'
        ];
    }

    public function authorize()
    {
        return true;
    }
}
