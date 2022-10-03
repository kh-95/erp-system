<?php

namespace App\Modules\Legal\Http\Requests;

use App\Modules\Legal\Entities\Order;
use Illuminate\Foundation\Http\FormRequest;
use App\Modules\Legal\Rules\ConsultRule;

class ConsultRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
     $consult_id = request('id');

        return [
            'text' => ['required',new ConsultRule($consult_id)],
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
