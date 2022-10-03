<?php

namespace App\Modules\Legal\Http\Repositories\Consult;

use App\Repositories\CommonRepository;
use App\Foundation\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use App\Foundation\Classes\Helper;
use App\Modules\Legal\Entities\Order;
use App\Modules\Legal\Http\Requests\ConsultRequest;
use App\Modules\Legal\Transformers\Request\ConsultResource;

class ConsultRepository extends CommonRepository implements ConsultRepositoryInterface
{
    use ApiResponseTrait;

    public function filterColumns()
    {
        return [
            'id',
            'reuest_number',
            'reqest_subject',
            'employee_id',
            'job.management_id',
            'created_at',
        ];
    }

    public function sortColumns()
    {
        return [
            'id',
            'reuest_number',
            'reqest_subject',
            'employee_id',
            'status',
            'created_at',
        ];
    }

    public function model()
    {
        return Order::class;
    }

    public function store(ConsultRequest $request)
    {
        $data = $this->create($request->validated())->refresh();
            return $this->apiResource(ConsultResource::make($data),true,message: __('Common::message.success_create'),code:201);
    }

    public function show($id)
    {
       $consult_request = $this->find($id);
       return $this->apiResource(ConsultResource::make($consult_request),true);
    }
    public function edit($id)
    {
        $consult_request = $this->find($id);
        return $this->apiResource(ConsultResource::make($consult_request),true);
    }
    public function updateConsultRequset(ConsultRequest $request,$id)
    {

        $consultRequest = $this->find($id);
        $consultRequest->update($request->validated());

        return $this->apiResource(ConsultResource::make($consultRequest->refresh()),true,message: __('Common::message.success_update'));
    }



}
