<?php

namespace App\Modules\Legal\Http\Repositories\Draft;

use App\Repositories\CommonRepository;
use App\Modules\Legal\Http\Repositories\Draft\DraftRepositoryInterface;
use App\Foundation\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use App\Foundation\Classes\Helper;
use App\Modules\Legal\Entities\Order;
use App\Modules\Legal\Transformers\Request\DraftResource;
use App\Modules\Legal\Http\Requests\DraftRequest;

class DraftRepository extends CommonRepository implements DraftRepositoryInterface
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

    public function store(DraftRequest $request)
    {
        $data = $this->create($request->validated())->refresh();
            return $this->apiResource(DraftResource::make($data),true,message: __('Common::message.success_create'),code:201);
    }

    public function show($id)
    {
       $draft_request = $this->find($id);
       return $this->apiResource(DraftResource::make($draft_request),true);
    }
    public function edit($id)
    {
        $draft_request = $this->find($id);
        return $this->apiResource(DraftResource::make($draft_request),true);
    }
    public function updateDraftRequset(DraftRequest $request,$id)
    {

        $draftRequest = $this->find($id);
        $draftRequest->update($request->validated());

        return $this->apiResource(DraftResource::make($draftRequest->refresh()),true,message: __('Common::message.success_update'));
    }



}
