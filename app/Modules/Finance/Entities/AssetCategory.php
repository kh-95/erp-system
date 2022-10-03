<?php

namespace App\Modules\Finance\Entities;

use App\Foundation\Traits\DeactivatedTrait;
use App\Foundation\Traits\HasTablePrefixTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class AssetCategory extends Model implements TranslatableContract
{
    use HasFactory,SoftDeletes,LogsActivity, DeactivatedTrait,HasTablePrefixTrait,Translatable;

    public $translatedAttributes = ['name','notes'];
    protected $fillable = ['revise_no','account_tree_id','destroy_check','destroy_ratio','deactivated_at','deleted_at'];
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['revise_no','deactivated_at'])
            ->useLogName('assetcategory')
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
    protected static function newFactory()
    {
        return \App\Modules\Finance\Database\factories\AssetCategoryFactory::new();
    }


    public function setDeactivatedAtAttribute($deactivatedAt)
    {
        $this->attributes['deactivated_at'] = $deactivatedAt ? now() : null;
    }

    public function account()
    {
        return $this->belongsTo(AccountingTree::class,'account_tree_id');
    }
}
