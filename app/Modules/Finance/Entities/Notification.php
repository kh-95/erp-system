<?php

namespace App\Modules\Finance\Entities;

use App\Foundation\Traits\FileTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Foundation\Traits\HasTablePrefixTrait;
use App\Modules\HR\Entities\Management;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Notification extends Model
{
    use HasFactory, HasTablePrefixTrait, LogsActivity ,FileTrait;

    protected $guarded = [];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['date', 'management_id', 'notification_number',
                       'notification_name', 'price', 'complaint_number',
                       'note', 'customer_id', 'to_customer_id'])
            ->useLogName('finance/notification')
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    protected static function newFactory()
    {
        return \App\Modules\Finance\Database\factories\NotificationFactory::new();
    }

    public function management()
    {
        return $this->hasOne(Management::class, 'id', 'management_id');
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class , 'notification_id');
    }

}
