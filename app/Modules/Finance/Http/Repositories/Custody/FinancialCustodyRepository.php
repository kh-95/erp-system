<?php

namespace App\Modules\Finance\Http\Repositories\Custody;

use App\Repositories\CommonRepository;
use App\Modules\Finance\Entities\FinancialCustody;
use App\Modules\Finance\Http\Repositories\Custody\FinancialCustodyRepositoryInterface;

class FinancialCustodyRepository extends CommonRepository implements FinancialCustodyRepositoryInterface
{
    protected function filterColumns(): array
    {
        return [
            'bill_number',
            'tax_number',
            'supplier_name'
        ];
    }

    public function store($request)
    {
       return $this->model->create($request);
    }

    public function update($request, $id)
    {
        return $this->model->find($id)->update($request);
    }

    public function destroy($id)
    {
        $this->model->find($id)->delete();
    }

    public function model()
    {
        return FinancialCustody::class;
    }
}
