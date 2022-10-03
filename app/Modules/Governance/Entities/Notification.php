<?php

namespace App\Modules\Governance\Entities;

use App\Foundation\Traits\FileTrait;
use App\Foundation\Traits\HasTablePrefixTrait;
use App\Foundation\Traits\Timestamp;
use App\Modules\HR\Entities\Employee;
use App\Modules\HR\Entities\Management;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Notification extends Model
{

    use HasFactory, HasTablePrefixTrait, LogsActivity, Timestamp ,FileTrait;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    const IMAGE = 'image';
    const DOCUMENT = 'document';
    const VIDEO = 'video';

    const FILE_TYPES = [self::IMAGE, self::DOCUMENT, self::VIDEO];


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    #region relationships
    public function management()
    {
        return $this->belongsTo(Management::class,'management_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class,'employee_id');
    }

    public function attachments()
    {
        return $this->hasMany(NotificationAttachment::class, 'notification_id');
    }
    #endregion relationships
}
