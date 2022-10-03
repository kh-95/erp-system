<?php

namespace App\Modules\HR\Entities\Interviews;

use App\Foundation\Traits\HasTablePrefixTrait;
use App\Modules\HR\Entities\Employee;
use App\Modules\HR\Entities\Items\Item;
use App\Modules\HR\Entities\Job;
use App\Modules\HR\Entities\Management;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Interview extends Model
{
    use HasFactory, LogsActivity, HasTablePrefixTrait;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['addedBy.first_name'])
            ->useLogName('Interview')
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function scopeCreatedDate($query, $date)
    {
        return $query->whereDate('created_at', $date);
    }

    public function scopeNameCandidate($query, $name)
    {
        return $query->whereHas('applications', function ($q) use ($name) {
            $q->where('recommended', 1)->where('name', 'LIKE', "%{$name}%");
        });
    }

    public function scopeManagementId($query, $id)
    {
        return $query->whereHas('job', function ($q) use ($id) {
            $q->where('management_id', $id);
        });
    }

    public function addedBy()
    {
        return $this->belongsTo(Employee::class, 'added_by_id');
    }

    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id');
    }

    public function applications()
    {
        return $this->hasMany(InterviewApplication::class, 'interview_id');
    }

    public function committeeMembers()
    {
        return $this->belongsToMany(Employee::class, InterviewCommitteeMember::getTableName(), 'interview_id', 'member_id');
    }






//    protected static function newFactory()
//    {
//        return \App\Modules\HR\Database\factories\Interviews/InterviewFactory::new();
//    }
}
