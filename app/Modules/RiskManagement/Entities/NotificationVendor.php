<?php

namespace App\Modules\RiskManagement\Entities;

use App\Foundation\Traits\HasTablePrefixTrait;
use App\Foundation\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class NotificationVendor extends Model
{
    use HasFactory, HasTablePrefixTrait, LogsActivity,Timestamp;

    protected $guarded = [];

    const WAITING_ACTION = 'waiting_action';
    const SEND_NOTIFICATION = 'send_notification';
    const DEACTIVATE_CLIENT = 'deactivate_client';
    const NO_ACTION_REQUIRED = 'no_action_required';
    const TAKEN_ACTIONS = [self::WAITING_ACTION, self::SEND_NOTIFICATION, self::DEACTIVATE_CLIENT, self::NO_ACTION_REQUIRED];

    public function scopeCreatedFrom($query, $date)
    {
        return $query->where('created_at', '>=', date('Y-m-d', strtotime($date)));
    }

    public function scopeCreatedTo($query, $date)
    {
        return $query->where('created_at', '<=', date('Y-m-d', strtotime($date)));
    }

    public function notification()
    {
        return $this->belongsTo(Notification::class, 'notification_id');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    public function takenAction()
    {
        return $this->hasOne(TakenAction::class,'notification_vendor_id');
    }

    protected static function newFactory()
    {
        return \App\Modules\RiskManagement\Database\factories\NotificationVendorFactory::new();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logUnguarded()
            ->useLogName('notification_vendors')
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
