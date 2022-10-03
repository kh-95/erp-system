<?php

namespace App\Modules\HR\Entities;

use App\Foundation\Traits\HasTablePrefixTrait;
use App\Foundation\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Builder;

class PermissionRequest extends Model
{
    use HasFactory, SoftDeletes, Timestamp, LogsActivity, HasTablePrefixTrait;

    protected $guarded = [];

    protected $table = 'hr_permission_requests';

    const WAITING = 'waiting';
    const ACCEPTED = 'accepted';
    const REJECTED = 'rejected';
    const ACCEPTED_WITH_DEDUCT = 'accepted_with_deduct';
    const ACCEPTED_WITHOUT_DEDUCT = 'accepted_without_deduct';

    const  MANAGER_STATUSES = [self::WAITING, self::ACCEPTED, self::REJECTED];
    const HR_STATUSES = [self::WAITING, self::ACCEPTED_WITH_DEDUCT, self::ACCEPTED_WITHOUT_DEDUCT, self::REJECTED];

    const AM = 'AM';
    const PM = 'PM';
    const DURATION = [self::AM, self::PM];

    const ABSENCE = 'absence';
    const LATE = 'late';
    const TYPES = [self::LATE, self::ABSENCE];

    protected static function newFactory()
    {
        return \App\Modules\HR\Database\factories\PermissionRequestFactory::new();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logUnguarded()
            ->useLogName('PermissionRequest')
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

//    public function scopeCheckManager(Builder $query)
//    {
//        $employee = auth()->user()->employee;
//        if ($employee->is_management_member == 1) {
//            $query->where('employee_manager_id', $employee->id);
//        }
//    }

    public function scopeNameEmployee($query, $fullName)
    {
        $array_of_names = explode(' ', $fullName);
        $array_count = count($array_of_names);
        if ($array_count == 1) {
            return $query->whereHas('employee', function ($q) use ($array_of_names) {
                $q->where('first_name', 'LIKE', "%{$array_of_names[0]}%");
            });
        } elseif ($array_count == 2) {
            return $query->whereHas('employee', function ($q) use ($array_of_names) {
                $q->where('first_name', 'LIKE', "%{$array_of_names[0]}%");
                $q->where('second_name', 'LIKE', "%{$array_of_names[1]}%");
            });
        } elseif ($array_count == 3) {
            return $query->whereHas('employee', function ($q) use ($array_of_names) {
                $q->where('first_name', 'LIKE', "%{$array_of_names[0]}%");
                $q->where('second_name', 'LIKE', "%{$array_of_names[1]}%");
                $q->where('last_name', 'LIKE', "%{$array_of_names[2]}%");
            });
        } else {
            return $query->whereHas('employee', function ($q) use ($array_of_names) {
                $q->where('first_name', 'LIKE', "%{$array_of_names[0]}%");
                $q->where('second_name', 'LIKE', "%{$array_of_names[1]}%");
                $q->where('third_name', 'LIKE', "%{$array_of_names[2]}%");
                $q->where('last_name', 'LIKE', "%{$array_of_names[3]}%");
            });
        }
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
