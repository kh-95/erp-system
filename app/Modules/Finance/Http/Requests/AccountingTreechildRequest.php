<?php

namespace App\Modules\Finance\Http\Requests;


use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Config;

class AccountingTreechildRequest extends FormRequest
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
            'parent_id' => 'required',
            'child_id'=>'required',
            'account_code' => 'required|unique:fi_accounting_trees|numeric',
        ];
    
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
        'parent_id.required' => __('finance::validation.accountingtree.parent_id.required'),
        'child_id.required' => __('finance::validation.accountingtree.child_id.required'),
        'account_code.required' => __('finance::validation.accountingtree.account_code.required'),
        'account_code.max' => __('finance::validation.accountingtree.account_code.max'),
        'account_code.numeric' => __('finance::validation.accountingtree.account_code.numeric'),
        'account_code.unique' => __('finance::validation.accountingtree.account_code.unique'),

                ];
        return $messages;
    }
}
