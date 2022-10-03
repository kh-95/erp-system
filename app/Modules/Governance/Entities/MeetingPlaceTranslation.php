<?php

namespace App\Modules\Governance\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Foundation\Traits\HasTablePrefixTrait;


class MeetingPlaceTranslation extends Model
{
    use HasFactory, HasTablePrefixTrait;

    public $timestamps = false;
    protected $fillable = ["name"];



}
