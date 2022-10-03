<?php

namespace App\Modules\HR\Entities;

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

class Vacation extends Model implements TranslatableContract
{
    use HasFactory,SoftDeletes,LogsActivity, DeactivatedTrait,HasTablePrefixTrait,Translatable;

    public $translatedAttributes = ['notes'];
    protected $fillable = ['vacation_employee_id','vacation_type_id','vacation_from_date','vacation_to_date','number_days','alter_employee_id','deactivated_at','deleted_at'];
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name','deactivated_at'])
            ->useLogName('vacation')
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
    protected static function newFactory()
    {
        return \App\Modules\HR\Database\factories\VacationFactory::new();
    }


    public function scopeFrom($query, $date)
    {
        return $query->whereDate('vacation_from_date', '>=', $date);
    }

    public function scopeTo($query, $date)
    {
        return $query->whereDate('vacation_to_date', '<=', $date);
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function employeeOfVacation()
    {
        return $this->belongsTo(Employee::class, 'vacation_employee_id');
    }

    public function alterEmployeeOfVacation()
    {
        return $this->belongsTo(Employee::class, 'alter_employee_id');
    }

    public function Vacationtype()
    {
        return $this->belongsTo(VacationType::class, 'vacation_type_id');
    }

    public function attachments()
    {
        return $this->hasMany(VacationAttachment::class);
    }

    public function setDeactivatedAtAttribute($deactivatedAt)
    {
        $this->attributes['deactivated_at'] = $deactivatedAt ? now() : null;
    }
}
