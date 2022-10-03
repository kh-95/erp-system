<?php

namespace App\Modules\HR\Entities;

use App\Foundation\Traits\HasTablePrefixTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class AllowanceEmployee extends Pivot
{
    use HasFactory, HasTablePrefixTrait;

    protected $fillable = ['allowance_id', 'employee_id', 'value', 'status'];

}
