<?php

namespace App\Modules\RiskManagement\Entities;

use App\Foundation\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use App\Foundation\Traits\DeactivatedTrait;
use App\Foundation\Traits\HasTablePrefixTrait;

class Bank extends Model implements TranslatableContract
{
    use HasFactory, DeactivatedTrait, Translatable, HasTablePrefixTrait, Timestamp;

    protected $guarded = [];
    public $translatedAttributes = ['name'];

    protected static function newFactory()
    {
        return \App\Modules\RiskManagement\Database\factories\BankFactory::new();
    }

    public function vendors()
    {
        return $this->belongsToMany(
            Vendor::class,
            BankVendor::getTableName(),
            'bank_id',
            'vendor_id'
        )->withPivot(['status', 'iban']);
    }

}
