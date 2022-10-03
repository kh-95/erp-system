<?php

namespace App\Modules\HR\Entities\Interviews;

use App\Foundation\Traits\HasTablePrefixTrait;
use App\Modules\HR\Entities\Items\Item;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use  App\Modules\HR\Entities\BlackList;

class InterviewApplication extends Model
{
    use HasFactory, HasTablePrefixTrait;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $appends = ['is_blocked'];

    public function items()
    {
        return $this->belongsToMany(Item::class,InterviewApplicationItem::getTableName())->withPivot('score');
    }

    public function getIsBlockedAttribute()
    {
        $check = BlackList::whereIdentityNumber($this->identity_number)->orWhere('phone', $this->mobile)->exists();
        return $check;
    }

//    protected static function newFactory()
//    {
//        return \App\Modules\HR\Database\factories\Interviews/InterviewApplicationFactory::new();
//    }
}
