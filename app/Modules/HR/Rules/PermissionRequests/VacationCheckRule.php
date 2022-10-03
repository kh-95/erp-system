<?php

namespace App\Modules\HR\Rules\PermissionRequests;

use App\Modules\HR\Entities\Vacation;
use Illuminate\Contracts\Validation\Rule;

class VacationCheckRule implements Rule
{

    private $vacation_number;

    public function __construct($vacation_number = null)
    {
        $this->vacation_number = $vacation_number;
    }

    public function passes($attribute, $value): bool
    {
        $vacation = Vacation::where('vacation_employee_id', auth()->user()->employee?->id)
            ->whereDate('vacation_from_date', '<=', $value)
            ->whereDate('vacation_to_date', '>=', $value)
            ->first();
        if ($vacation) {
            $this->vacation_number = $vacation->id;

            return false;
        }
        return true;
    }


    public function message(): string
    {
        return __('hr::messages.permission_requests.this_day_holidays', ['vacation_number' => $this->vacation_number]);
    }
}
