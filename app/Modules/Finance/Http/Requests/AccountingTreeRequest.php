<?php

namespace App\Modules\Finance\Http\Requests;


use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Config;

class AccountingTreeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules =[
            'revise_no' => 'required|unique:fi_accounting_trees',
            'account_type'=>'required',
            'parent_id'=>'sometimes|nullable',
            'payment_check'=>'sometimes|nullable',
            'collect_check' => 'sometimes|nullable',
            'account_code' => 'required|unique:fi_accounting_trees|numeric',

        ];
        $rules += RuleFactory::make([
            '%account_name%' => 'required|max:100',
            '%notes%'=>'sometimes|nullable',
        ]);
        return $rules;
    }

    /**
     * Get validation messages.
     *
     * @return array
     */
    public function messages(): array
    {
        $langs = Config::get('translatable.locales');
        $messages =[
        'revise_no.required' => __('finance::validation.accountingtree.revise_no.required'),
        'revise_no.unique' => __('finance::validation.accountingtree.revise_no.unique'),
        'account_type.required' => __('finance::validation.accountingtree.account_type.required'),
        'account_code.required' => __('finance::validation.accountingtree.account_code.required'),
        'account_code.max' => __('finance::validation.accountingtree.account_code.max'),
        'account_code.numeric' => __('finance::validation.accountingtree.account_code.numeric'),
        'account_code.unique' => __('finance::validation.accountingtree.account_code.unique'),

                ];
            foreach($langs as $lang) {
                $messages += [
                    $lang.'.account_name.required' => __('finance::validation.accountingtree.account_name.required')
                ];
            }
        return $messages;
    }
}
