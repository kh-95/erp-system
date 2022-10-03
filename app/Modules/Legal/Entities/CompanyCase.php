<?php

namespace App\Modules\Legal\Entities;

use App\Foundation\Traits\HasTablePrefixTrait;
use App\Foundation\Traits\Timestamp;
use App\Modules\HR\Entities\Employee;
use App\Modules\Legal\Entities\JudicialDepartment\JudicialDepartment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;

class CompanyCase extends Model
{
    use HasFactory, Timestamp, HasTablePrefixTrait;

    protected $guarded = [];

    const NEW = 'new';
    const RECONCILED = 'reconciled';
    const NOT_RECONCILED = 'not_reconciled';
    const STATUS = [self::NEW, self::RECONCILED, self::NOT_RECONCILED];

    const UNDER_CONSIDERATION = 'under_consideration';
    const FIRST_CROSSED_OUT = 'first_crossed_out';
    const SECOND_CROSSED_OUT = 'second_crossed_out';
    const THIRD_CROSSED_OUT = 'third_crossed_out';
    const ISSUING_FINAL_JUDGMENT = 'issuing_final_judgment';
    const ISSUING_APPEALABLE_JUDGMENT = 'issuing_appealable_judgment';
    const RECONCILIATION_STATUS = [self::UNDER_CONSIDERATION, self::FIRST_CROSSED_OUT, self::SECOND_CROSSED_OUT, self::THIRD_CROSSED_OUT, self::ISSUING_FINAL_JUDGMENT, self::ISSUING_APPEALABLE_JUDGMENT];

    const WAITING = 'waiting';
    const ACCEPTED = 'accepted';
    const REJECTED = 'rejected';
    const EXECUTION_STATUS = [self::WAITING, self::ACCEPTED, self::REJECTED];

    const TRANSFER_REQUEST = 'transfer_request';
    const TIME_OUT_REQUEST = 'time_out_request';
    const ALL = 'all';
    const PARTIAL = 'partial';
    const PAYMENT = [self::TRANSFER_REQUEST, self::TIME_OUT_REQUEST, self::ALL, self::PARTIAL];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    protected static function newFactory()
    {
        return \App\Modules\Legal\Database\factories\CompanyCaseFactory::new();
    }

    public function attachments()
    {
        return $this->hasMany(CompanyCaseAttachment::class);
    }

    public function sessions()
    {
        return $this->hasMany(CompanyCaseSession::class);
    }


    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }


    public function payments()
    {
        return $this->hasMany(CompanyCasePayment::class);
    }

    public function judicial_department()
    {
        return $this->belongsTo(JudicialDepartment::class);
    }
}
