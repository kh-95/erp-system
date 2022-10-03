<?php

namespace App\Modules\Secretariat\Entities;

use App\Foundation\Traits\HasTablePrefixTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class MeetingDiscussionPoint extends Model
{
    use HasFactory, SoftDeletes, Translatable , HasTablePrefixTrait;

    public $translatedAttributes = ['content'];
    protected $fillable = ['meeting_id'];
    protected $translationForeignKey = 'dess_id';

    protected static function newFactory()
    {
        return \App\Modules\Secretariat\Database\factories\MeetingDiscussionPointFactory::new();
    }
}
