<?php

namespace App\Modules\HR\Entities;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Foundation\Traits\HasTablePrefixTrait;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class TrainingCourse extends Model implements TranslatableContract
{
    use Translatable, LogsActivity, HasTablePrefixTrait;

    public $translatedAttributes = [
        'course_name',
        'notes',
        'rejection_cause',
        'organization_type',
        'organization_name',
        'status',
        'actual_start_status',
    ];

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['course_name'])
            ->logOnlyDirty()
            ->useLogName('TrainingCourse')
            ->dontSubmitEmptyLogs();
    }

    public function employee(){

        return $this->belongsTo(Employee::class,'employee_id');
    }
}
