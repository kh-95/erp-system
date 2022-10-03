<?php

namespace App\Modules\Collection\Entities;

use App\Foundation\Traits\HasTablePrefixTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderTranslation extends Model
{
    use HasFactory, HasTablePrefixTrait;

    public $timestamps = false ;
    protected $fillable = ["order_subject","order_text"];

    protected static function newFactory()
    {
        return \App\Modules\Collection\Database\factories\OrderTranslationFactory::new();
    }
}
