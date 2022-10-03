<?php

namespace App\Modules\Finance\Http\Controllers;

use Illuminate\Http\Request;
use App\Foundation\Classes\Helper;
use Illuminate\Routing\Controller;
use App\Foundation\Traits\ApiResponseTrait;
use Illuminate\Contracts\Support\Renderable;
use App\Modules\Finance\Http\Requests\Receipt\{ReceiptStoreRequest,ReceiptUpdateRequest};
use App\Modules\Finance\Http\Repositories\Receipts\RecieptRepositoryInterface;

class ReceiptController extends Controller
{
    use ApiResponseTrait;
    private $repository;

    public function __construct(RecieptRepositoryInterface $repository)
    {
        $this->repository = $repository;
        $this->middleware('permission:list-fi_receipt')->only(['index', 'show']);
        $this->middleware('permission:create-fi_receipt')->only(['store']);
        $this->middleware('permission:edit-fi_receipt')->only(['update']);
        $this->middleware('permission:removeAttachment-fi_receipt')->only(['removeAttachment']);
    }

    public function index()
    {
        return $this->repository->index();
    }

    public function store(ReceiptStoreRequest $request)
    {
       return $this->repository->store($request->validated());
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return $this->repository->show($id);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {

    }

    public function update(ReceiptUpdateRequest $request, $id)
    {
        return $this->repository->store($request->validated(), $id);
    }

    public function removeAttachment($id){
        return $this->repository->removeAttachment($id);
    }

}
