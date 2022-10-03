<?php

namespace App\Modules\Secretariat\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Foundation\Traits\HasTablePrefixTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Message extends Model
{
    use HasFactory, HasTablePrefixTrait, SoftDeletes, LogsActivity;

    protected $guarded = ['id'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['message_number', 'source', 'message_date', 'message_recieve_date', 'message_body'])
            ->useLogName('message')
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    protected static function newFactory()
    {
        return \App\Modules\Secretariat\Database\factories\MessageFactory::new();
    }

    public function claimant(){
        return $this->hasOne(ClaimantData::class, 'message_id');
    }

    public function legal(){
        return $this->hasOne(LegalData::class, 'message_id');
    }

    public function defendant(){
        return $this->hasOne(DefendantData::class, 'message_id');
    }

    public function specialist(){
        return $this->hasOne(SpecialistData::class, 'message_id');
    }

}
