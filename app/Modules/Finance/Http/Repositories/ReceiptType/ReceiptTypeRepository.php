<?php

namespace App\Modules\Finance\Http\Repositories\ReceiptType;
use App\Foundation\Classes\Helper;
use App\Modules\Finance\Entities\ReceiptType;
use App\Repositories\CommonRepository;
use Spatie\QueryBuilder\QueryBuilder;
use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\Finance\Transformers\ReceiptTypeResource;
use App\Repositories\CommonRepositoryInterface;
use App\Modules\Finance\Http\Requests\ReceiptTypeRequest;
use App\Modules\Finance\Http\Requests\ReceiptTypeUpdateRequest;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;




class ReceiptTypeRepository extends CommonRepository implements ReceiptTypeRepositoryInterface
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
        return ReceiptType::class;
    }


    public function destroy($id)
    {
        $type = $this->find($id);
        $this->delete($id);
        return $this->successResponse(['message'=>__('finance::messages.receipttype.deleted_successfuly')]);
    }

    public function changeStatus($id)
    {
        $type = $this->find($id);
        $this->toggleStatus($id);
        return $this->successResponse(['message'=>__('finance::messages.receipttype.toggle_successfuly')]);
    }


    public function store(ReceiptTypeRequest $request)
    {
        $data = $request->all();
        $account = $this->create($data);
        return $this->successResponse(new ExpenseTypeResource($account),true,__('finance::messages.receipttype.create_successfuly'));
    }


    public function updateaccount($request,$id)
    {
       try {
        $account = $this->find($id);
        $data = $request;
        $account = $this->update($data, $id); 
        return $this->successResponse(new ReceiptTypeResource($account),true,__('finance::messages.receipttype.update_successfuly'));
        } catch (\Exception $exception) {
          return $this->errorResponse(null, 500 , $exception->getMessage());
        }
    }
   
}
