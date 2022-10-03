<?php

namespace App\Modules\Reception\Entities;

use App\Foundation\Traits\HasTablePrefixTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Modules\HR\Entities\Employee;
use Carbon\Carbon;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;


class Visit extends Model
{
    use HasFactory, SoftDeletes, LogsActivity, Translatable, HasTablePrefixTrait;

    public $translatedAttributes = ['type', 'note'];
    protected $fillable = ['id', 'date', 'management_id', 'status'];
    protected $appends = ['time', 'time_type'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['date', 'management_id', 'type', 'note', 'status'])
            ->useLogName('visit')
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();;
    }

    protected static function newFactory()
    {
        return \App\Modules\Reception\Database\factories\VisitFactory::new();
    }

    public function visitors()
    {
        return $this->hasMany(Visitor::class,'visit_id','id');
    }

    public function getDateAttribute()
    {
        return Carbon::parse($this->attributes['date'])->format('Y-m-d');
    }

    public function getTimeAttribute()
    {
        return Carbon::parse($this->attributes['date'])->format('g:i');
    }

    public function getTimeTypeAttribute()
    {
        return Carbon::parse($this->attributes['date'])->format('A');
    }

    public function employees()
    {
        return $this->belongsToMany(Employee::class,EmployeeVisit::getTableName());
    }

}
