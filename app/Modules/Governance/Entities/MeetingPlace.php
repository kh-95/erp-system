<?php

namespace App\Modules\Governance\Entities;

use App\Foundation\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use App\Foundation\Traits\DeactivatedTrait;
use App\Foundation\Traits\HasTablePrefixTrait;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;

class MeetingPlace extends Model implements TranslatableContract
{
    use HasFactory, SoftDeletes, LogsActivity, DeactivatedTrait, Translatable, HasTablePrefixTrait ,Timestamp;

    protected $guarded = [];
    public $translatedAttributes = ['name'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'deactivated_at'])
            ->logOnlyDirty()
            ->useLogName('MeetingPlace')
            ->dontSubmitEmptyLogs();
    }

    public function meetings()
    {
        return $this->hasMany(Meeting::class,'meeting_place_id');
    }










}
