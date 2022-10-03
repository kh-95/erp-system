<?php

namespace App\Modules\Governance\Entities;

use App\Foundation\Traits\HasTablePrefixTrait;
use App\Foundation\Traits\Timestamp;
use App\Modules\Governance\Entities\Committee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CommitteeAttachment extends Model
{
    use HasFactory, Timestamp, HasTablePrefixTrait;

    protected $guarded = ['id', 'created_at', 'updated_at'];


    public function committee()
    {
        return $this->belongsTo(Committee::class,'committee_id');
    }


    public function getLocationAttribute()
    {
        return 'committee_attachments';
    }
}
