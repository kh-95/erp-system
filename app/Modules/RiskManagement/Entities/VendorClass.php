<?php

namespace App\Modules\RiskManagement\Entities;

use App\Foundation\Traits\HasTablePrefixTrait;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VendorClass extends Model implements TranslatableContract
{
    use HasFactory ,HasTablePrefixTrait ,Translatable;

    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $dates = ['created_at', 'updated_at'];
    protected $fillable = ['is_active'];
    public $translatedAttributes = ['name'];


    protected static function newFactory()
    {
        return \App\Modules\RiskManagement\Database\factories\VendorClassFactory::new();
    }


    public function vendors()
    {
        return $this->hasMany(Vendor::class,'class_id');
    }


}
