<?php

namespace App\Modules\Finance\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Foundation\Traits\HasTablePrefixTrait;

class ReceiptAccount extends Model
{
    use HasFactory, HasTablePrefixTrait;

    protected $guarded = [];

    protected static function newFactory()
    {
        return \App\Modules\Finance\Database\factories\ReceiptAccountFactory::new();
    }
}
