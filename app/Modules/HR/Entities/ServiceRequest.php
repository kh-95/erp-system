<?php

namespace App\Modules\HR\Entities;

use App\Foundation\Traits\HasTablePrefixTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class ServiceRequest extends Model
{
    use HasFactory, LogsActivity, HasTablePrefixTrait, Translatable;

    protected $guarded = ['id'];
    protected $table = 'hr_service_requests';
    public $with = ['attachments','management','employee'];
    public $translatedAttributes = ['notes'];
    protected $translationForeignKey = 'ser_req_id';

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function management()
    {
        return $this->belongsTo(Management::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function attachments()
    {
        return $this->hasMany(ServiceReqAttach::class,'service_req_id');
    }

    public function serviceresponse()
    {
        return $this->hasOne(ServiceResponse::class,'service_request_id');
    }

}
