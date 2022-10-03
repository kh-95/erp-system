<?php

namespace App\Modules\Reception\Entities;

use App\Foundation\Traits\HasTablePrefixTrait;
use App\Modules\HR\Entities\Management;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Report extends Model
{
    use HasFactory,SoftDeletes,LogsActivity, HasTablePrefixTrait, Translatable;
    protected $appends = ['time','time_type','check_update'];
    public $translatedAttributes = ['title', 'description'];
    protected $fillable = [
        'id',
        'management_id',
        'status',
        'date',
       ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['title','managment_id','date' ,'status'])
            ->logOnlyDirty()
            ->useLogName('ReceptionReport')
            ->dontSubmitEmptyLogs();
    }

    protected static function newFactory()
    {
        return \App\Modules\Reception\Database\factories\ReceptionReportFactory::new();
    }

    public function management()
    {
        return $this->belongsTo(Management::class);
    }

    public function getDateAttribute()
    {
        return  Carbon::parse($this->attributes['date'])->format('Y-m-d');
    }

    public function getTimeAttribute()
    {
        return  Carbon::parse($this->attributes['date'])->format('g:i');
    }

    public function getTimeTypeAttribute()
    {
        return  Carbon::parse($this->attributes['date'])->format('A');
    }

    public function getCheckUpdateAttribute()
    {
        $date = Carbon::parse($this->attributes['date']);
      return  $date->greaterThanOrEqualTo(Carbon::now())?true :false ;
    }
}
