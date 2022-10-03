<?php

namespace App\Modules\Finance\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Astrotomic\Translatable\Validation\RuleFactory;

class AssetUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules =  [
            'purchase_date'             => 'sometimes|date',
            'operation_date'            => 'sometimes|date',
            'measure_value'             => 'nullable',
            'barcode'                   => 'nullable',
            'account'                   => 'nullable',
            'value'                     => 'nullable',
            'scrap_value'               => 'nullable',
            'expiration_date'           => 'sometimes|date',
            'is_depreciable'            => 'nullable',
            'depreciation_fees'         => 'nullable',
            'total_depreciation_fees'   => 'nullable',
            'is_assurance_exists'       => 'nullable',
            'assurance_expiration_date' => 'sometimes|date',
            'attachments'               => 'nullable',
        ];

        $rules += RuleFactory::make([
            '%name%'                    => 'nullable',
            '%category%'                => 'nullable',
            '%measure_unit%'            => 'nullable',
            '%tax%'                     => 'nullable',
            '%description%'             => 'nullable',
        ]);

        return $rules;
    }

    protected function failedValidation(Validator $validator)
    { 
        throw (new ValidationException($validator, response(['error' => $validator->errors()->first()])));
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
