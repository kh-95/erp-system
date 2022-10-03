<?php

namespace App\Modules\HR\Entities;

use App\Foundation\Traits\HasTablePrefixTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ServiceRequestTranslation extends Model
{
    use HasFactory, HasTablePrefixTrait;

    protected $guarded = ['id'];
    public $timestamps = false;

}
