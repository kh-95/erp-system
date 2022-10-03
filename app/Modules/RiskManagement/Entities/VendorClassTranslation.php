<?php


namespace App\Modules\RiskManagement\Entities;

use App\Foundation\Traits\HasTablePrefixTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class VendorClassTranslation extends Model
{
    use HasFactory, HasTablePrefixTrait;
    public $timestamps = false;


    public $translatedAttributes = ['name'];
    protected $fillable = ['name'];

    protected static function newFactory()
    {
        return \App\Modules\RiskManagement\Database\factories\VendorClassTranslationFactory::new();
    }


}
