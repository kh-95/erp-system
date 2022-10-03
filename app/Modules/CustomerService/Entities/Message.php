<?php

namespace App\Modules\CustomerService\Entities;

use App\Foundation\Traits\HasTablePrefixTrait;
use App\Foundation\Traits\Timestamp;
use App\Modules\HR\Entities\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Message extends Model
{
    use HasFactory, HasTablePrefixTrait, Timestamp;

    protected $guarded = [];

    const SMS = 'sms';
    const WHATSAPP = 'whatsapp';

    const TYPES = [self::SMS, self::WHATSAPP];

    protected static function newFactory()
    {
        return \App\Modules\CustomerService\Database\factories\MessageFactory::new();
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
