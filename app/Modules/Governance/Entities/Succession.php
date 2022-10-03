<?php

namespace App\Modules\Governance\Entities;


use App\Foundation\Traits\HasTablePrefixTrait;
use App\Foundation\Traits\Timestamp;
use App\Modules\HR\Entities\Job;
use App\Modules\HR\Entities\Management;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Succession extends Model
{
    
    use HasFactory, LogsActivity, Translatable, HasTablePrefixTrait, Timestamp;

    protected $guarded = [];
    public $translatedAttributes = ['name'];

    const IMAGE = 'image';
    const DOCUMENT = 'document';
    const VIDEO = 'video';

    const FILE_TYPES = [self::IMAGE, self::DOCUMENT, self::VIDEO];


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'deactivated_at'])
            ->logOnlyDirty()
            ->useLogName('Management')
            ->dontSubmitEmptyLogs();
    }

    public function attachments()
    {
        return $this->hasMany(SuccessionAttachment::class);
    }


    public function items()
    {
        return $this->hasMany(SuccessionItem::class);
    }

    public function management()
    {
        return $this->belongsTo(Management::class);
    }


    public function job()
    {
        return $this->belongsTo(Job::class);
    }
}
