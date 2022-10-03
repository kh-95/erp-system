<?php

namespace App\Modules\Legal\Entities;

use App\Foundation\Traits\HasTablePrefixTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AgenecyAttachment extends Model
{
    use HasFactory, HasTablePrefixTrait;

    protected $guarded = [];
}
