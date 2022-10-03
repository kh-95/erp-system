<?php

namespace App\Modules\Finance\Entities;

use App\Foundation\Traits\DeactivatedTrait;
use App\Foundation\Traits\HasTablePrefixTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class ReceiptType extends Model implements TranslatableContract
{
    use HasFactory,SoftDeletes,LogsActivity, DeactivatedTrait,HasTablePrefixTrait,Translatable;

    public $translatedAttributes = ['name','notes'];
    protected $fillable = ['deactivated_at','deleted_at'];
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name','deactivated_at'])
            ->useLogName('expensetype')
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
    protected static function newFactory()
    {
        return \App\Modules\Finance\Database\factories\ReceiptTypeFactory::new();
    }


    public function setDeactivatedAtAttribute($deactivatedAt)
    {
        $this->attributes['deactivated_at'] = $deactivatedAt ? now() : null;
    }
}
