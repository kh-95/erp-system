<?php

namespace App\Modules\Legal\Entities;

use App\Foundation\Traits\HasTablePrefixTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CaseAgainestCompanyAttach extends Model
{
    use HasFactory,HasTablePrefixTrait;

    protected $guarded = ['id','created_at', 'updated_at'];


}
