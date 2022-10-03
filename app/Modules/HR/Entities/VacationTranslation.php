<?php

namespace App\Modules\HR\Entities;

use App\Foundation\Traits\HasTablePrefixTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Activitylog\LogOptions;

class VacationTranslation extends Model
{
    use HasFactory,HasTablePrefixTrait;
    public $timestamps = false;


    public $translatedAttributes = ['notes'];
    protected $fillable = ['notes'];
    protected $table='hr_vacation_translations';

    protected static function newFactory()
    {
        return \App\Modules\HR\Database\factories\VacationTranslationFactory::new();
    }


}
