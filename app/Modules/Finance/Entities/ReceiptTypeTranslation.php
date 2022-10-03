<?php

namespace App\Modules\Finance\Entities;

use App\Foundation\Traits\HasTablePrefixTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Activitylog\LogOptions;

class ReceiptTypeTranslation extends Model
{
    use HasFactory,HasTablePrefixTrait;
    public $timestamps = false;


    public $translatedAttributes = ['name','notes'];
    protected $fillable = ['name','notes'];

    protected static function newFactory()
    {
        return \App\Modules\Finance\Database\factories\ReceiptTypeTranslationFactory::new();
    }


}
