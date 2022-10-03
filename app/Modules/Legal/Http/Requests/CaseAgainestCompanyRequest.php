<?php

namespace App\Modules\Legal\Http\Requests;

use App\Modules\HR\Entities\Employee;
use App\Modules\Legal\Entities\CaseAgainestCompany;
use App\Modules\Legal\Entities\Claimant;
use Illuminate\Foundation\Http\FormRequest;

class CaseAgainestCompanyRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $case_agianest_company_id = $this->case_againest_company;
        $court_types = join(',',CaseAgainestCompany::COURTS);
        $statuses = join(',',CaseAgainestCompany::STATUSES);
        $employeeTable = Employee::getTableName();
        $claimantTable = Claimant::getTableName();
        return [
            'court_number' => ['nullable','integer','max_digits:20', function ($attribute, $value, $fail) use($case_agianest_company_id) {
                if(!$this->checkTheCourtNumber() && !$case_agianest_company_id){
                    $fail('The '.$attribute.' must not duplicate with the same area.');
                }
            }],
            'court_type' => "required|in:{$court_types}",
            'area' => 'required',
            'case_filing_date' => 'required|date|before_or_equal:today',
            'case_filing_date_hijri' => 'required|date|before_or_equal:today',
            'status' => "required|in:{$statuses}",
            'case_fee' => 'required|numeric|max_digits:20',
            'case_reason' => 'nullable|max:1000',
            'employee_id' => "required|exists:{$employeeTable},id",
            'claimant_name'=> 'required|max:100|string',
            'identity_number' => "required|integer|max_digits:10|unique:{$claimantTable},identity_number,{$case_agianest_company_id}",
            'sessions' => 'required|array',
            'sessions.*.session_date' => 'required|date',
            'sessions.*.session_date_hijri' => 'required|date',
            'sessions.*.notes' => 'nullable|string|max:1000',
            'attachments' => 'required|array',
            'attachments.*' => 'image|mimes:jpg,png,jpeg|required|max:20475'
        ];
    }

    private function checkTheCourtNumber()
    {

        $case_againest_company = CaseAgainestCompany::where(['court_number'=> $this->court_number,'area'=>$this->area])->first();
        if($case_againest_company){

            return false;
        }
        return true;

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
