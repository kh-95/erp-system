<?php

namespace App\Modules\Legal\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Modules\Legal\Entities\LegalOpinion;

class ConsultRule implements Rule
{
    private $consult_id ;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($cosult_id)
    {
        $this->consult_id = $cosult_id;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
       $opinion = LegalOpinion::where('consult_id',$this->consult_id)->first();
       if($opinion){
        return false;
       }else{
        return true;
       }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
