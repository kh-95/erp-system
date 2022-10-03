<?php

namespace App\Modules\Governance\Entities;

use App\Foundation\Traits\HasTablePrefixTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NotificationAttachment extends Model
{
    use HasFactory, HasTablePrefixTrait;

    protected $guarded = ['id','created_at', 'updated_at'];
}
