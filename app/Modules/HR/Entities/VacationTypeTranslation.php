<?php

namespace App\Modules\HR\Entities;

use App\Foundation\Traits\HasTablePrefixTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Activitylog\LogOptions;

class VacationTypeTranslation extends Model
{
    use HasFactory,HasTablePrefixTrait;
    public $timestamps = false;


    public $translatedAttributes = ['name'];
    protected $fillable = ['name'];
    protected $table='hr_vacation_type_translations';

    protected static function newFactory()
    {
        return \App\Modules\HR\Database\factories\VacationTypeTranslationFactory::new();
    }


}
