<?php

namespace App\Modules\Legal\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Foundation\Traits\HasTablePrefixTrait;


class InvestigationQuestions extends Model
{
    use HasFactory , HasTablePrefixTrait;

    protected $guarded = [''];

    public function Investigation()
    {
        return $this->belongsTo(Investigation::class, 'investigation_id');
    }

}
