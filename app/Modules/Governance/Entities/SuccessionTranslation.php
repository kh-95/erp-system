<?php

namespace App\Modules\Governance\Entities;

use App\Foundation\Traits\HasTablePrefixTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SuccessionTranslation extends Model
{
    use HasFactory, HasTablePrefixTrait;

    protected $fillable = ['name'];
    public $timestamps = false;
}
