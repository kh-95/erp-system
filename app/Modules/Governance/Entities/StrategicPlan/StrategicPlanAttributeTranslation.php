<?php

namespace App\Modules\Governance\Entities\StrategicPlan;

use App\Foundation\Traits\HasTablePrefixTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StrategicPlanAttributeTranslation extends Model
{
    use HasFactory, HasTablePrefixTrait;

    protected $fillable = ['value', 'achievement_method'];
    public $timestamps = false;
}
