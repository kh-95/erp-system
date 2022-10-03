<?php

namespace App\Modules\Secretariat\Entities;

use App\Foundation\Traits\HasTablePrefixTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class MeetingRoom extends Model
{
    use HasFactory, SoftDeletes, Translatable, HasTablePrefixTrait;

    public $translatedAttributes = ['name'];
    protected $fillable = [];
    protected $translationForeignKey = 'meeting_room_id';

    protected static function newFactory()
    {
        return \App\Modules\Secretariat\Database\factories\MeetingRoomFactory::new();
    }

    public function meetings()
    {
        return $this->hasMany(Meeting::class);
    }
}
