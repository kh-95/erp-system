<?php

namespace App\Modules\Governance\Http\Requests;

trait PublicMeetingRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function validateDateTime($dateTime)
    {

        if(preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])\s(0[1-9]|1[0-2]):(00|30)\s(AM|PM)$/",$dateTime)){

            return true;
        }
        return false;
    }


}
