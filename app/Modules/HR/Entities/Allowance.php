<?php

namespace App\Modules\HR\Entities;

use App\Foundation\Traits\HasTablePrefixTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Allowance extends Model
{
    use HasFactory, HasTablePrefixTrait;

    protected $fillable = ['title'];
    protected static function newFactory()
    {
        return \App\Modules\HR\Database\factories\AllowanceFactory::new();
    }
}
