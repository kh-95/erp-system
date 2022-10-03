<?php

namespace App\Modules\HR\Entities;

use App\Foundation\Classes\Helper;
use App\Foundation\Traits\CustomDateTrait;
use App\Foundation\Traits\DeactivatedTrait;
use App\Foundation\Traits\HasTablePrefixTrait;
use App\Modules\Legal\Entities\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Notification;

class Management extends Model implements TranslatableContract
{
    use HasFactory, SoftDeletes, LogsActivity, DeactivatedTrait, Translatable, HasTablePrefixTrait ,CustomDateTrait;

    const IMAGE_LOCATION =  Helper::BASE_PATH . '/management';
    protected $appends = ['image_path','is_vacant'];
    protected $table = 'hr_management';

    public $translatedAttributes = ['name', 'description'];

    protected $fillable = [
        'id',
        'parent_id',
        'image',
        'deactivated_at'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'deactivated_at'])
            ->logOnlyDirty()
            ->useLogName('Management')
            ->dontSubmitEmptyLogs();
    }

    protected static function newFactory()
    {
        return \App\Modules\HR\Database\factories\ManagementFactory::new();
    }

    public function parent()
    {
        return $this->belongsTo(__CLASS__, 'parent_id');
    }

    public function employeeJobInformation()
    {
        return $this->hasManyThrough(EmployeeJobInformation::class, Job::class);
    }

    public function childs()
    {
        return $this->hasMany(__CLASS__, 'parent_id');
    }

    public function jobs()
    {
        return $this->hasMany(Job::class, 'management_id');
    }


    public function getImagePathAttribute()
    {
        return $this->image ? asset('storage/' . self::IMAGE_LOCATION . '/' . $this->image) : null;
    }

    public function getIsVacantAttribute()
    {
        return !$this->employeeJobInformation()->exists();
    }

    public function deductBounces()
    {
        return $this->hasMany(DeductBounce::class, 'management_id');
    }

    public function scopeStartsBefore(Builder $query, $date): Builder
    {
        return $query->where('starts_at', '<=', Carbon::parse($date));
    }

    public function legalOrders()
    {
        return $this->hasMany(Order::class);
    }

    public function employeeEvaluations()
    {
        return $this->hasMany(EmployeeEvaluation::class);
    }


    public function resignations()
    {
        return $this->hasMany(Resignation::class);
    }


    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
}
