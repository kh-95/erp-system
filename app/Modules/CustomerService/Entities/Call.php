<?php

namespace App\Modules\CustomerService\Entities;

use App\Foundation\Traits\HasTablePrefixTrait;
use App\Foundation\Traits\Timestamp;
use App\Modules\HR\Entities\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Call extends Model
{
    use HasFactory, HasTablePrefixTrait, LogsActivity, Timestamp;

    protected $guarded = [];
    const FINISH = 'Finish';
    const WAITING = 'Waiting';
    const ONGOING = 'Ongoing';
    const STATUSES = [
        self::FINISH,
        self::WAITING,
        self::ONGOING,
    ];

    protected static function newFactory()
    {
        return \App\Modules\CustomerService\Database\factories\CallFactory::new();
    }

    public function scopeDuration($query, $value)
    {
        return $query->where('duration', '>=', $value);
    }

    public function scopeWaitingTime($query, $value)
    {
        return $query->where('waiting_time_in_queue', '>=', $value);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnlyDirty()
            ->useLogName('Call')
            ->dontSubmitEmptyLogs();
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function convertEmployee()
    {
        return $this->belongsTo(Employee::class, 'convert_to_employee_id');
    }
}
