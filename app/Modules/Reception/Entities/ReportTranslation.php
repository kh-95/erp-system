<?php

namespace App\Modules\Reception\Entities;

use App\Foundation\Traits\HasTablePrefixTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReportTranslation extends Model
{
    use HasFactory, HasTablePrefixTrait;
    public $timestamps = false;
    protected $fillable = ['title', 'description'];
}
