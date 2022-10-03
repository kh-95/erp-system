<?php

namespace App\Modules\Finance\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Astrotomic\Translatable\Validation\RuleFactory;

class AssetStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'purchase_date'             => 'required|date',
            'operation_date'            => 'required|date',
            'measure_value'             => 'required',
            'barcode'                   => 'required',
            'account'                   => 'required',
            'value'                     => 'required',
            'scrap_value'               => 'required',
            'expiration_date'           => 'required|date',
            'is_depreciable'            => 'required',
            'depreciation_fees'         => 'required',
            'total_depreciation_fees'   => 'required',
            'is_assurance_exists'       => 'required',
            'assurance_expiration_date' => 'required|date',
            'attachments'               => 'nullable|array',
        ];

        $rules += RuleFactory::make([
            '%name%'                    => 'required',
            '%category%'                => 'required',
            '%measure_unit%'            => 'required',
            '%tax%'                     => 'required',
            '%description%'             => 'nullable',
        ]);

        return $rules;
    }

    protected function failedValidation(Validator $validator)
    {
        throw (new ValidationException($validator, response(['error' => $validator->errors()])));
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
