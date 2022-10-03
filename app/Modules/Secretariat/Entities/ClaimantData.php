<?php

namespace App\Modules\Secretariat\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Foundation\Traits\HasTablePrefixTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class ClaimantData extends Model
{
    use HasFactory, HasTablePrefixTrait, SoftDeletes;

    protected $guarded = [];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['customer_type', 'contract_number', 'identity_number', 'name',
                       'mobile', 'register_number', 'tax_number'])
            ->useLogName('claimantWithMessage')
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    protected static function newFactory()
    {
        return \App\Modules\Secretariat\Database\factories\ClaimantDataFactory::new();
    }
}
