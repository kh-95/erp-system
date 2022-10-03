<?php

namespace App\Modules\RiskManagement\Entities;

use App\Foundation\Traits\HasTablePrefixTrait;
use App\Foundation\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Notification extends Model
{
    use HasFactory, HasTablePrefixTrait, Timestamp, LogsActivity;

    protected $guarded = [];

    protected static function newFactory()
    {
        return \App\Modules\RiskManagement\Database\factories\NotificationFactory::new();
    }

    public function terms()
    {
        return $this->hasMany(NotificationTerm::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logUnguarded()
            ->useLogName('notifications')
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
