<?php

namespace App\Modules\RiskManagement\Entities;

use App\Foundation\Traits\HasTablePrefixTrait;
use App\Foundation\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransactionAttachment extends Model
{
    use HasFactory, Timestamp, HasTablePrefixTrait;

    protected $guarded = ['id', 'created_at', 'updated_at'];
    public $with = ['attachments'];

}
