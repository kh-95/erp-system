<?php

namespace App\Modules\RiskManagement\Http\Repositories\Transaction;

use App\Foundation\Traits\ApiResponseTrait;
use App\Foundation\Traits\ImageTrait;
use App\Modules\RiskManagement\Entities\Transaction;
use App\Modules\RiskManagement\Entities\Vendor;
use App\Modules\RiskManagement\Http\Repositories\Transaction\TransactionRepositoryInterface;
use App\Modules\RiskManagement\Http\Repositories\Vendor\VendorRepositoryInterface;
use App\Modules\RiskManagement\Transformers\TransactionResource;
use App\Modules\RiskManagement\Transformers\VendorResource;
use App\Repositories\CommonRepository;

class TransactionRepository extends CommonRepository implements TransactionRepositoryInterface
{
    use ImageTrait, ApiResponseTrait;

    public function model()
    {
        return Transaction::class;
    }

    public function filterColumns()
    {
        return [
            'transaction_number',
            'vendor.class',
            $this->createdAtBetween('created_from'),
            $this->createdAtBetween('created_to'),
            $this->amountBetween('amount_from'),
            $this->amountBetween('amount_to'),
            'payment_type',
            'payment_type_ar',
            'vendor.name',
        ];
    }


    public function sortColumns()
    {
        return [
            'transaction_number',
            'amount',
            'created_at',
            'payment_type_ar',
//            'payment_type',
            $this->sortUsingRelationship('vendor_name', 'rm_vendors.rm_transactions.vendor_id.name'),
            $this->sortUsingRelationship('vendor_class', 'rm_vendors.rm_transactions.vendor_id.class'),
            $this->sortUsingRelationship('vendor_tax_number', 'rm_vendors.rm_transactions.vendor_id.tax_number'),
            $this->sortUsingRelationship('vendor_commercial_record', 'rm_vendors.rm_transactions.vendor_id.commercial_record'),
        ];
    }


    public function show($id)
    {
        return $this->model()::findOrFail($id);

    }
}
