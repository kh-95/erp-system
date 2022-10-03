<?php

namespace App\Modules\Legal\Http\Repositories\OrderModel;

use App\Foundation\Classes\Helper;
use App\Foundation\Traits\ApiResponseTrait;
use App\Repositories\CommonRepository;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;
use App\Modules\Legal\Transformers\ConsultResource;
use Illuminate\Support\Facades\DB;
use App\Modules\Legal\Entities\Consult;

class ConsultResponseRepository extends CommonRepository implements ConsultResponseRepositoryInterface
{
    use ApiResponseTrait;
    protected function filterColumns(): array
    {

    }
    public function sortColumns()
    {

    }

    public function model()
    {
        return Consult::class;
    }

    public function replay($data, $id)
    {
        $consult = $this->find($id);
        $consult->opinion()->create($data+['added_by_id' => auth()->id()]);
        $consult->status = 'replied';
        $consult->save();
        $consult->load('opinion');
        return $this->successResponse(data:ConsultResource::make($consult), message : "Responsed");
    }

}
