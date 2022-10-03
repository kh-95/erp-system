<?php

namespace App\Modules\Reception\Entities;

use App\Foundation\Traits\HasTablePrefixTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmployeeVisit extends Model
{
    use HasFactory, HasTablePrefixTrait;

    protected $fillable = ['id','employee_id','visit_id'];

    protected static function newFactory()
    {
        return \App\Modules\Reception\Database\factories\EmployeeVisitFactory::new();
    }

    public function visit()
    {
        return $this->belongsTo(Visit::class);
    }

}
