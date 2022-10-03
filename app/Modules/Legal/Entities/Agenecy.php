<?php

namespace App\Modules\Legal\Entities;

use App\Foundation\Traits\HasTablePrefixTrait;
use App\Foundation\Traits\Timestamp;
use App\Models\Country\Country;
use App\Modules\HR\Entities\Employee;
use App\Modules\HR\Entities\Management;
use App\Modules\Legal\Entities\AgenecyTerm\AgenecyTerm;
use App\Modules\Legal\Entities\AgenecyType\AgenecyType;
use App\Modules\Legal\Entities\StaticText\StaticText;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Agenecy extends Model
{
    use HasFactory, HasTablePrefixTrait, Timestamp;
    protected $guarded = [];
    protected $casts = [
        'agency_type' => 'array',
        'agenecy_type_terms' => 'array',
        'static_texts' => 'array'
    ];

    const YOURSELF = 'yourself';
    const ANOTHER_AGENECY = 'another_agenecy';
    const AGENECY_AS = [self::YOURSELF, self::ANOTHER_AGENECY];

    const END_DATE_OF_MONTH = 'end_date_of_month';
    const MULTIPLE_MONTHS = 'multiple_months';
    const DURATION_TYPE = [self::END_DATE_OF_MONTH, self::MULTIPLE_MONTHS];

    #region Relationships
    public function attachments()
    {
        return $this->hasMany(AgenecyAttachment::class, 'agenecy_id');
    }

    public function clientManagement()
    {
        return $this->belongsTo(Management::class, 'client_management_id');
    }

    public function clientEmployee()
    {
        return $this->belongsTo(Employee::class, 'client_employee_id');
    }

    public function previousAgenecy()
    {
        return $this->belongsTo(static::class, 'previous_agenecy_id');
    }

    public function agentManagement()
    {
        return $this->belongsTo(Management::class, 'agent_management_id');
    }

    public function agentEmployee()
    {
        return $this->belongsTo(Employee::class, 'agent_employee_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function types()
    {
        return $this->morphedByMany(AgenecyType::class, 'agenecable', 'legal_agenecables');
    }

    public function terms()
    {
        return $this->morphedByMany(AgenecyTerm::class, 'agenecable', 'legal_agenecables');
    }

    public function staticTexts()
    {
        return $this->morphedByMany(StaticText::class, 'agenecable', 'legal_agenecables');
    }
    #endregion Relationships
}
