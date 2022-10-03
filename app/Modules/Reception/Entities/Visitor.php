<?php

namespace App\Modules\Reception\Entities;

use App\Foundation\Traits\HasTablePrefixTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Visitor extends Model
{
    use HasFactory, SoftDeletes, LogsActivity, HasTablePrefixTrait;

    protected $fillable = ['id', 'identity_number', 'name', 'visit_id'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['name', 'identity_number', 'visit_id'])
        ->useLogName('visit')
        ->logOnlyDirty();
    }

    protected static function newFactory()
    {
        return \App\Modules\Reception\Database\factories\VisitorFactory::new();
    }

    public function visit()
    {
        return $this->belongsTo(Visit::class);
    }

}
