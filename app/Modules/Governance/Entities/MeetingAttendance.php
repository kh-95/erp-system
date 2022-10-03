<?php

namespace App\Modules\Governance\Entities;

use App\Foundation\Traits\HasTablePrefixTrait;
use App\Modules\HR\Entities\Employee;
use App\Modules\HR\Entities\Management;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MeetingAttendance extends Model
{
    use HasFactory,HasTablePrefixTrait;

    protected $guarded = ['id', 'created_at', 'updated_at'];

   public function management()
   {
     return $this->belongsTo(Management::class, 'management_id');
   }

   public function employee()
   {
     return $this->belongsTo(Employee::class, 'employee_id');
   }

}
