<?php

namespace App\Modules\Legal\Entities;

use App\Foundation\Traits\HasTablePrefixTrait;
use App\Foundation\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InvestigationAttachment extends Model
{
    use HasFactory, Timestamp, HasTablePrefixTrait;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function investigation()
    {
        return $this->belongsTo(Investigation::class,'investigation_id');
    }
}
