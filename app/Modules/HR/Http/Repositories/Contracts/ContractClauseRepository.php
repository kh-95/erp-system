<?php

namespace App\Modules\HR\Http\Repositories\Contracts;

use App\Modules\HR\Entities\ContractClause;
use Spatie\QueryBuilder\QueryBuilder;
use App\Repositories\CommonRepository;
use App\Repositories\CommonRepositoryInterface;
use App\Modules\HR\Http\Repositories\Contracts\ContractClauseRepositoryInterface;

class ContractClauseRepository extends CommonRepository implements ContractClauseRepositoryInterface
{
    protected function filterColumns() :array
    {
        return [
            'item_text',
            'nationality'
        ];
    }

    public function model()
    {
        return ContractClause::class;
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

}
