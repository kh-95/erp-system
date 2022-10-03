<?php

namespace App\Modules\Legal\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Foundation\Traits\HasTablePrefixTrait;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class LegalOpinion extends Model
{
    use HasFactory , HasTablePrefixTrait;
    protected $guarded = ['id'];
    //protected $table = 'legalopinions';

    public function consults()
    {
        return $this->belongsTo(Consult::class, 'consult_id');
    }


    protected static function newFactory()
    {
        return \App\Modules\Legal\Database\factories\LegalOpinionFactory::new();
    }

}
