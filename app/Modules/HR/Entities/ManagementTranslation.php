<?php

namespace App\Modules\HR\Entities;

use App\Foundation\Traits\HasTablePrefixTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ManagementTranslation extends Model
{
    use HasFactory, HasTablePrefixTrait;

    public $timestamps = false;
    protected $fillable = ["name","description"];

    protected static function newFactory()
    {
        return \App\Modules\HR\Database\factories\ManagementTranslationFactory::new();
    }
}
