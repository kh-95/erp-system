<?php

namespace App\Modules\HR\Http\Controllers;

use App\Foundation\Classes\Helper;
use App\Modules\HR\Http\Requests\ResignationRequest;
use App\Modules\HR\Http\Requests\ResignationupdateRequest;
use App\Modules\HR\Http\Repositories\Resignation\ResignationRepositoryInterface;
use App\Modules\HR\Transformers\ResignationResource;
use App\Modules\HR\Entities\Resignation;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Foundation\Traits\ApiResponseTrait;
use App\Foundation\Traits\ImageTrait;
use Illuminate\Http\Request;


class ResignationController extends Controller
{
    use ApiResponseTrait;
    /**
     * @var ResignationRepository
     */
    private ResignationRepositoryInterface  $resignationRepository;
    /**
     * Create a new ResignationController instance.
     *
     * @param ResignationRepository $resignationRepository
     */
    public function __construct(ResignationRepositoryInterface $resignationRepository)
    {
        $this->resignationRepository = $resignationRepository;
        $this->middleware('permission:list-resignation')->only(['index', 'show']);
        $this->middleware('permission:create-resignation')->only(['store']);
        $this->middleware('permission:edit-resignation')->only(['update', 'togglestatus', 'edit']);
        $this->middleware('permission:delete-resignation')->only(['destroy']);
    }

    /**
     * Get all resignation
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $resignations = $this->resignationRepository->setFilters()
            ->defaultSort('-created_at')
            ->allowedSorts($this->resignationRepository->sortColumns())
            ->paginate(Helper::getPaginationLimit($request));

        $data = ResignationResource::collection($resignations);
        return $this->paginateResponse($data, $resignations);
    }

    /**
     * Create a resignation.
     *
     * @param resignationRequest $request
     * @return JsonResponse
     */

    public function store(ResignationRequest $request)
    {
        $data =  $this->resignationRepository->store($request);
        return $this->apiResource(data: ResignationResource::make($data), message: __('Common::message.success_create'));
    }

    /**
     * Show the specified resignation.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $resignation = $this->resignationRepository->find($id)->load('activities');
        return $this->successResponse(new ResignationResource($resignation));
    }
    /**
     * Show the specified resignation.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function edit($id): JsonResponse
    {
        $resignation = $this->resignationRepository->find($id);
        return $this->successResponse(new ResignationResource($resignation));
    }

    /**
     * Update the specified resignation.
     *
     * @param ResignationRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(ResignationRequest $request, $id): JsonResponse
    {
        return $this->resignationRepository->updateresignation($request, $id);
    }

    /**
     * Remove the specified resignation.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        return $this->resignationRepository->destroy($id);
    }

    /**
     * togglestatus the specified resignation.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function togglestatus($id): JsonResponse
    {
        return $this->resignationRepository->changeStatus($id);
    }
}
