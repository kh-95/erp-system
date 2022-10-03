<?php

namespace App\Modules\HR\Entities;

use App\Foundation\Traits\DeactivatedTrait;
use App\Foundation\Traits\HasTablePrefixTrait;
use App\Modules\Governance\Entities\CandidacyApplication;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Nationality extends Model implements TranslatableContract
{
    use HasFactory,SoftDeletes,LogsActivity, DeactivatedTrait,Translatable,HasTablePrefixTrait;

    public $translatedAttributes = ['name'];
    protected $fillable = ['deactivated_at','deleted_at'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name','deactivated_at'])
            ->useLogName('nationalities')
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
    protected static function newFactory()
    {
        return \App\Modules\HR\Database\factories\NationalityFactory::new();
    }

   public function employees()
   {
    return $this->hasMany(Employee::class);
   }

   public function candidacyApplications()
   {
    return $this->hasMany(CandidacyApplication::class);
   }

   public function setDeactivatedAtAttribute($deactivatedAt)
   {

       $this->attributes['deactivated_at'] = $deactivatedAt ? now() : null;
   }
}
