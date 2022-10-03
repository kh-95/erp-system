<?php

namespace App\Modules\RiskManagement\Entities;

use App\Foundation\Traits\HasTablePrefixTrait;
use App\Foundation\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;

class Vendor extends Model
{
    use HasFactory, Timestamp, HasTablePrefixTrait;

    protected $guarded = [];


    const RASID_JACK = 'rasid_jack';
    const RASID_MAAK = 'rasid_maak';
    const RASID_PAY = 'rasid_pay';
    const SUBSCRIPTIONS = [self::RASID_JACK, self::RASID_MAAK, self::RASID_PAY];

    const COMMERCIAL_RECORD = 'commercial_record';
    const FREE_WORK_DOCUMENT = 'free_work_document';
    const PROFESSION_PRACTICE_DOCUMENT = 'profession_practice_document';
    const TYPES = [self::COMMERCIAL_RECORD, self::FREE_WORK_DOCUMENT, self::PROFESSION_PRACTICE_DOCUMENT];


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    protected static function newFactory()
    {
        return \App\Modules\RiskManagement\Database\factories\VendorFactory::new();
    }


    public function attachments()
    {
        return $this->hasMany(VendorAttachment::class, 'vendor_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }


    public function banks()
    {
        return $this->belongsToMany(
            Bank::class,
            BankVendor::getTableName(),
            'vendor_id',
            'bank_id'
        )->withPivot(['status', 'iban']);
    }


    public function class()
    {
        return $this->belongsTo(VendorClass::class);
    }


}
