<?php

namespace App\Modules\Legal\Entities;

use App\Foundation\Traits\HasTablePrefixTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderAttachment extends Model
{
    use HasFactory, HasTablePrefixTrait;

    protected $table = 'legal_order_attachment';
    protected $guarded = ['id', 'created_at', 'updated_at'];


    protected static function newFactory()
    {
        return \App\Modules\Legal\Database\factories\OrderAttachmentFactory::new();
    }
}
