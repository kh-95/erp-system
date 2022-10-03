<?php

namespace App\Modules\Governance\Entities;

use App\Foundation\Traits\HasTablePrefixTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CommitteeEmployee extends Model
{
    use HasFactory, HasTablePrefixTrait;

    protected $table = 'governance_committee_employees';
    public $timestamps = false;
    protected $guarded = [""];
}
