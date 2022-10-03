<?php

namespace App\Modules\HR\Entities;

use App\Foundation\Traits\HasTablePrefixTrait;
use App\Modules\HR\Entities\Items\Item;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmployeeEvaluation extends Model
{
    use HasFactory,HasTablePrefixTrait;

    protected $guarded = ['id', 'created_at','updated_at'];
    public $with = ['management','employee','employeeeEvaluatiuons'];

    const PASSED = 'passed';
    const EXTENSION = 'extension';
    const TERMINATION = 'termination';
    const RECOMMENDATION = [self::PASSED, self::EXTENSION, self::TERMINATION];


    // Relationships
    public function items()
    {
        return $this->belongsToMany(Item::class, EmployeeEvaluationItem::getTableName(), 'employee_evaluation_id', 'item_id')->withPivot('is_passed');
    }

    public function management()
    {
        return $this->belongsTo(Management::class, 'management_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id');
    }

    public function employeeeEvaluatiuons()
    {
        return $this->hasMany(EmployeeEvaluationItem::class,'employee_evaluation_id');
    }


}
