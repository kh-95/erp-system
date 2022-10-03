<?php

namespace App\Modules\HR\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Foundation\Traits\HasTablePrefixTrait;

class TrainingCourseTranslation extends Model
{
    use HasTablePrefixTrait;
    protected $guarded = ['id', 'created_at', 'updated_at'];
    public $timestamps = false;
}
