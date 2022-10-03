<?php

namespace App\Modules\HR\Entities;

use App\Foundation\Traits\HasTablePrefixTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BlackList extends Model
{
    use HasFactory, HasTablePrefixTrait;

    protected $guarded = ['id','created_at','updated_at'];
    protected $table = 'hr_black_lists';
    const CLIENTS = 'clients';
    const DEACTIVATED_EMPLOYEES = 'deactivated_employees';
    const FORBIDDEN_EMPLOYEES = 'forbidden_employees';
    const BLACK_LIST_TYPES = [self::CLIENTS,self::DEACTIVATED_EMPLOYEES,self::FORBIDDEN_EMPLOYEES];
    const PREVIOUS_EMPLOYEE = 'previous_employee';
    const INDIVIDUAL = 'individual';
    const EMPLOYEE_TYPE = [self::PREVIOUS_EMPLOYEE,self::INDIVIDUAL];
   // Relationships
    public function employee()
    {
        return $this->hasMany(Employee::class, 'employee_id');
    }
   // accessors
    



}
