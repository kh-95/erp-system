<?php

namespace App\Modules\Legal\Entities;

use App\Foundation\Traits\HasTablePrefixTrait;
use Illuminate\Database\Eloquent\Model;
use App\Modules\HR\Entities\Employee;
use App\Modules\HR\Entities\Management;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Investigation extends Model
{
    use HasFactory ,HasTablePrefixTrait;

    protected $guarded = [];

    const NEW = 'new';
    const ASIGNED = 'asigned';
    const WAITING_APPROVAL = 'waiting_approval';
    const APPROVE = 'approve';

    const INVESTIGATION_STATUS = [self::NEW, self::ASIGNED, self::WAITING_APPROVAL, self::APPROVE];

    const RECOMMENDATION = 'recommendation';
    const SIGN_PUNISHMENT = 'sign_punishment';

    const INVESTIGATION_RESULT = [self::RECOMMENDATION, self::SIGN_PUNISHMENT];

    public function management()
    {
        return $this->belongsTo(Management::class, 'management_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
    public function asignedEmployee()
    {
        return $this->belongsTo(Employee::class, 'asigned_employee');
    }

    public function investigationQuestions()
    {
        return $this->hasMany(InvestigationQuestions::class, 'investigation_id');
    }
    public function attachments()
    {
        return $this->hasMany(InvestigationAttachment::class);
    }


}
