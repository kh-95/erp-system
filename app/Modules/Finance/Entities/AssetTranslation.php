<?php

namespace App\Modules\Finance\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Foundation\Traits\HasTablePrefixTrait;

class AssetTranslation extends Model
{
    use HasTablePrefixTrait;
    protected $guarded = ['id'];
}
