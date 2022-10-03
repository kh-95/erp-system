<?php

namespace App\Modules\Finance\Http\Requests;


use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Config;

class AssetCategoryUpdateRequest extends FormRequest
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
            'revise_no' => 'sometimes|nullable',
            'account_tree_id'=>'sometimes|nullable',
            'destroy_check'=>'sometimes|nullable',
            'destroy_ratio'=>'sometimes|nullable',

        ];
        $rules += RuleFactory::make([
            '%name%' => 'sometimes|nullable',
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
        'revise_no.required' => __('finance::validation.assetcategory.revise_no.required'),
        'revise_no.unique' => __('finance::validation.assetcategory.revise_no.unique'),
        'account_tree_id.required' => __('finance::validation.assetcategory.account_tree_id.required'),
        'destroy_ratio.required' => __('finance::validation.assetcategory.destroy_ratio.required'),
                ];
            foreach($langs as $lang) {
                $messages += [
                    $lang.'.name.required' => __('finance::validation.assetcategory.name.required')
                ];
            }
        return $messages;
    }
}
