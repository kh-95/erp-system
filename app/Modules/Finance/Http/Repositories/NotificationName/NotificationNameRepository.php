<?php

namespace App\Modules\Finance\Http\Repositories\NotificationName;
use App\Foundation\Classes\Helper;
use App\Modules\Finance\Entities\NotificationName;
use App\Repositories\CommonRepository;
use Spatie\QueryBuilder\QueryBuilder;
use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\Finance\Transformers\NotificationNameResource;
use App\Repositories\CommonRepositoryInterface;
use App\Modules\Finance\Http\Requests\NotificationNameRequest;
use App\Modules\Finance\Http\Requests\NotificationNameUpdateRequest;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;




class NotificationNameRepository extends CommonRepository implements NotificationNameRepositoryInterface
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
        return NotificationName::class;
    }


    public function destroy($id)
    {
        $type = $this->find($id);
        $this->delete($id);
        return $this->successResponse(['message'=>__('finance::messages.notificationname.deleted_successfuly')]);
    }

    public function changeStatus($id)
    {
        $type = $this->find($id);
        $this->toggleStatus($id);
        return $this->successResponse(['message'=>__('finance::messages.notificationname.toggle_successfuly')]);
    }


    public function store(NotificationNameRequest $request)
    {
        $data = $request->all();
        $account = $this->create($data);
        return $this->successResponse(new NotificationNameResource($account),true,__('finance::messages.notificationname.create_successfuly'));
    }


    public function updateaccount($request,$id)
    {
       try {
        $account = $this->find($id);
        $data = $request;
        $account = $this->update($data, $id); 
        return $this->successResponse(new NotificationNameResource($account),true,__('finance::messages.notificationname.update_successfuly'));
        } catch (\Exception $exception) {
          return $this->errorResponse(null, 500 , $exception->getMessage());
        }
    }
   
}
