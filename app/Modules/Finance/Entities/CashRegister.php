<?php

namespace App\Modules\Finance\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Foundation\Traits\HasTablePrefixTrait;

class CashRegister extends Model
{
    use HasFactory, LogsActivity, HasTablePrefixTrait;

    protected $guarded = [];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['tranfer_number', 'date', 'money',
                       'from_register', 'to_register', 'note',
                       'bank_id', 'check_number', 'check_number_date'])
            ->useLogName('finance/cashRegister')
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    protected static function newFactory()
    {
        return \App\Modules\Finance\Database\factories\CashRegisterFactory::new();
    }

    public function attachments()
    {
        return $this->hasMany(CashRegisterAttachments::class , 'cashregister_id');
    }
}
