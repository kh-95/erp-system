<?php

namespace App\Modules\CustomerService\Http\Repositories\Call;

use App\Modules\CustomerService\Entities\Call;
use App\Modules\CustomerService\Http\Requests\ConvertCallRequest;
use App\Repositories\CommonRepository;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;

class CallRepository extends CommonRepository implements CallRepositoryInterface
{
    public function model()
    {
        return Call::class;
    }

    public function filterColumns()
    {
        return [
            AllowedFilter::scope('duration'),
            AllowedFilter::scope('waitingTime'),
            'client_name',
            'client_identity_number',
            'client_phone',
            $this->createdAtBetween('created_from'),
            $this->createdAtBetween('created_to'),
            AllowedFilter::exact('employee_id')
        ];
    }


    public function sortColumns()
    {
        return [
            'id',
            'duration',
            'client_name',
            'client_identity_number',
            'client_phone',
            'created_at'
        ];
    }

    public function index(Request $request)
    {
    }

    public function convertCall(ConvertCallRequest $request, Call $call)
    {
        $data = $request->validated();
        $call->update(['convert_to_employee_id' => $data['employee_id']]);

        return $call;
    }
}
