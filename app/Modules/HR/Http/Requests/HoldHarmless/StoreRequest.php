<?php

namespace App\Modules\HR\Http\Requests\HoldHarmless;

use Illuminate\Foundation\Http\FormRequest;
use Astrotomic\Translatable\Validation\RuleFactory;

class StoreRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

         $rules =[
            'employee_id' => "required|int",
         ];


        $rules += RuleFactory::make([
            '%reason%' => "required|in:resignation,end_contract,end_probationary,segregation",
            '%note%' => "required|string|max:500",
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
