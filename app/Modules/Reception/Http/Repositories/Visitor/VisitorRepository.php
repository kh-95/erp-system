<?php

namespace App\Modules\Reception\Http\Repositories\Visitor;

use App\Foundation\Classes\Helper;
use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\Reception\Entities\Visitor;
use App\Modules\Reception\Entities\Visit;
use App\Modules\Reception\Http\Requests\Visitor\StoreRequest;
use App\Modules\Reception\Http\Requests\Visitor\UpdateRequest;
use App\Modules\Reception\Transformers\VisitResource;
use App\Modules\Reception\Transformers\VisitorResource;
use App\Repositories\CommonRepository;
use App\Modules\Reception\Http\Repositories\Visitor\VisitorRepositoryInterface;

class VisitorRepository extends CommonRepository implements VisitorRepositoryInterface
{
    use ApiResponseTrait;

    public function filterColumns()
    {
        return [
            'id',
            'name',
            'identity_number',
            'visit_id',
        ];
    }

    public function model()
    {
        return Visitor::class;
    }

    public function index($visit_id){
        $visitors = $this->setFilters()->where('visit_id',$visit_id)->defaultSort('-created_at')
        ->allowedSorts(['id','name','identity_number'])->paginate(Helper::PAGINATION_LIMIT);
        return $this->successResponse([
            'visitors' => VisitorResource::collection($visitors),
            'pagination' => [
                'total' => $visitors->total(),
                'count' => $visitors->count(),
                'per_page' => $visitors->perPage(),
                'current_page' => $visitors->currentPage(),
                'total_pages' => $visitors->lastPage()
            ],
        ]);
    }

    public function store($data, $visit_id)
    {
        $visit = Visit::find($visit_id);
        $visit->visitors()->create($data);
        $visit->load('visitors');
        return $this->successResponse(new VisitResource($visit), message : trans('reception::messages.messageDefault.add_successfuly_visitor'));
    }

    public function edit($data, $id)
    {
        $visitor = $this->update($data, $id);
        return $this->successResponse(new VisitorResource($visitor), message : trans('reception::messages.messageDefault.edit_successfuly_visitor'));
    }

    public function editVisitor($id)
    {
        $visitor = $this->find($id);
        return $this->successResponse(new VisitorResource($visitor));
    }

    public function destroy($id)
    {
        $this->delete($id);
        return $this->successResponse(['message' => __('reception::messages.messageDefault.deleted_successfuly_visitor')]);
    }

}
