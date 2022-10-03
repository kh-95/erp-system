<?php

namespace App\Exports;

use App\Modules\HR\Entities\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;

class EmployeesExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Employee::query()->select('identification_number', 'first_name', 'last_name', 'phone', 'identity_source', 'email', 'address')->get();
    }
}
