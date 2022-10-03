<?php

namespace App\Modules\HR\Entities;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Foundation\Traits\HasTablePrefixTrait;
use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;


class ContractClause extends Model implements TranslatableContract
{
    use Translatable, LogsActivity, HasTablePrefixTrait;

    public $translatedAttributes = [
        'item_text',
        'nationality'
    ];
    
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
