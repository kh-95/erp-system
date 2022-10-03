<?php

namespace App\Modules\HR\Entities;

use App\Foundation\Traits\HasTablePrefixTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Model
{
    use HasFactory, HasTablePrefixTrait;

    protected $fillable = [];

    protected static function newFactory()
    {
        return \App\Modules\HR\Database\factories\UserFactory::new();
    }
}
