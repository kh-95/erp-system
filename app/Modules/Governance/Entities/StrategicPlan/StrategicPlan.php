<?php

namespace App\Modules\Governance\Entities\StrategicPlan;

use App\Foundation\Traits\FileTrait;
use App\Foundation\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;
use App\Foundation\Traits\HasTablePrefixTrait;
use Astrotomic\Translatable\Contracts\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Modules\Governance\Entities\StrategicPlanAttachment;
use Astrotomic\Translatable\Translatable as TranslatableTrait;

class StrategicPlan extends Model implements Translatable
{
    use HasFactory, HasTablePrefixTrait, Timestamp, TranslatableTrait ,FileTrait;

    const STRATEGICPLAN = 'strategic_plan'; //location upload files

    protected $guarded = ['created_at'];
    public $translatedAttributes = ['title', 'vision'];
    public $with   = ['translations'];
    public $attributes = ['is_active' => true];

    public function planAttributes()
    {
        return $this->hasMany(StrategicPlanAttribute::class);
    }

    public function attachments()
    {
        return $this->hasMany(StrategicPlanAttachment::class);
    }



    public function planAttributeType($type)
    {
        return $this->planAttributes->where('type', $type);
    }
}
