<?php

namespace App\Modules\Collection\Http\Repositories;

use App\Foundation\Classes\Helper;
use App\Repositories\CommonRepository;
use App\Modules\Collection\Transformers\OperationResource;
use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\Collection\Entities\Installment;
use App\Modules\Collection\Entities\Operation;
use App\Modules\Collection\Transformers\InstallmentResource;
use App\Modules\TempApplication\Entities\Customer;
use Illuminate\Support\Facades\DB;

class InstallmentRepository extends CommonRepository implements InstallmentRepositoryInterface
{
    use ApiResponseTrait;

    protected function filterColumns(): array
    {
        return [
            'id',
            'customer_id.indentity',
            'customer.name',
            'customer.mobile',
            'date_from',
            'date_to',
            'status',
            'amount_from',
            'amount_to',
            'customer_service_id'
        ];
    }

    public function sortColumns()
    {
        return [
            'id',
            $this->sortUsingRelationship('customer-indentity', Customer::getTableName() . '.' . Installment::getTableName() . '.' . 'customer_id.indentity'),
            $this->sortUsingRelationship('customer-name', Customer::getTableName() . '.' . Installment::getTableName() . '.' . 'customer_id.name'),
            $this->sortUsingRelationship('customer-phone', Customer::getTableName() . '.' . Installment::getTableName() . '.' . 'customer_id.phone'),
            'amount_from',
            'date_entitlement',
            'status',
            'penalty_value_delay'

        ];
    }





    public function model()
    {
        return Installment::class;
    }

    public function show($id)
    {
        return $this->model()::findOrFail($id);
    }
}
