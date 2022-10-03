<?php

namespace App\Modules\HR\Entities;

use App\Foundation\Traits\HasTablePrefixTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DeferredDeduct extends Model
{
    use HasFactory , HasTablePrefixTrait;

    protected $table = 'hr_deferred_deducts';
    protected $guarded = [] ;

    protected static function newFactory()
    {
        return \App\Modules\HR\Database\factories\DeferredDeductFactory::new();
    }
}
