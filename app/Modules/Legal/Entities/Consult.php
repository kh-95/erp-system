<?php

namespace App\Modules\Legal\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Foundation\Traits\HasTablePrefixTrait;

class Consult extends Model
{
    use HasFactory, HasTablePrefixTrait;

    protected $guarded = [];

    protected $table = 'legal_consult';

    protected static function newFactory()
    {
        return \App\Modules\Legal\Database\factories\ConsultFactory::new();
    }

    public function orders()
    {
        return $this->belongsTo(Order::class);
    }

    public function opinion()
    {
        return $this->hasOne(LegalOpinion::class, 'consult_id', 'id');
    }
}
