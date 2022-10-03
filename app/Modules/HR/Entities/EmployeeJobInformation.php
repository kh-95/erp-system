<?php

namespace App\Modules\HR\Entities;

use App\Foundation\Traits\HasTablePrefixTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class EmployeeJobInformation extends Model
{
    use HasFactory, LogsActivity, HasTablePrefixTrait;

    protected $fillable = [
        'job_id', 'employee_number', 'contract_type',
        'receiving_work_date', 'contract_period','other_allowances',
        'salary_percentage', 'salary', 'employee_id'
    ];
    protected $table = 'hr_employee_job_information';

    protected $dates = ['receiving_work_date'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function job(){
        return $this->belongsTo(Job::class, 'job_id');
    }

    public function employee(){
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    protected static function newFactory()
    {
        return \App\Modules\HR\Database\factories\EmployeeJobInformationFactory::new();
    }
}
