<?php

namespace App\Modules\Legal\Entities;

use App\Foundation\Traits\HasTablePrefixTrait;
use App\Foundation\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CompanyCaseSession extends Model
{
    use HasFactory, Timestamp, HasTablePrefixTrait;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function companyCase()
    {
        return $this->belongsTo(CompanyCase::class,'company_case_id');
    }

}
