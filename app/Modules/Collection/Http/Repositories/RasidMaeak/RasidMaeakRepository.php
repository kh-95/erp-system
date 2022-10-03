<?php

namespace App\Modules\Collection\Http\Repositories\RasidMaeak;

use App\Foundation\Classes\Helper;
use App\Repositories\CommonRepository;
use App\Modules\TempApplication\Transformers\CustomerResource;
use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\TempApplication\Entities\Customer;
use Illuminate\Support\Facades\DB;

class RasidMaeakRepository extends CommonRepository implements RasidMaeakRepositoryInterface
{
    use ApiResponseTrait;

    protected function filterColumns(): array
    {
        return [
            'name',
            'indentity',
            'mobile',
            'contract_number',
            'register_date',
            'money',
            'value_month',
            'value_transfer',
            'value_transfer_available',
            'premiums_paid',
            'premiums_owed',
            'price_owed',
            'price_stay',
            'law_situation'
        ];
    }

    public function sortColumns()
    {
        return [
            'name',
            'indentity',
            'mobile',
            'contract_number',
            'register_date',
            'money',
            'value_month',
            'value_transfer',
            'value_transfer_available',
            'premiums_paid',
            'premiums_owed',
            'price_owed',
            'price_stay',
            'law_situation'
        ];
    }

    public function model()
    {
        return Customer::class;
    }

    public function index(){
        $customers = $this->setFilters()->defaultSort('-created_at')->with(['activities'])->paginate(Helper::PAGINATION_LIMIT);
        return $this->paginateResponse(CustomerResource::collection($customers),$customers);
    }

    public function show($id)
    {
        try{
            $customer = $this->find($id);
            return $this->successResponse(data: CustomerResource::make($customer));
        }catch(\Exception $exception){
            return $this->errorResponse(null, message:$exception->getMessage());
        }

    }


}
