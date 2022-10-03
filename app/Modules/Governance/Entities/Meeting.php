<?php

namespace App\Modules\Governance\Entities;

use App\Foundation\Traits\HasTablePrefixTrait;
use App\Modules\HR\Entities\Employee;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Meeting extends Model
{
    use HasFactory,HasTablePrefixTrait;

    protected $guarded = ['id', 'created_at', 'updated_at'];
    public $with = ['meetingPlace','employees'];
    const NORMAL = 'normal';
    const EMERGENCY = 'emergency';
    const MEETING_TYPES = [self::NORMAL, self::EMERGENCY];

    const DAILY = 'daily';
    const WEEKLY = 'weekly';
    const MONTHLY = 'monthly';
    const YEARLY = 'yearly';
    const MEETING_REPLICATION = [self::DAILY, self::WEEKLY, self::MONTHLY, self::YEARLY];

    const IMAGE = 'image';
    const DOCUMENT = 'document';
    const VIDEO = 'video';
    const ATTACHMENT_TYPES = [self::IMAGE, self::DOCUMENT, self::VIDEO];

    // Relationships

    public function points()
    {
        return $this->hasMany(MeetingPoint::class,'meeting_id');
    }

    public function attendances()
    {
        return $this->hasMany(MeetingAttendance::class,'meeting_id');
    }

    public function attachments()
    {
        return $this->hasMany(MeetingAttachment::class,'meeting_id');
    }

    public function meetingPlace()
    {
        return $this->belongsTo(MeetingPlace::class,'meeting_place_id');
    }

    public function employees()
    {
        return $this->belongsToMany(Employee::class,MeetingAttendance::getTableName(),'meeting_id','employee_id')->withPivot('is_manager','management_id','status');
    }



    // Accessors
    public function getStartAtAttribute($val)
    {
        return Carbon::parse($val)->toDayDateTimeString();
    }

    public function getEndAtAttribute($val)
    {
        return Carbon::parse($val)->toDayDateTimeString();
    }

}
