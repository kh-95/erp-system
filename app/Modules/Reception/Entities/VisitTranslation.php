<?php

namespace App\Modules\Reception\Entities;

use App\Foundation\Traits\HasTablePrefixTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VisitTranslation extends Model
{
    use HasFactory, HasTablePrefixTrait;
    public $timestamps = false;

    protected $fillable = ['type', 'note'];
}
