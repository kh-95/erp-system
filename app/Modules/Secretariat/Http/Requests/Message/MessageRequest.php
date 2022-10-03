<?php

namespace App\Modules\Secretariat\Http\Requests\Message;

use App\Foundation\Classes\Helper;
use Illuminate\Foundation\Http\FormRequest;
use Astrotomic\Translatable\Validation\RuleFactory;

class MessageRequest extends FormRequest
{

    public function rules()
    {
        return request()->method() === 'POST' ? $this->storeRules() : $this->updateRules();
    }

    private function storeRules() :array
    {
        $rules = RuleFactory::make([
            'message_number' => 'required|digits:5',
            'source' => 'required',
            'message_date' => 'required','date_format:d-m-Y',
            'message_recieve_date' => 'required','date_format:d-m-Y',
            'message_body' => 'required',
            'specialist' => 'required|array',
            'legal' => 'required|array',
            'defendant' => 'required|array',
            'claimant' => 'required|array',
            'claimant.customer_type' => 'required|in:customer,customerWService',
            'claimant.contract_number' => 'required_if:customer_type,=,customer',
            'claimant.identity_number' => 'required_if:customer_type,=,customer',
            'claimant.name' => 'required_if:customer_type,=,customer',
            'claimant.mobile' => 'required_if:customer_type,=,customer',
            'claimant.register_number' => 'required_if:customer_type,=,customerWService',
            'claimant.tax_number' => 'required_if:customer_type,=,customerWService',
        ]);

        return $rules;
    }

    private function updateRules() :array
    {
        $rules = RuleFactory::make([
            'message_number' => 'required|digits:5',
            'source' => 'required',
            'message_date' => 'required','date_format:d-m-Y',
            'message_recieve_date' => 'required','date_format:d-m-Y',
            'message_body' => 'required',
            'specialist' => 'sometimes|array',
            'legal' => 'sometimes|array',
            'defendant' => 'sometimes|array',
            'claimant' => 'sometimes|array',
            'claimant.customer_type' => 'sometimes|in:customer,customerWService',
            'claimant.contract_number' => 'sometimes|required_if:customer_type,=,customer',
            'claimant.identity_number' => 'sometimes|required_if:customer_type,=,customer',
            'claimant.name' => 'sometimes|required_if:customer_type,=,customer',
            'claimant.mobile' => 'sometimes|required_if:customer_type,=,customer',
            'claimant.register_number' => 'sometimes|required_if:customer_type,=,customerWService',
            'claimant.tax_number' => 'sometimes|required_if:customer_type,=,customerWService',
        ]);

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
