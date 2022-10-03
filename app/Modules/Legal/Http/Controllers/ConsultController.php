<?php

namespace App\Modules\Legal\Http\Controllers;

use App\Foundation\Classes\Helper;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\Legal\Http\Repositories\Consult\ConsultRepositoryInterface;
use App\Modules\Legal\Http\Requests\ConsultRequest;
use App\Modules\Legal\Transformers\Request\ConsultResource;
use App\Modules\Legal\Http\Repositories\OrderModel\ConsultResponseRepositoryInterface;

class ConsultController extends Controller
{
    use ApiResponseTrait;

    private $repository ;
    public function __construct(private ConsultResponseRepositoryInterface $consultRepository)
    {
        $this->repository = $consultRepository;
        // $this->middleware('permission:list-consult')->only(['index', 'show']);
        // $this->middleware('permission:create-consult')->only('store');
        // $this->middleware('permission:edit-consult')->only('update');
        // $this->middleware('permission:delete-consult')->only('destroy');
    }



    public function index(Request $request)
    {
        $consultrequests = $this->consultRepository->setFilters()
            ->defaultSort('-created_at')
            ->allowedSorts($this->consultRepository->sortColumns())
            ->paginate(Helper::getPaginationLimit($request));
        $data = ConsultResource::collection($consultrequests);
        return $this->paginateResponse($data, $consultrequests);
    }

    public function store(ConsultRequest $request)
    {
        return $this->consultRepository->store($request);
    }

    public function show($id)
    {
        return $this->consultRepository->show($id);
    }

    public function edit($id)
    {
        return $this->consultRepository->edit($id);
    }
    public function update(ConsultRequest $request, $consultRequest)
    {
        return $this->consultRepository->updateConsultRequset($request, $consultRequest);
    }

    public function responseConsult (ConsultRequest $request , $id){
       return $this->repository->replay($request->validated(), $id);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    // public function destroy($id)
    // {
    //     //
    // }
}
