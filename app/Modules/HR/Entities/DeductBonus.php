<?php

namespace App\Modules\HR\Entities;

use App\Foundation\Traits\HasTablePrefixTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Builder;
use App\Foundation\Traits\Timestamp;

class DeductBonus extends Model
{
    use HasFactory, HasTablePrefixTrait, Timestamp;

    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $dates = ['created_at', 'updated_at', 'applicable_at'];

    //ACTION_TYPE
    const DURATION = 'duration';
    const AMOUNT = 'amount';
    const ACTION_TYPE = [self::DURATION, self::AMOUNT];

    //DURATION_TYPE
    const DAY = 'day';
    const WEEK = 'week';
    const MONTH = 'month';
    const YEAR = 'year';
    const DURATION_TYPE = [self::DAY, self::WEEK, self::MONTH, self::YEAR];

    //TYPE
    const DEDUCT = 'deduct';
    const BONUS = 'bonus';
    const TYPE = [self::DEDUCT, self::BONUS];

    //STATUS
    const ACCEPTED = 'accepted';
    const REFUSED = 'refused';
    const PENDING = 'pending';
    const STATUSES = [self::ACCEPTED, self::REFUSED, self::PENDING];


//    public function getActivitylogOptions(): LogOptions
//    {
//        return LogOptions::defaults()
//            ->logOnly(['title', 'description'])
//            ->useLogName('DeductBonus')
//            ->logOnlyDirty()
//            ->dontSubmitEmptyLogs();
//    }


    public function scopeCreatedFrom($query, $date)
    {
        return $query->where('created_at', '>=', date('Y-m-d', strtotime($date)));
    }

    public function scopeCreatedTo($query, $date)
    {
        return $query->where('created_at', '<=', date('Y-m-d', strtotime($date)));
    }

    public function scopeExchangeStatus($query, $status)
    {
        if ($status == 1) {
            return $query->whereNotNull('applicable_at');
        }
        return $query->whereNull('applicable_at');
    }


    public function management()
    {
        return $this->belongsTo(Management::class, 'management_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function addedBy()
    {
        return $this->belongsTo(Employee::class, 'added_by_id');
    }

    protected static function newFactory()
    {
        return \App\Modules\HR\Database\factories\DeductBounceFactory::new();
    }
}
