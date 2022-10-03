<?php

namespace App\Modules\Finance\Http\Repositories\ExpenseType;
use App\Foundation\Classes\Helper;
use App\Modules\Finance\Entities\ExpenseType;
use App\Repositories\CommonRepository;
use Spatie\QueryBuilder\QueryBuilder;
use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\Finance\Transformers\ExpenseTypeResource;
use App\Repositories\CommonRepositoryInterface;
use App\Modules\Finance\Http\Requests\ExpenseTypeRequest;
use App\Modules\Finance\Http\Requests\ExpenseTypeUpdateRequest;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;




class ExpenseTypeRepository extends CommonRepository implements ExpenseTypeRepositoryInterface
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
        return ExpenseType::class;
    }


    public function destroy($id)
    {
        $type = $this->find($id);
        $this->delete($id);
        return $this->successResponse(['message'=>__('finance::messages.expensetype.deleted_successfuly')]);
    }

    public function changeStatus($id)
    {
        $type = $this->find($id);
        $this->toggleStatus($id);
        return $this->successResponse(['message'=>__('finance::messages.expensetype.toggle_successfuly')]);
    }


    public function store(ExpenseTypeRequest $request)
    {
        $data = $request->all();
        $account = $this->create($data);
        return $this->successResponse(new ExpenseTypeResource($account),true,__('finance::messages.expensetype.create_successfuly'));
    }


    public function updateaccount($request,$id)
    {
       try {
        $account = $this->find($id);
        $data = $request;
        $account = $this->update($data, $id); 
        return $this->successResponse(new ExpenseTypeResource($account),true,__('finance::messages.expensetype.update_successfuly'));
        } catch (\Exception $exception) {
          return $this->errorResponse(null, 500 , $exception->getMessage());
        }
    }
   
}
