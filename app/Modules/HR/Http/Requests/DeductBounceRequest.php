<?php

namespace App\Modules\HR\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeductBounceRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'management_id'=>'required|exists:managements,id,deactivated_at,null',
            'employee_id'=>'required|exists:employees,id,deactivated_at,null',
            'action_type'=>'required',
            'amount'=>'required_if:action_type,amount|numeric|digits:6|regex:^[1-9][0-9]*$|',
            'duration'=>'required_if:action_type,duration|numeric|digits:5|regex:^[1-9][0-9]*$|regex:[0-9]{0,2}(\.[0-9]{1,2})?',
            'notes'  =>'required|alpha_dash|min:10|max:300'

        ];
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
