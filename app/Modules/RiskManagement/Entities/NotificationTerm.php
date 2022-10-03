<?php

namespace App\Modules\RiskManagement\Entities;

use App\Foundation\Traits\HasTablePrefixTrait;
use App\Foundation\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class NotificationTerm extends Model
{
    use HasTablePrefixTrait, Timestamp, LogsActivity;

    protected $guarded = [];

    const DAY_TRANSACTION_TOTAL = 'day_transaction_total';
    const MONTH_TRANSACTION_TOTAL = 'month_transaction_total';
    const YEAR_TRANSACTION_TOTAL = 'year_transaction_total';
    const FIELDS = [self::DAY_TRANSACTION_TOTAL, self::MONTH_TRANSACTION_TOTAL, self::YEAR_TRANSACTION_TOTAL];

    const LARGER_THAN = 'larger_than';
    const LESS_THAN = 'less_than';
    const EQUAL = 'equal';
    const NOT_EQUAL = 'not_equal';
    const LARGER_THAN_OR_EQUAL = 'larger_than_or_equal';
    const LESS_THAN_OR_EQUAL = 'less_than_or_equal';
    const OPERATORS = [
        self::LARGER_THAN,
        self::LESS_THAN,
        self::EQUAL,
        self::NOT_EQUAL,
        self::LARGER_THAN_OR_EQUAL,
        self::LESS_THAN_OR_EQUAL,
    ];

    const AND = 'and';
    const OR = 'or';
    const JOIN_OPERATORS = [self::AND, self::OR];


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
