<?php

namespace App\Modules\HR\Entities;

use App\Foundation\Traits\HasTablePrefixTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Custody extends Model
{
    use HasFactory, LogsActivity, HasTablePrefixTrait;

    protected $fillable = ['received_date', 'employee_id', 'count', 'description', 'delivery_date', 'type'];

    protected $dates = ['received_date', 'delivery_date'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
