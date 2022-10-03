<?php

namespace App\Modules\Finance\Entities;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Foundation\Traits\HasTablePrefixTrait;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class Asset extends Model implements TranslatableContract
{
    use Translatable, LogsActivity, HasTablePrefixTrait;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public $translatedAttributes = [
        'name',
        'category',
        'measure_unit',
        'tax',
        'description'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name'])
            ->logOnlyDirty()
            ->useLogName('Asset')
            ->dontSubmitEmptyLogs();
    }  
}
