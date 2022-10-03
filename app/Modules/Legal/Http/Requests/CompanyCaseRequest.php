<?php

namespace App\Modules\Legal\Http\Requests;

use App\Modules\Legal\Entities\CompanyCase;
use App\Modules\Legal\Entities\JudicialDepartment\JudicialDepartment;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CompanyCaseRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {
        $rules = [
            'case_number' => 'nullable|numeric|max_digits:20|unique:' . CompanyCase::getTableName() . ',id',
            'order_number' => 'nullable|numeric|max_digits:20|unique:' . CompanyCase::getTableName() . ',id',
            'judicial_department_id' => 'nullable|exists:' . JudicialDepartment::getTableName() . ',id',
            'employee_id' => 'nullable',
            'case_date1' => 'required|date',
            'case_date2' => 'required|date',
            "amount" => ['required', 'max:20'],
            "cost" => ['required', 'max:20'],
            'status' => 'required|in:' . implode(',', CompanyCase::STATUS),
            'reconciliation_status' => [
                'required_with:status',
                Rule::when($request->status == CompanyCase::NOT_RECONCILED, ['required', 'in:' . implode(',', CompanyCase::RECONCILIATION_STATUS)]),
            ],
            'execution_status' => ['required_with:reconciliation_status',
                Rule::when($request->reconciliation_status == CompanyCase::ISSUING_FINAL_JUDGMENT, ['required', 'in:' . implode(',', CompanyCase::EXECUTION_STATUS)]),
            ],

            'execution_number' => 'required|numeric|max_digits:20',
            'execution_area_number' => 'required|numeric|max_digits:10',
            'decision_34' => 'nullable',
            'decision_46' => 'nullable',
            'decision_83' => 'nullable',
            'payment' => 'required|in:' . implode(',', CompanyCase::PAYMENT),
            'time_out_duration' => [
                Rule::when($request->payment == CompanyCase::TIME_OUT_REQUEST, ['required', 'in:' . implode(',', [2, 4, 6, 8, 10, 12])])
            ],
            'time_out_date1' => [
                Rule::when($request->time_out_duration, ['required','date','after_or_equal:today']),
            ],
            'time_out_date2' => [
                Rule::when($request->time_out_duration, ['required','date','after_or_equal:today']),
            ],

            'payments.*' => [
                Rule::when(($request->payment == CompanyCase::ALL) || ($request->payment == CompanyCase::PARTIAL), ['required', 'array']),
            ],
            'payments.*.payment_date_from' => 'required_with:payments.*|date',
            'payments.*.payment_date_to' => 'required_with:payments.*|date',
            'payments.*.paid_amount' => 'required_with:payments.*',
            'payments.*.remaining_amount' => 'required_with:payments.*',


            'vendor_identity_number' => 'required|numeric|date_equals:10',
            'vendor_name' => 'required',
            'vendor_phone' => 'required',
            'contract_number' => 'required',
            'late_installments' => 'required',
            'installments_amount' => 'required',

            'sessions.*' => 'required|array|min:1',
            'sessions.*.session_date1' => 'required|date',
            'sessions.*.session_date2' => 'required|date',
            'sessions.*.notes' => 'nullable',


            'attachments' => 'nullable|array',
            'attachments.*' => 'nullable|mimes:pdf,docx,jpg,jpeg,png|max:100000'
        ];
        if ($this->isMethod('PUT')) {
            $rules['sessions.*.id'] = 'exists:legal_company_case_sessions,id';
            $rules['payments.*.id'] = 'exists:legal_company_case_payments,id';
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
