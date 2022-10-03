<?php

namespace App\Modules\HR\Entities\Interviews;

use App\Foundation\Traits\HasTablePrefixTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InterviewApplicationItem extends Model
{
    use HasFactory, HasTablePrefixTrait;

    protected $guarded = ['id', 'created_at', 'updated_at'];
//    protected static function newFactory()
//    {
//        return \App\Modules\HR\Database\factories\Interviews/InterviewApplicationItemFactory::new();
//    }
}
