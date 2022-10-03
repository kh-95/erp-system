<?php

namespace App\Modules\RiskManagement\Entities;

use App\Foundation\Traits\HasTablePrefixTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class BankVendor extends Pivot
{
    use HasFactory, HasTablePrefixTrait;

    protected $guarded = [];

    const WAITING = 'waiting';
    const ACTIVE = 'active';
    const DEACTIVATED = 'deactivated';
    const STATUS = [self::WAITING, self::ACTIVE, self::DEACTIVATED];


    protected static function newFactory()
    {
        return \App\Modules\RiskManagement\Database\factories\BankVendorFactory::new();
    }

}
