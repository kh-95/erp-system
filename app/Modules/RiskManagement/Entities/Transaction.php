<?php

namespace App\Modules\RiskManagement\Entities;

use App\Foundation\Traits\HasTablePrefixTrait;
use App\Foundation\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;

class Transaction extends Model
{
    use HasFactory, Timestamp, HasTablePrefixTrait;

    const RASID_JACK = 'rasid_jack';
    const RASID_MAAK = 'rasid_maak';
    const RASID_PAY = 'rasid_pay';
    const TYPES = [self::RASID_JACK, self::RASID_MAAK, self::RASID_PAY];

    const AR_RASID_JACK = 'رصيد جاك';
    const AR_RASID_MAAK = 'رصيد معاك';
    const AR_RASID_PAY = 'رصيد باي';
    const AR_TYPES = [self::AR_RASID_JACK, self::AR_RASID_MAAK, self::AR_RASID_PAY];

    const COMPLETED = 'completed';
    const PROCESSING = 'processing';
    const STATUS = [self::COMPLETED, self::PROCESSING];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    protected static function newFactory()
    {
        return \App\Modules\RiskManagement\Database\factories\TransactionFactory::new();
    }


    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function attachments()
    {
        return $this->hasMany(TransactionAttachment::class, 'transaction_id');
    }
}
