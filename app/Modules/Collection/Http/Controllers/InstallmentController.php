<?php

namespace App\Modules\Collection\Http\Controllers;

use Illuminate\Http\Request;
use App\Foundation\Classes\Helper;
use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\Collection\Http\Repositories\InstallmentRepositoryInterface;
use App\Modules\Collection\Transformers\InstallmentResource;
use Illuminate\Routing\Controller;
use Illuminate\Contracts\Support\Renderable;


class InstallmentController extends Controller
{
    use ApiResponseTrait;

    private InstallmentRepositoryInterface $installmentrepository;

    public function __construct(InstallmentRepositoryInterface $installmentrepository)
    {
        $this->installmentrepository = $installmentrepository;
        $this->middleware('permission:list-installments')->only(['index']);
        $this->middleware('permission:show-installments')->only(['show']);
    }

    public function index(Request $request)
    {
        $model = $this->installmentrepository->setFilters()
            ->defaultSort('-created_at')
            ->allowedSorts($this->installmentrepository->sortColumns())
            ->paginate(Helper::PAGINATION_LIMIT);

        $data = InstallmentResource::collection($model);
        return $this->paginateResponse($data, $model);
    }


    public function show($id)
    {
        $installment = $this->installmentrepository->show($id);
        return $this->successResponse(InstallmentResource::make($installment));
    }


}
