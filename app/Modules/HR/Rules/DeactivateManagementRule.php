<?php

namespace App\Modules\HR\Rules;

use App\Modules\HR\Entities\Management;
use Illuminate\Contracts\Validation\Rule;

class DeactivateManagementRule implements Rule
{

    private $managementId;
    private $management;

    public function __construct($managementId)
    {
        $this->managementId = $managementId;
        $this->setManaegment($managementId);
    }

    public function passes($attribute, $value) :bool
    {
        if($value) {
            return !$this->management->employeeJobInformation()->exists();
        }
        return true;
    }

    private function setManaegment($id)
    {
        $this->management = Management::find($id);
    }

    public function message() :string
    {
        return __('hr::validation.management.deactivate');
    }
}
