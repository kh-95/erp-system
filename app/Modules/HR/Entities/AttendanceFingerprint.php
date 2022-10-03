<?php

namespace App\Modules\HR\Entities;

use App\Foundation\Traits\HasTablePrefixTrait;
use App\Foundation\Traits\Timestamp;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AttendanceFingerprint extends Model
{
    use HasFactory, Timestamp, HasTablePrefixTrait;

    protected $guarded = [];
    protected $dates = ['attened_at', 'leaved_at'];

    const FINGERPRINT = 'fingerprint';
    const IDENTITY     = 'identity';
    const METHODS = [self::FINGERPRINT, self::IDENTITY];

    const RASID = 'rasid';
    const TASAHEEL = 'tasaheel';
    const MAIN_BRANCH = 'main_branch';
    const BRANCHES = [self::RASID, self::TASAHEEL, self::MAIN_BRANCH];

    const LATE = 'late';
    const EARLY_LEAVE = 'early_leave';
    const ABSENCE = 'absence';
    const PUNISHMENT = [self::LATE, self::EARLY_LEAVE, self::ABSENCE];

    const WAITING = 'waiting';
    const APPROVED = 'approved';
    const REJECTED  = 'rejected';
    const PUNISHMENT_STATUS = [self::WAITING, self::APPROVED, self::REJECTED];

    protected static function newFactory()
    {
        return \App\Modules\HR\Database\factories\AttendanceFingerprintFactory::new();
    }

    public function getAttendedAtAttribute($value)
    {
        $locale = app()->getLocale();

        return Carbon::parse($value)->locale($locale)->translatedFormat('j F Y - h:i A');
    }

    // public function getLeavedAtAttribute($value)
    // {
    //     $locale = app()->getLocale();

    //     return Carbon::parse($value)->locale($locale)->translatedFormat('j F Y - h:i A');
    // }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
