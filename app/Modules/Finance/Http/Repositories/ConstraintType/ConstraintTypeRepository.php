<?php

namespace App\Modules\Finance\Http\Repositories\ConstraintType;
use App\Foundation\Classes\Helper;
use App\Modules\Finance\Entities\ConstraintType;
use App\Repositories\CommonRepository;
use Spatie\QueryBuilder\QueryBuilder;
use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\Finance\Transformers\ConstraintTypeResource;
use App\Repositories\CommonRepositoryInterface;
use App\Modules\Finance\Http\Requests\ConstraintTypeRequest;
use App\Modules\Finance\Http\Requests\ConstraintTypeUpdateRequest;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;




class ConstraintTypeRepository extends CommonRepository implements ConstraintTypeRepositoryInterface
{
    
    use ApiResponseTrait;
    protected function filterColumns() :array
    {
        return [
            'id',
            $this->translated('name'),
            $this->translated('notes'),
            $this->deactivatedAt('deactivated_at'),
            ];
    }

    public function model()
    {
        return ConstraintType::class;
    }


    public function destroy($id)
    {
        $type = $this->find($id);
        $this->delete($id);
        return $this->successResponse(['message'=>__('finance::messages.constrainttype.deleted_successfuly')]);
    }

    public function changeStatus($id)
    {
        $type = $this->find($id);
        $this->toggleStatus($id);
        return $this->successResponse(['message'=>__('finance::messages.constrainttype.toggle_successfuly')]);
    }


    public function store(ConstraintTypeRequest $request)
    {
        $data = $request->all();
        $account = $this->create($data);
        return $this->successResponse(new ConstraintTypeResource($account),true,__('finance::messages.constrainttype.create_successfuly'));
    }


    public function updateaccount($request,$id)
    {
       try {
        $account = $this->find($id);
        $data = $request;
        $account = $this->update($data, $id); 
        return $this->successResponse(new ConstraintTypeResource($account),true,__('finance::messages.constrainttype.update_successfuly'));
        } catch (\Exception $exception) {
          return $this->errorResponse(null, 500 , $exception->getMessage());
        }
    }
   
}
