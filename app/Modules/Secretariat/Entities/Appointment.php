<?php

namespace App\Modules\Secretariat\Entities;

use App\Foundation\Traits\DeactivatedTrait;
use App\Foundation\Traits\HasTablePrefixTrait;
use App\Modules\HR\Entities\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Appointment extends Model
{
    use HasFactory,SoftDeletes,LogsActivity, DeactivatedTrait, Translatable, HasTablePrefixTrait,LogsActivity;
    protected $appends = ['date', 'time', 'time_format'];

    public $translatedAttributes = ['title', 'details'];
    protected $fillable = ['employee_id', 'appointment_date', 'deleted_at'];
    protected $dates = ['appointment_date'];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['title','appointment_date'])
            ->useLogName('appointments')
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
//status

const FINISHED = 'finished';
const ON_PROGRESS = 'on_progress';
const FUTURE = 'future';

const APPOINTMENT_STATUS = [self::FINISHED, self::ON_PROGRESS , self::FUTURE];

    protected static function newFactory()
    {
        return \App\Modules\Secretariat\Database\factories\AppointmentFactory::new();
    }

   public function employee()
   {
    return $this->belongsTo(Employee::class,'employee_id');
   }

   public function getDateAttribute()
    {
        return $this->appointment_date->format('d-m-Y');
    }

    public function getTimeAttribute()
    {
        return $this->appointment_date?->format('H:i') ?? '';
    }

    public function getTimeFormatAttribute()
    {
        return $this->appointment_date?->format('H:i') > "12:00" ? "PM" : "AM";
    }

}
