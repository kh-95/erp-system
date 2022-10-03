<?php

namespace App\Modules\HR\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Foundation\Traits\HasTablePrefixTrait;

class Activity extends Model
{
    use HasFactory, HasTablePrefixTrait;

    protected $guarded = [];

    protected static function newFactory()
    {
        return \App\Modules\HR\Database\factories\ActivityFactory::new();
    }

    public function management()
    {
        return $this->belongsTo(Management::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
