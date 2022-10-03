<?php

namespace App\Modules\Collection\Entities;

use App\Foundation\Traits\HasTablePrefixTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use App\Modules\TempApplication\Entities\Customer;

class Order extends Model implements TranslatableContract
{
    use HasFactory, LogsActivity, Translatable, HasTablePrefixTrait ;

    protected $fillable = [
        'id',
        'order_no',
        'customer_id',
        'order_type',
        'order_date',
        'customer_type',
        'mobile',
        'identity'
    ];

    const COMPLAINT = 'complaint';
    const PROOF_DEATH = 'proof_death';
    const PROOF_INSOLVENCY = 'proof_insolvency';
    const ORDER_TYPES = [self::COMPLAINT, self::PROOF_INSOLVENCY, self::PROOF_INSOLVENCY];
    public $translatedAttributes = ['order_subject', 'order_text'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['order_no', 'customer_type', 'mobile', 'identity',
                       'order_type','order_date','customer_id' ])
            ->logOnlyDirty()
            ->useLogName('Order')
            ->dontSubmitEmptyLogs();
    }

    protected static function newFactory()
    {
        return \App\Modules\Collection\Database\factories\OrderFactory::new();
    }

    public function attachments()
    {
        return $this->hasMany(OrderAttachment::class , 'order_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

}
