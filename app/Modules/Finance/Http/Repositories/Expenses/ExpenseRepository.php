<?php

namespace App\Modules\Finance\Http\Repositories\Expenses;

use App\Foundation\Classes\Helper;
use App\Repositories\CommonRepository;
use App\Modules\Finance\Http\Repositories\Expenses\ExpenseRepositoryInterface;
use App\Modules\Finance\Transformers\ExpensesResource;
use App\Foundation\Traits\ImageTrait;
use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\Finance\Entities\{Expenses,ExpenseAttachment};
use Illuminate\Support\Facades\DB;

class ExpenseRepository extends CommonRepository implements ExpenseRepositoryInterface
{
    use ApiResponseTrait, ImageTrait;

    protected function filterColumns(): array
    {
        return [
            'id',
            'pay_status',
            'customer_type',
            'date',
            'certificate_number',
            'money',
            'from_cash_register',
            'to_cash_register',
            'management_id'
        ];
    }

    public function model()
    {
        return Expenses::class;
    }

    public function index(){
        $Expenses = $this->setFilters()->with(['attachments', 'activities', 'expensesCustomer','expensesCustomerService','expensesCustomerAccount'])->paginate(Helper::PAGINATION_LIMIT);
        return $this->paginateResponse(ExpensesResource::collection($Expenses),$Expenses);
    }

    public function store($data)
    {
        return DB::transaction(function() use($data){
            $Readydata = collect($data)->except('attachments','expensesCustomer','expensesCustomerService','expensesCustomerAccount')->toArray();
            $Expense = $this->create($Readydata);
            $this->storeRelations($data,$Expense);
            $load_relation = array();
            isset($data['expensesCustomer']) ? $load_relation[] = 'expensesCustomer': '';
            isset($data['expensesCustomerService']) ? $load_relation[] = 'expensesCustomerService': '';
            isset($data['expensesCustomerAccount']) ? $load_relation[] = 'expensesCustomerAccount': '';
            $load_relation[] = 'attachments';
            $load_relation[] = 'activities';
            $Expense->load($load_relation);

            return $this->successResponse(data: ExpensesResource::make($Expense), message : trans('finance::messages.cashnotification.added_successfuly_record'));
        });
    }

    private function storeRelations($data, $Expense)
    {
        $load_relation = array();
        if(isset($data['attachments'])){
            $attachments = collect($data['attachments'])->map(function ($item) {
                $data['file'] = $this->storeImage($item, 'expenses/attachments');
                return $data;
            })->values()->toArray();

            $Expense->attachments()->createMany($attachments);
        }
        isset($data['expensesCustomer']) ?
        $Expense->expensesCustomer()->create($data['expensesCustomer'])
        :'';
        isset($data['expensesCustomerService'])?
        $Expense->expensesCustomerService()->create($data['expensesCustomerService'])
        :'';
        isset($data['expensesCustomerAccount'])?
        $Expense->expensesCustomerAccount()->create($data['expensesCustomerAccount'])
        :'';

    }

    private function updateRelations($data, $Expense)
    {
        $load_relation = array();
        if(isset($data['attachments'])){
            $attachments = collect($data['attachments'])->map(function ($item) {
                $data['file'] = $this->storeImage($item, 'expenses/attachments');
                return $data;
            })->values()->toArray();

            $Expense->attachments()->createMany($attachments);
        }
        isset($data['expensesCustomer']) ?
        $Expense->expensesCustomer()->update($data['expensesCustomer'])
        :'';
        isset($data['expensesCustomerService'])?
        $Expense->expensesCustomerService()->update($data['expensesCustomerService'])
        :'';
        isset($data['expensesCustomerAccount'])?
        $Expense->expensesCustomerAccount()->update($data['expensesCustomerAccount'])
        :'';
    }

    public function edit($data, $id)
    {
        return DB::transaction(function() use($data, $id){
            $Readydata = collect($data)->except('attachments','expensesCustomer','expensesCustomerService','expensesCustomerAccount')->toArray();
            $Expense = $this->update($Readydata, $id);
            $this->updateRelations($data,$Expense);
            $load_relation = array();
            isset($data['expensesCustomer']) ? $load_relation[] = 'expensesCustomer': '';
            isset($data['expensesCustomerService']) ? $load_relation[] = 'expensesCustomerService': '';
            isset($data['expensesCustomerAccount']) ? $load_relation[] = 'expensesCustomerAccount': '';
            $load_relation[] = 'attachments';
            $load_relation[] = 'activities';
            $Expense->load($load_relation);

            return $this->successResponse(data: ExpensesResource::make($Expense), message : trans('finance::messages.cashnotification.edit_successfuly_record'));
        });
    }

    public function show($id)
    {
        try{
            $Expense = $this->find($id);
            $Expense->load(['attachments' ,'activities', 'expensesCustomer','expensesCustomerService','expensesCustomerAccount']);
            return $this->successResponse(data: ExpensesResource::make($Expense));
        }catch(\Exception $exception){
            return $this->errorResponse(null, $exception->getMassege());
        }

    }

    public function removeAttachment($id)
    {
        try{
            $attachment = ExpenseAttachment::find($id);
            $this->deleteImage($attachment->file, 'expenses/attachments');
            $attachment->delete();
            return $this->successResponse( message : trans('finance::messages.receipt.remove_attachment_successfuly'));
        }catch(\Exception $exception){
            return $this->errorResponse(null, message: $exception->getMessage());
        }

    }


}
