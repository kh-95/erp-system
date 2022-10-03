<?php

namespace App\Modules\HR\Entities;

use App\Foundation\Traits\HasTablePrefixTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SalaryApprove extends Model
{
    use HasFactory, HasTablePrefixTrait;
    protected $guarded = [];

    protected static function newFactory()
    {
        return \App\Modules\HR\Database\factories\SalaryApproveFactory::new();
    }
}
