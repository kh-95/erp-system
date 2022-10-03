<?php

namespace App\Modules\Collection\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Foundation\Traits\HasTablePrefixTrait;

class OrderAttachment extends Model
{
    use HasFactory, HasTablePrefixTrait;

    protected $fillable = ['id','file','order_id'];

    protected static function newFactory()
    {
        return \App\Modules\Collection\Database\factories\OrderAttachmentFactory::new();
    }
}
