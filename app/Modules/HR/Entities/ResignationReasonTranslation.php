<?php

namespace App\Modules\HR\Entities;

use App\Foundation\Traits\HasTablePrefixTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Activitylog\LogOptions;

class ResignationReasonTranslation extends Model
{
    use HasFactory,HasTablePrefixTrait;
    public $timestamps = false;


    public $translatedAttributes = ['reason'];
    protected $fillable = ['reason'];

    protected static function newFactory()
    {
        return \App\Modules\HR\Database\factories\ResignationReasonTranslationFactory::new();
    }


}
