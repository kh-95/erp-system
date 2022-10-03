<?php

namespace App\Modules\HR\Entities;

use App\Foundation\Traits\DeactivatedTrait;
use App\Foundation\Traits\HasTablePrefixTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class ResignationAttachment extends Model 
{
    use HasFactory,SoftDeletes,DeactivatedTrait,HasTablePrefixTrait;

    protected $fillable = ['resignation_id','attach','deactivated_at','deleted_at','updated_at'];
   

    protected static function newFactory()
    {
        return \App\Modules\HR\Database\factories\ResignationAttachmentFactory::new();
    }
    
}
