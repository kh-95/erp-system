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
use App\Modules\HR\Entities\ResignationAttachment;

class Resignation extends Model implements TranslatableContract
{
    use HasFactory,SoftDeletes,LogsActivity, DeactivatedTrait,HasTablePrefixTrait,Translatable ,LogsActivity;

    public $translatedAttributes = ['notes'];
    protected $fillable = ['management_id','employee_id','resignation_date','deactivated_at','deleted_at'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['employee_id','deactivated_at'])
            ->useLogName('resignation')
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
    protected static function newFactory()
    {
        return \App\Modules\HR\Database\factories\ResignationFactory::new();
    }

    public function employeeOfresignation()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }


    public function employeeOfmanagement()
    {
        return $this->hasOneThrough(Management::class, EmployeeJobInformation::class, 'management_id', 'id');
    }

    public function management()
    {
        return $this->belongsTo(Management::class, 'management_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }



    public function attachments()
    {
        return $this->hasMany(ResignationAttachment::class);
    }

    public function reasons()
    {
        return $this->hasMany(ResignationReason::class);
    }

    public function setDeactivatedAtAttribute($deactivatedAt)
    {
        $this->attributes['deactivated_at'] = $deactivatedAt ? now() : null;
    }
}
