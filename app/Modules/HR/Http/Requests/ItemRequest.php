<?php

namespace App\Modules\HR\Http\Requests;

use App\Modules\HR\Entities\Items\Item;
use App\Modules\HR\Entities\Management;
use Illuminate\Foundation\Http\FormRequest;

class ItemRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $managements = Management::getTableName();
        $type = join(',', Item::TYPE);
        $rules['management_id'] = 'required|exists:'. $managements.',id';
        $rules['type'] = "required|in:{$type}";
        $rules['score'] = "required|regex:/^\d{2}(\.\d{2})?$/";
        foreach (config('translatable.locales') as $locale) {
            $rules["$locale"] = "array";
            $rules["$locale.name"] = "required|regex:/^[\pL\pN\s\-\_]+$/u"; //
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
