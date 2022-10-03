<?php

namespace App\Modules\Secretariat\Entities;

use App\Foundation\Traits\HasTablePrefixTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmployeeMeeting extends Model
{
    use HasFactory, HasTablePrefixTrait;

    protected $fillable = ['employee_id', 'meeting_id', 'status', 'rejected_reason'];

    public $timestamps = false;

    protected $dates = ['status'];

    protected static function newFactory()
    {
        return \App\Modules\Secretariat\Database\factories\EmployeeMeetingFactory::new();
    }
}
