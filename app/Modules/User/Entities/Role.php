<?php

namespace App\Modules\User\Entities;

use App\Foundation\Traits\HasTablePrefixTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Role extends \Spatie\Permission\Models\Role
{
    use LogsActivity, HasFactory, HasTablePrefixTrait;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'slug', 'deactivated_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function setDeactivatedAtAttribute($deactivatedAt)
    {
        $this->attributes['deactivated_at'] = $deactivatedAt ? now() : null;
    }

    protected static function newFactory()
    {
        return \App\Modules\User\Database\factories\RoleFactory::new();
    }
}
