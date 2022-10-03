<?php

namespace App\Modules\Legal\Entities\StaticText;

use App\Foundation\Traits\HasTablePrefixTrait;
use App\Foundation\Traits\Timestamp;
use Astrotomic\Translatable\Contracts\Translatable;
use Astrotomic\Translatable\Translatable as TranslatableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StaticText extends Model implements Translatable
{
    use HasFactory, HasTablePrefixTrait, Timestamp, TranslatableTrait;

    protected $guarded = ['created_at', 'deleted_at'];
    public $translatedAttributes = ['name', 'description'];
    public $with   = ['translations'];
}
