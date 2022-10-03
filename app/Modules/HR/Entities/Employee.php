<?php

namespace App\Modules\HR\Entities;

use App\Foundation\Traits\DeactivatedTrait;
use App\Foundation\Traits\HasTablePrefixTrait;
use App\Modules\CustomerService\Entities\Call;
use App\Modules\CustomerService\Entities\Message;
use App\Modules\Governance\Entities\Committee;
use App\Modules\Governance\Entities\CommitteeEmployee;
use App\Modules\Governance\Entities\Meeting as EntitiesMeeting;
use App\Modules\Governance\Entities\MeetingAttendance;
use App\Modules\Governance\Entities\Regulation;
use App\Modules\Secretariat\Entities\Meeting;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Activitylog\LogOptions;
use App\Modules\HR\config\HrPrefix;
use App\Modules\HR\Entities\HoldHarmless\HoldHarmless;
use App\Modules\Legal\Entities\Order;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Modules\Reception\Entities;
use App\Modules\Secretariat\Entities\Appointment;
use App\Modules\User\Entities\User;


class Employee extends Model
{
    use HasFactory, SoftDeletes, LogsActivity, DeactivatedTrait, HasTablePrefixTrait;

    protected $fillable = [
        'image', 'identification_number', 'nationality_id',
        'first_name', 'second_name', 'third_name', 'last_name',
        'phone', 'identity_date', 'identity_source', 'date_of_birth',
        'marital_status', 'email', 'gender', 'qualification', 'address',
        'deactivated_at', 'directorate', 'company', 'is_directorship_president'
    ];
    protected $table = 'hr_employees';

    protected $dates = ['identity_date', 'date_of_birth'];

    const REST = 'rest';
    const ON_CALL = 'oncall';
    const AVAILABLE = 'available';

    const CALL_STATUSES = [self::REST, self::ON_CALL, self::AVAILABLE];

    // qualification
    const HIGH_SCHOOL = 'highschool';
    const DIPLOMA = 'diplom';
    const BACHELOR = 'bachelor';
    const MASTER =  'master';
    const PHD    = 'phd';
    const QULAIFICATION_LEVELS = [self::HIGH_SCHOOL,  self::DIPLOMA,  self::BACHELOR,  self::MASTER, self::PHD];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    protected static function newFactory()
    {
        return \App\Modules\HR\Database\factories\EmployeeFactory::new();
    }

    public function scopeWithOutBlackList($query)
    {
        return $query->doesntHave('blackList');
    }

    public function scopeDirectorMemeber(Builder $query)
    {
        return $query->where('directorate', 1);
    }

    public function allowances()
    {
        return $this->belongsToMany(
            Allowance::class,
            'hr_allowance_employees',
            'employee_id',
            'allowance_id'
        )->withPivot(['value', 'status']);
    }

    public function nationality()
    {
        return $this->belongsTo(Nationality::class,'nationality_id');
    }

    public function jobInformation()
    {
        return $this->hasOne(EmployeeJobInformation::class, 'employee_id');
    }

    public function job()
    {
        return $this->hasOneThrough(Job::class, EmployeeJobInformation::class, 'employee_id', 'id');
    }

    public function governanceMeetings()
    {
        return $this->belongsToMany(EntitiesMeeting::class,MeetingAttendance::getTableName(),'employee_id','meeting_id')->withPivot('is_manager','management_id','status');
    }


    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }

    public function custodies()
    {
        return $this->hasMany(Custody::class);
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function generateEmployeeNumber(): int
    {
        $employeeNumber = random_int(100000, 999999);
        if ($this->jobInformation()->where('employee_number', $employeeNumber)->first()) {
            return $this->generateEmployeeNumber();
        }
        return $employeeNumber;
    }

    public function blackList()
    {
        return $this->hasOne(BlackList::class);
    }


    public function meetings()
    {
        return $this->belongsToMany(
            Meeting::class,
            'employee_meetings',
            'employee_id',
            'meeting_id'
        )->withPivot(['id', 'status', 'rejected_reason']);
    }

    public function visits()
    {
        return $this->belongsToMany(Visit::class, EmployeeVisit::getTableName());
    }

    public function salaries()
    {
        return $this->hasMany(Salary::class);
    }

    public function deductBounces()
    {
        return $this->hasMany(DeductBounce::class);
    }

    public function salary()
    {
        return $this->hasOne(Salary::class);
    }

    public function deducts()
    {
        return $this->hasMany(DeductBonus::class);
    }

    public function employeeEvalutaions()
    {
        return $this->hasMany(Salary::class);
    }

    public function resignations()
    {
        return $this->hasMany(Resignation::class);
    }


    public function totalMonthDeducts()
    {
        $salaryMonth = \Carbon\Carbon::parse($this->salary->month)->month;
        return $this->deducts()->where('type', 'deduct')
            ->where('action_type', 'amount')
            ->whereNull('applicable_at')
            ->whereMonth('created_at', $salaryMonth)
            ->whereYear('created_at', $this->salary->month)
            ->sum('amount');
    }

    public function getFullNameAttribute()
    {
        return $this->attributes['first_name'] . ' ' . $this->attributes['second_name'] . ' ' . $this->attributes['third_name'] . ' ' . $this->attributes['last_name'];
    }

    /**
     * أذونات الموظف
     */
    public function permissionRequests()
    {
        return $this->hasMany(PermissionRequest::class);
    }

    public function Orders()
    {
        return $this->hasMany(Order::class);
    }

    public function employeejob()
    {
        return $this->belongstoMany(Job::class, EmployeeJobInformation::getTableName(), 'employee_id', 'job_id');
    }


    public function committees()
    {
        return $this->belongsToMany(
            Committee::class,
            'governance_committee_employees',
            'employee_id',
            'committee_id'
        )->withPivot(['is_president']);
    }


    public function calls()
    {
        return $this->hasMany(Call::class);
    }


    public function messages()
    {
        return $this->hasMany(Message::class);
    }


    public function holdharmlesses()
    {
        return $this->hasMany(HoldHarmless::class);
    }

    public function appointments(){

        return $this->hasMany(Appointment::class);

    }


    public function trainingCourses(){

        return $this->hasMany(TrainingCourse::class);

    }

    public function regulations(){

        return $this->hasMany(Regulation::class);

    }


    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
}
