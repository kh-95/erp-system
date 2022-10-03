<?php

namespace App\Modules\Governance\Entities;

use App\Foundation\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;
use App\Foundation\Traits\HasTablePrefixTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StrategicPlanAttachment extends Model
{
    use HasFactory, HasTablePrefixTrait, Timestamp;

    protected $guarded = [''];
}
