<?php

namespace App\Modules\HR\Entities;

use App\Foundation\Traits\CustomDateTrait;
use App\Foundation\Traits\DeactivatedTrait;
use App\Foundation\Traits\HasTablePrefixTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Job extends Model implements TranslatableContract
{
    use HasFactory,SoftDeletes,LogsActivity,DeactivatedTrait, Translatable, HasTablePrefixTrait ,CustomDateTrait;

    protected $appends = ['is_empty'];
    const SALARY_PERCENTAGE = 'salary_percentage';
    const SALARY = 'salary';
    const PERCENTAGE = 'percentage';
    const SALARY_TYPES = [self::SALARY_PERCENTAGE, self::SALARY, self::PERCENTAGE];
    protected $fillable = [
        'id',
        'management_id',
        'is_manager',
        'employees_job_count',
        'salary_type',
        'deactivated_at',
    ];
    protected $table = 'hr_jobs';

    public $translatedAttributes = ['name', 'description'];


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name','managment_id' ,'deactivated_at'])
            ->logOnlyDirty()
            ->useLogName('Job')
            ->dontSubmitEmptyLogs();
    }

    protected static function newFactory()
    {
        return \App\Modules\HR\Database\factories\JobFactory::new();
    }

    public function management()
    {
        return $this->belongsTo(Management::class);
    }
    public function employees()
    {
        return $this->hasManyThrough(
            Employee::class,
            EmployeeJobInformation::class,
            'job_id',
            'id',
        );
    }
    public function getIsEmptyAttribute()
    {
        return (boolean)((int)$this->employees_job_count - (int)$this->employees_count) ? true : false;
    }

    public function Orders()
    {
        return $this->hasMany(Order::class);
    }

    public function EmployeeJobInformationManager()
    {
        return $this->hasOne(EmployeeJobInformation::class);
    }

    public function employeeEvaluations()
    {
        return $this->hasMany(EmployeeEvaluation::class);
    }
  
}
