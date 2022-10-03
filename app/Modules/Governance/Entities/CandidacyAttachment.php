<?php

namespace App\Modules\Governance\Entities;

use App\Foundation\Traits\HasTablePrefixTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CandidacyAttachment extends Model
{
    use HasFactory, HasTablePrefixTrait;

    protected $table = 'governance_candidacy_attachments';
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $dates = ['created_at', 'updated_at'];



    public function candidacyApplication()
    {
        return $this->belongsTo(CandidacyApplication::class,'candidacy_id');
    }
}
