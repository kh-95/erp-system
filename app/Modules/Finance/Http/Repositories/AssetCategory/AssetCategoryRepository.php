<?php

namespace App\Modules\Finance\Http\Repositories\AssetCategory;
use App\Foundation\Classes\Helper;
use App\Modules\Finance\Entities\AssetCategory;
use App\Repositories\CommonRepository;
use Spatie\QueryBuilder\QueryBuilder;
use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\Finance\Transformers\AssetCategoryResource;
use App\Repositories\CommonRepositoryInterface;
use App\Modules\Finance\Http\Requests\AssetCategoryRequest;
use App\Modules\Finance\Http\Requests\AssetCategoryUpdateRequest;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;




class AssetCategoryRepository extends CommonRepository implements AssetCategoryRepositoryInterface
{
    
    use ApiResponseTrait;
    protected function filterColumns() :array
    {
        return [
            'id',
            'revise_no',
            'name',
            'destroy_check',
            $this->deactivatedAt('deactivated_at'),
            ];
    }

    public function model()
    {
        return AssetCategory::class;
    }


    public function destroy($id)
    {
        $type = $this->find($id);
        $this->delete($id);
        return $this->successResponse(['message'=>__('finance::messages.assetcategory.deleted_successfuly')]);
    }

    public function changeStatus($id)
    {
        $type = $this->find($id);
        $this->toggleStatus($id);
        return $this->successResponse(['message'=>__('finance::messages.assetcategory.toggle_successfuly')]);
    }


    public function store(AssetCategoryRequest $request)
    {
        $data = $request->all();
        $account = $this->create($data);
        return $this->successResponse(new AssetCategoryResource($account),true,__('finance::messages.assetcategory.create_successfuly'));
    }


    public function updateaccount($request,$id)
    {
       try {
        $account = $this->find($id);
        $data = $request;
        $account = $this->update($data, $id); 
        return $this->successResponse(new AssetCategoryResource($account),true,__('finance::messages.assetcategory.update_successfuly'));
        } catch (\Exception $exception) {
          return $this->errorResponse(null, 500 , $exception->getMessage());
        }
    }

    public function uniqueaccountNumber()
    {
        $account=$this->orderBy('id','desc')->first();
        $revise_no=$account->revise_no+1;
        return $this->successResponse($revise_no);
    }
   
}
