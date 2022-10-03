<?php

namespace App\Modules\Governance\Entities\StrategicPlan;

use App\Foundation\Traits\HasTablePrefixTrait;
use App\Foundation\Traits\Timestamp;
use Astrotomic\Translatable\Contracts\Translatable;
use Astrotomic\Translatable\Translatable as TranslatableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StrategicPlanAttribute extends Model implements Translatable
{
    use HasFactory, HasTablePrefixTrait, Timestamp, TranslatableTrait;

    protected $guarded = ['created_at'];
    public $translatedAttributes = ['value', 'achievement_method'];
    public $with   = ['translations'];

    const Tasks = 'tasks';
    const TERMS = 'terms';
    const GOALS = 'goals';
    const REQUIREMENTS = 'requirements';
    const TYPES = [self::Tasks, self::TERMS, self::GOALS, self::REQUIREMENTS];
}
