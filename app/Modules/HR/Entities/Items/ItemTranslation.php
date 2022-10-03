<?php

namespace App\Modules\HR\Entities\Items;

use App\Foundation\Traits\HasTablePrefixTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class ItemTranslation extends Model
{
    use HasFactory, LogsActivity, HasTablePrefixTrait;

    protected $table = 'hr_item_translations';
    public $timestamps = false;
    protected $fillable = ['name'];


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'Item.score'])
            ->useLogName('Item')
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }



    public function Item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

//    protected static function newFactory()
//    {
//        return \App\Modules\HR\Database\factories\InterviewItem/InterviewItemTranslationFactory::new();
//    }
}
