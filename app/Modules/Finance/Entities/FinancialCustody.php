<?php

namespace App\Modules\Finance\Entities;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Foundation\Traits\HasTablePrefixTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FinancialCustody extends Model
{
    use LogsActivity, HasTablePrefixTrait;

    protected $guarded = ['id', 'created_at','updated_at'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['bill_number'])
            ->logOnlyDirty()
            ->useLogName('FinancialCustody')
            ->dontSubmitEmptyLogs();
    }  
    
    
}
