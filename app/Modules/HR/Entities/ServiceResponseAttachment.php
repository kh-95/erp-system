<?php

namespace App\Modules\HR\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Foundation\Traits\HasTablePrefixTrait;

class ServiceResponseAttachment extends Model
{
    use HasFactory, HasTablePrefixTrait;

    protected $guarded = [];

    protected static function newFactory()
    {
        return \App\Modules\HR\Database\factories\ServiceResponseAttachmentFactory::new();
    }

}
