<?php

namespace App\Modules\Governance\Entities;

use App\Foundation\Traits\HasTablePrefixTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class RegulationTranslation extends Model
{
    use HasFactory, LogsActivity, HasTablePrefixTrait;

    public $timestamps = false;
    protected $fillable = ['title', 'description'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['title', 'description', 'regulation.from_year', 'regulation.to_year', 'regulation.is_active', 'regulation.added_by_id'])
            ->useLogName('Regulation')
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function regulation()
    {
        return $this->belongsTo(Regulation::class, 'regulation_id');
    }

    protected static function newFactory()
    {
        return \App\Modules\Governance\Database\factories\RegulationTranslationFactory::new();
    }
}
