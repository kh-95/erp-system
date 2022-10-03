<?php

namespace App\Modules\RiskManagement\Entities;

use App\Foundation\Traits\HasTablePrefixTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TakenActionAttachment extends Model
{
    use HasFactory, HasTablePrefixTrait;

    protected $guarded = [];
}
