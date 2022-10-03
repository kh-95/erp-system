<?php

namespace App\Modules\HR\Http\Repositories\Employee;

use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\HR\Entities\BlackList;
use App\Modules\HR\Entities\Employee;
use App\Modules\HR\Http\Requests\Employee\BlackListRequest;
use App\Modules\HR\Transformers\BlackList\BlackListResource;
use App\Repositories\CommonRepository;
use Carbon\Carbon;

class BlackListRepository extends CommonRepository implements BlackListRepositoryInterface
{
    use ApiResponseTrait;

    public function filterColumns()
    {
        return [
            'id',
            'full_name',
            'identity_number',
            'phone',
            'employee_type',
            $this->createdAtBetween('created_from'),
            $this->createdAtBetween('created_to')
        ];
    }

    public function sortColumns()
    {
        return [
            'id',
            'full_name',
            'identity_number',
            'phone',
            'employee_type',
            'created_at'
        ];
    }

    public function model()
    {
        return BlackList::class;
    }

    public function store(BlackListRequest $request)
    {
        $data = $this->create($request->validated())->refresh();

        if($request->employee_type == BlackList::PREVIOUS_EMPLOYEE){
            $employee = Employee::where('identification_number',$data->identity_number)->firstOrFail();
            $employee->deactivated_at = Carbon::now();
            $employee->save();
        }

        return $this->apiResource(BlackListResource::make($data), true, message: __('Common::message.success_create'), code: 201);
    }

    public function show($id)
    {
        $black_list = $this->find($id);
        return $this->apiResource(BlackListResource::make($black_list), true);
    }

    public function edit($id)
    {
        $black_list = $this->find($id);
        return $this->apiResource(BlackListResource::make($black_list), true);
    }

    public function updateBlackList(BlackListRequest $request, $id)
    {

        $blackList = $this->find($id);
        $blackList->update($request->validated());

        return $this->apiResource(BlackListResource::make($blackList->refresh()), true, message: __('Common::message.success_update'));
    }
}
