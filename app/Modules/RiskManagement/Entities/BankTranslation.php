<?php

namespace App\Modules\RiskManagement\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Foundation\Traits\HasTablePrefixTrait;


class BankTranslation extends Model
{
    use HasFactory, HasTablePrefixTrait;

    public $timestamps = false;
    protected $fillable = ["name"];

    protected static function newFactory()
    {
        return \App\Modules\RiskManagement\Database\factories\BankTranslationFactory::new();
    }

}
