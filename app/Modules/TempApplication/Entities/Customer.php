<?php

namespace App\Modules\TempApplication\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Foundation\Traits\HasTablePrefixTrait;
use App\Modules\Collection\Entities\Operation;
use App\Modules\Collection\Entities\Installment;

class Customer extends Model
{
    use HasFactory, HasTablePrefixTrait;

    protected $guarded = [];

    protected static function newFactory()
    {
        return \App\Modules\TempApplication\Database\factories\CustomerFactory::new();
    }

    public function operations(){

        return $this->hasMany(Operation::class);
    }

    public function installments(){

        return $this->hasMany(Installment::class);
    }
}
