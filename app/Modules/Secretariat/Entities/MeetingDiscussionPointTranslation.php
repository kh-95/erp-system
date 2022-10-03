<?php

namespace App\Modules\Secretariat\Entities;

use App\Foundation\Traits\HasTablePrefixTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MeetingDiscussionPointTranslation extends Model
{
    use HasFactory, HasTablePrefixTrait;
    public $timestamps = false;

    protected $fillable = ['content'];
}
