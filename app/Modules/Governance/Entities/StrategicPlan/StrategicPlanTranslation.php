<?php

namespace App\Modules\Governance\Entities\StrategicPlan;

use App\Foundation\Traits\HasTablePrefixTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StrategicPlanTranslation extends Model
{
    use HasFactory, HasTablePrefixTrait;

    protected $fillable = ['title', 'vision'];
    public $timestamps = false;
}
