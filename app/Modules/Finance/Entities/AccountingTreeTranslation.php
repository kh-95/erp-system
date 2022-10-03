<?php

namespace App\Modules\Finance\Entities;

use App\Foundation\Traits\HasTablePrefixTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Activitylog\LogOptions;


class AccountingTreeTranslation extends Model
{
    use HasFactory,HasTablePrefixTrait;
    public $timestamps = false;


    protected $fillable = ['account_name','notes'];

    protected static function newFactory()
    {
        return \App\Modules\Finance\Database\factories\AccountingTreeTranslationFactory::new();
    }

}
