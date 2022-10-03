<?php

namespace App\Modules\HR\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Foundation\Traits\HasTablePrefixTrait;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class ServiceResponse extends Model
{
    use HasFactory, LogsActivity, HasTablePrefixTrait, Translatable;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    protected $guarded = [];
    public $translatedAttributes = ['note'];
    protected $translationForeignKey = 'ser_res_id';

    protected static function newFactory()
    {
        return \App\Modules\HR\Database\factories\ServiceResponseFactory::new();
    }

    public function attachments()
    {
        return $this->hasMany(ServiceResponseAttachment::class,'service_res_id');
    }
}
