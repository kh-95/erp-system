<?php

namespace App\Modules\Legal\Entities;

use App\Foundation\Traits\HasTablePrefixTrait;
use App\Modules\HR\Entities\Employee;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CaseAgainestCompany extends Model
{
    use HasFactory, HasTablePrefixTrait;

    protected $guarded = ['id', 'created_at', 'updated_at'];
    public $with = ['attachments', 'claimant', 'employee'];
    const PENDING = 'pending';
    const PROCESSING = 'processing';
    const FINISHED = 'finished';
    protected $appends = ['latest_date_session_for_court'];

    const STATUSES = [self::PENDING, self::PROCESSING, self::FINISHED];

    const BANKING_DISPUTE_TRIBUNAL = 'banking_dispute_tribunal';
    const COMMERICIAL_COURT = 'commericial_court';
    const LABOR_COURT = 'labor_court';
    const GENERAL_COURT = 'general_court';
    const APPELLATE_COURT = 'appellate_court';
    const EXECUTION_COURT = 'execution_court';
    const REVIEW_COURT = 'review_court';

    const COURTS = [
        self::BANKING_DISPUTE_TRIBUNAL, self::COMMERICIAL_COURT, self::LABOR_COURT,
        self::GENERAL_COURT, self::APPELLATE_COURT, self::EXECUTION_COURT, self::REVIEW_COURT
    ];

    // Relationships

    public function claimant()
    {
        return $this->hasOne(Claimant::class, 'case_againest_company_id');
    }

    public function attachments()
    {
        return $this->hasMany(CaseAgainestCompanyAttach::class, 'case_anti_comp_id');
    }

    public function sessions()
    {
        return $this->hasMany(CourtSession::class, 'case_againest_company_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    // Scopes
    

    // Mutators
    public function getLatestDateSessionForCourtAttribute()
    {
        return $this->sessions()->orderByDesc('session_date')->value('session_date');
    }
}
