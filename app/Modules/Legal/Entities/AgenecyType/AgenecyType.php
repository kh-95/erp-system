<?php

namespace App\Modules\Legal\Entities\AgenecyType;

use App\Foundation\Traits\HasTablePrefixTrait;
use App\Foundation\Traits\Timestamp;
use App\Modules\Legal\Entities\AgenecyTerm\AgenecyTerm;
use Astrotomic\Translatable\Contracts\Translatable;
use Astrotomic\Translatable\Translatable as TranslatableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AgenecyType extends Model implements Translatable
{
    use HasFactory, HasTablePrefixTrait, Timestamp, TranslatableTrait;

    protected $guarded = ['created_at', 'deleted_at'];
    public $translatedAttributes = ['name', 'description'];
    public $with   = ['translations'];

    public function agenecyTerms()
    {
        return $this->hasMany(AgenecyTerm::class, 'agenecy_type_id');
    }
}
