<?php

namespace App\Modules\HR\Entities;

use App\Foundation\Traits\DeactivatedTrait;
use App\Foundation\Traits\HasTablePrefixTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class ResignationReason extends Model implements TranslatableContract
{
    use HasFactory,SoftDeletes,DeactivatedTrait,HasTablePrefixTrait,Translatable;
    public $translatedAttributes = ['reason'];
    protected $fillable = ['resignation_id','deactivated_at','deleted_at','updated_at'];


    protected static function newFactory()
    {
        return \App\Modules\HR\Database\factories\ResignationReasonFactory::new();
    }

    public function resignation()
    {
        return $this->belongsTo(Resignation::class, 'resignation_id');
    }


}
