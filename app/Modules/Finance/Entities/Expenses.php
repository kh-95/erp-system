<?php

namespace App\Modules\Finance\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Foundation\Traits\HasTablePrefixTrait;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Expenses extends Model
{
    use HasFactory, HasTablePrefixTrait, LogsActivity;

    protected $guarded = [];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['pay_status', 'customer_type',
                       'date', 'certificate_number',
                       'certificate_date', 'money', 'management_id',
                        'from_cash_register', 'to_cash_register'])
            ->useLogName('finance/expenses')
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    protected static function newFactory()
    {
        return \App\Modules\Finance\Database\factories\ExpensesFactory::new();
    }

    public function expensesCustomer(){
        return $this->hasOne(ExpenseCustomerType::class, 'expense_id');
    }

    public function expensesCustomerService(){
        return $this->hasOne(ExpenseCustomerService::class, 'expense_id');
    }

    public function expensesCustomerAccount(){
        return $this->hasOne(ExpenseCustomerAccount::class, 'expense_id');
    }

    public function attachments()
    {
        return $this->hasMany(ExpenseAttachment::class , 'expense_id');
    }

}
