<?php

namespace App\Modules\Collection\Http\Repositories;

use App\Foundation\Classes\Helper;
use App\Repositories\CommonRepository;
use App\Modules\Collection\Http\Repositories\OperationRepositoryInterface;
use App\Modules\Collection\Transformers\OperationResource;
use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\Collection\Entities\Operation;
use App\Modules\TempApplication\Entities\Customer;
use Illuminate\Support\Facades\DB;

class OperationRepository extends CommonRepository implements OperationRepositoryInterface
{
    use ApiResponseTrait;

    protected function filterColumns(): array
    {
        return [
            'id',
            'customer.indentity',
            'customer.name',
            'customer.mobile',
            'customer.contract_number',
             $this->amountBetween('amount'),
             'date',
            'operation_number',
            'status',
            'customer_service.name'


        ];
    }
    public function sortColumns()
    {
        return [
            'id' ,
            'operation_number' ,
            'amount'  ,
            $this->sortUsingRelationship('customer-indentity',Customer::getTableName().'.'. Operation::getTableName().'.'.'customer_id.indentity'),
            $this->sortUsingRelationship('customer-name',Customer::getTableName().'.'. Operation::getTableName().'.'.'customer_id.name'),
            $this->sortUsingRelationship('customer-mobile',Customer::getTableName().'.'. Operation::getTableName().'.'.'customer_id.mobile'),
            $this->sortUsingRelationship('customer-service-name',Customer::getTableName().'.'. Operation::getTableName().'.'.'customer_id.name'),
             'installment_count',
             'installment_amount',
             'date',
             'status',
        ];
    }

    public function model()
    {
        return Operation::class;
    }





    public function show($id)
    {
        return $this->model()::findOrFail($id);
    }


}
