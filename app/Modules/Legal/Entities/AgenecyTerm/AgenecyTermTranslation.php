<?php

namespace App\Modules\Legal\Entities\AgenecyTerm;

use App\Foundation\Traits\HasTablePrefixTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AgenecyTermTranslation extends Model
{
    use HasFactory, HasTablePrefixTrait;

    protected $fillable = ['name', 'description'];
    public $timestamps = false;
}
