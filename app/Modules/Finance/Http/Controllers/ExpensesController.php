<?php

namespace App\Modules\Finance\Http\Controllers;

use Illuminate\Http\Request;
use App\Foundation\Classes\Helper;
use Illuminate\Routing\Controller;
use App\Foundation\Traits\ApiResponseTrait;
use Illuminate\Contracts\Support\Renderable;
use App\Modules\Finance\Http\Requests\expenses\{ExpenseStoreRequest,ExpenseUpdateRequest};
use App\Modules\Finance\Http\Repositories\Expenses\ExpenseRepositoryInterface;


class ExpensesController extends Controller
{
    use ApiResponseTrait;
    private $repository;

    public function __construct(ExpenseRepositoryInterface $repository)
    {
        $this->repository = $repository;
        $this->middleware('permission:list-fi_expenses')->only(['index', 'show']);
        $this->middleware('permission:create-fi_expenses')->only(['store']);
        $this->middleware('permission:edit-fi_expenses')->only(['update']);
        $this->middleware('permission:removeAttachment-fi_expenses')->only(['removeAttachment']);
    }

    public function store(ExpenseStoreRequest $request)
    {
       return $this->repository->store($request->validated());
    }

    public function show($id)
    {
       return $this->repository->show($id);
    }

    public function edit($id)
    {

    }

    public function update(ExpenseUpdateRequest $request, $id)
    {
        return $this->repository->edit($request->validated(),$id);
    }

    public function removeAttachment($id){
        return $this->repository->removeAttachment($id);
    }

}
