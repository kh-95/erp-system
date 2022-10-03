<?php

namespace App\Modules\Finance\Http\Controllers;

use Illuminate\Http\Request;
use App\Foundation\Classes\Helper;
use Illuminate\Routing\Controller;
use App\Foundation\Traits\ApiResponseTrait;
use Illuminate\Contracts\Support\Renderable;
use App\Modules\Finance\Http\Requests\{CashRegisterStoreRequest,CashRegisterUpdateRequest};
use App\Modules\Finance\Http\Repositories\CachRegisterRepositoryInterface;

class CashRegisterController extends Controller
{
    use ApiResponseTrait;
    private $repository;

    public function __construct(CachRegisterRepositoryInterface $repository)
    {
        $this->repository = $repository;
        $this->middleware('permission:list-fi_cashRegister')->only(['index', 'show']);
        $this->middleware('permission:create-fi_cashRegister')->only(['store']);
        $this->middleware('permission:edit-fi_cashRegister')->only(['update']);
        $this->middleware('permission:removeAttachment-fi_cashRegister')->only(['removeAttachment']);
    }

    public function index(){
        return $this->repository->index();
    }

    public function store(CashRegisterStoreRequest $request)
    {
       return $this->repository->store($request->validated());
    }

    public function show($id)
    {
        return $this->repository->show($id);
    }

    public function edit($id)
    {
        return view('finance::edit');
    }

    public function update(CashRegisterUpdateRequest $request, $id)
    {
       return $this->repository->edit($request->validated(), $id);
    }

    public function removeAttachment($id){
        return $this->repository->removeAttachment($id);
    }
}
