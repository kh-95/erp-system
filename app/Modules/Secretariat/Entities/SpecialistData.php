<?php

namespace App\Modules\Secretariat\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Foundation\Traits\HasTablePrefixTrait;
use App\Modules\HR\Entities\{Management,Employee};
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class SpecialistData extends Model
{
    use HasFactory, HasTablePrefixTrait, SoftDeletes;

    protected $guarded = [];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['management_id', 'employee_id'])
            ->useLogName('specialistWithMessage')
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    protected static function newFactory()
    {
        return \App\Modules\Secretariat\Database\factories\SpecialistDataFactory::new();
    }

    public function management()
    {
        return $this->belongsTo(Management::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
