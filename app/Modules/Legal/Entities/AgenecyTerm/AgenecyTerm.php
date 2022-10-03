<?php

namespace App\Modules\Legal\Entities\AgenecyTerm;

use App\Foundation\Traits\HasTablePrefixTrait;
use App\Foundation\Traits\Timestamp;
use App\Modules\Legal\Entities\AgenecyType\AgenecyType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Astrotomic\Translatable\Contracts\Translatable;
use Astrotomic\Translatable\Translatable as TranslatableTrait;

class AgenecyTerm extends Model implements Translatable
{
    use HasFactory, HasTablePrefixTrait, Timestamp, TranslatableTrait;

    protected $guarded = ['created_at', 'deleted_at'];
    public $translatedAttributes = ['name', 'description'];
    public $with   = ['translations'];

    public function agenecyType()
    {
        return $this->belongsTo(AgenecyType::class, 'agenecy_type_id');
    }
}
