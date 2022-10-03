<?php

namespace App\Modules\Governance\Entities;

use App\Foundation\Traits\HasTablePrefixTrait;
use App\Foundation\Traits\Timestamp;
use App\Modules\Governance\Entities\Committee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SuccessionAttachment extends Model
{
    use HasFactory, Timestamp, HasTablePrefixTrait;

    protected $guarded = ['id', 'created_at', 'updated_at'];


    public function getLocationAttribute()
    {
        return 'succession_attachments';
    }

    public function succession()
    {
        return $this->belongsTo(Succession::class, 'committee_id');
    }
}
