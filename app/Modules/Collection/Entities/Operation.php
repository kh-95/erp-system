<?php

namespace App\Modules\Collection\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Foundation\Traits\HasTablePrefixTrait;
use App\Foundation\Traits\Timestamp;
use App\Modules\TempApplication\Entities\Customer;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Operation extends Model
{
    use HasFactory, LogsActivity, HasTablePrefixTrait, Timestamp;


    protected $guarded = [];
    protected $table = 'collection_operations';


    protected static function newFactory()
    {
        return \App\Modules\Collection\Database\factories\OperationFactory::new();
    }

    public function generateOperationNumber(): int
    {
        $operationNumber = random_int(100000, 999999);
        if ($this->where('operation_number', $operationNumber)->first()) {
            return $this->generateOperationNumber();
        }
        return $operationNumber;
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

}
