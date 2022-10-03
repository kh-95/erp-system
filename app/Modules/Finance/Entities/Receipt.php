<?php

namespace App\Modules\Finance\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Foundation\Traits\HasTablePrefixTrait;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Receipt extends Model
{
    use HasFactory, HasTablePrefixTrait, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['pay_status', 'customer_type', 'check_number',
                       'money_order_number', 'receipt_date', 'certificate_number',
                       'certificate_date', 'money', 'management_id', 'cash_register', 'Receipt_request_number'])
            ->useLogName('finance/receipt')
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    protected $guarded = [];

    protected static function newFactory()
    {
        return \App\Modules\Finance\Database\factories\ReceiptFactory::new();
    }

    public function receiptCustomer(){
        return $this->hasOne(ReceiptCustomerType::class,'receipt_id');
    }

    public function receiptCustomerService(){
        return $this->hasOne(ReceiptCustomerService::class);
    }

    public function receiptCustomerAccount(){
        return $this->hasOne(ReceiptAccount::class);
    }


    public function attachments()
    {
        return $this->hasMany(ReceiptAttachment::class , 'receipt_id');
    }

}
