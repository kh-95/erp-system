<?php

namespace App\Modules\Finance\Http\Repositories\AccountingTree;
use App\Foundation\Classes\Helper;
use App\Modules\Finance\Entities\AccountingTree;
use App\Repositories\CommonRepository;
use Spatie\QueryBuilder\QueryBuilder;
use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\Finance\Transformers\AccountingTreeResource;
use App\Repositories\CommonRepositoryInterface;
use App\Modules\Finance\Http\Requests\AccountingTreeRequest;
use App\Modules\Finance\Http\Requests\AccountingTreeUpdateRequest;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;




class AccountingTreeRepository extends CommonRepository implements AccountingTreeRepositoryInterface
{
    
    use ApiResponseTrait;
    protected function filterColumns() :array
    {
        return [
            'id',
            'revise_no',
            'account_name',
            'account_type',
            'account_code',
            'collect_check',
            'payment_check',
            $this->deactivatedAt('deactivated_at'),
            ];
    }

    public function model()
    {
        return AccountingTree::class;
    }


    public function destroy($id)
    {
        $type = $this->find($id);
        $this->delete($id);
        return $this->successResponse(['message'=>__('finance::messages.accountingtree.deleted_successfuly')]);
    }

    public function changeStatus($id)
    {
        $type = $this->find($id);
        $this->toggleStatus($id);
        return $this->successResponse(['message'=>__('finance::messages.accountingtree.toggle_successfuly')]);
    }


    public function store(AccountingTreeRequest $request)
    {
        $data = $request->all();
        $account = $this->create($data);
        return $this->successResponse(new AccountingTreeResource($account),true,__('finance::messages.accountingtree.create_successfuly'));
    }


    public function updateaccount($request,$id)
    {
       try {
        $account = $this->find($id);
        $data = $request;
        $account = $this->update($data, $id); 
        return $this->successResponse(new AccountingTreeResource($account),true,__('finance::messages.accountingtree.update_successfuly'));
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

    public function parentaccounts($id)
    {
        $account=$this->find($id);
        
        if($account->parent_id!='0')
        {
            $parentaccount=$this->find($account->parent_id);
            $parentaccounts=$this->Where('parent_id','0')
                                 ->where('id','!=',$parentaccount->id)->get();
        }else{
            $parentaccount='';
            $parentaccounts=$this->Where('parent_id','0')
                                 ->where('id','!=',$id)->get();
        }

        return $this->successResponse($this->scopeActive($parentaccounts));
    }

    public function childsaccounts($id)
    {
        $childaccounts=$this->Where('parent_id',$id)->get();
        return $this->successResponse($this->scopeActive($childaccounts));
    }

    public function updateparentaccount($id)
    {
        $data = ['parent_id'=>'0'];
        $account = $this->update($data, $id); 
        $account=$this->find($id);
        return $this->successResponse(new AccountingTreeResource($account),true,__('finance::messages.accountingtree.update_successfuly'));

    }

    public function updatechildaccount($request,$id)
    {
        $data = ['parent_id'=>$request['child_id'],'account_code'=>$request['account_code']];
        $account = $this->update($data, $id); 
        $account=$this->find($id);
        return $this->successResponse(new AccountingTreeResource($account),true,__('finance::messages.accountingtree.update_successfuly'));

    }
   
}
