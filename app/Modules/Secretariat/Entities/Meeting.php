<?php

namespace App\Modules\Secretariat\Entities;

use App\Foundation\Traits\HasTablePrefixTrait;
use App\Modules\HR\Entities\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Meeting extends Model
{
    use HasFactory, SoftDeletes, Translatable, HasTablePrefixTrait;

    protected $appends = ['date', 'time', 'time_format', 'type'];
    public $translatedAttributes = ['title' , 'note'];
    protected $fillable = [
         'employee_id', 'meeting_date', 'meeting_room_id', 'meeting_duration'
    ];
    protected $translationForeignKey = 'meeting_id';

    protected $dates = ['meeting_date'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['employee_id', 'meeting_date', 'meeting_room_id', 'meeting_duration',
                       'type'])
            ->useLogName('meetings')
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    protected static function newFactory()
    {
        return \App\Modules\Secretariat\Database\factories\MeetingFactory::new();
    }

    public function meetingManager()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function employeeMeetings()
    {
        return $this->hasMany(EmployeeMeeting::class, 'employee_id');
    }

    public function employees()
    {
        return $this->belongsToMany(
            Employee::class,
            EmployeeMeeting::getTableName(),
            'meeting_id',
            'employee_id'
        )->withPivot(['id', 'status', 'rejected_reason']);
    }

    public function room()
    {
        return $this->belongsTo(MeetingRoom::class, 'meeting_room_id');
    }

    public function discussionPoints()
    {
        return $this->hasMany(MeetingDiscussionPoint::class, 'meeting_id');
    }

    public function decisions()
    {
        return $this->hasMany(MeetingDecision::class, 'meeting_id');
    }

    public function getDateAttribute()
    {
        return $this->meeting_date->format('d-m-Y');
    }

    public function getTimeAttribute()
    {
        return $this->meeting_date->format('H:i');
    }

    public function getTimeFormatAttribute()
    {
        return $this->meeting_date->format('H:i') > "12:00" ? "PM" : "AM";
    }

}
