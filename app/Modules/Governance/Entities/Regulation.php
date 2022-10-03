<?php

namespace App\Modules\Governance\Entities;

use App\Foundation\Traits\FileTrait;
use App\Foundation\Traits\HasTablePrefixTrait;
use App\Modules\HR\Entities\Employee;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Regulation extends Model implements TranslatableContract
{
    use HasFactory, Translatable, HasTablePrefixTrait ,FileTrait;

    const REGULATION = 'regulation'; //location upload files

    protected $guarded = ['id', 'created_at', 'updated_at'];
    public $translatedAttributes = ['title', 'description'];

    public function addedBy()
    {
        return $this->belongsTo(Employee::class, 'added_by_id');
    }

    public function regulationAttachments()
    {
        return $this->hasMany(RegulationAttachment::class, 'regulation_id');
    }

    protected static function newFactory()
    {
        return \App\Modules\Governance\Database\factories\RegulationFactory::new();
    }
}
