<?php

namespace App\Modules\Legal\Entities;

use App\Foundation\Traits\HasTablePrefixTrait;
use App\Modules\HR\Entities\Management;
use Illuminate\Database\Eloquent\Model;
use App\Modules\HR\Entities\Employee;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory, HasTablePrefixTrait;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $table = 'legal_orders';

    const ORDER_MODEL = 'order_model'; //location upload files

    const DRAFT = 'draft';
    const CLIENTS = 'clients';
    const CONSULT = 'consult';
    const MODELS =  'model';
    const REQUEST_TYPES = [self::DRAFT,  self::CLIENTS,  self::CONSULT,  self::MODELS];

    const NO_RESPONSE = 'noresponse';
    const REPLIED = 'replied';

    const REQUEST_Status = [self::NO_RESPONSE, self::REPLIED];


    public function addedBy()
    {
        return $this->belongsTo(Employee::class, 'added_by_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
    public function management()
    {
        return $this->belongsTo(Management::class, 'management_id');
    }

    public function attachments()
    {
        return $this->hasMany(OrderAttachment::class, 'order_id');
    }

    public function consults()
    {
        return $this->hasMany(Consult::class, 'order_id');
    }
}
