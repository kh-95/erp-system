<?php

namespace App\Modules\Finance\Http\Controllers;

use App\Foundation\Classes\Helper;
use App\Modules\Finance\Http\Requests\AssetCategoryRequest;
use App\Modules\Finance\Http\Requests\AssetCategoryUpdateRequest;
use App\Modules\Finance\Http\Repositories\AssetCategory\AssetCategoryRepositoryInterface;
use App\Modules\Finance\Transformers\AssetCategoryResource;
use App\Modules\Finance\Entities\AssetCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Foundation\Traits\ApiResponseTrait;
use Illuminate\Http\Request;


class AssetCategoryController extends Controller
{
    use ApiResponseTrait;
    /**
     * @var AssetCategoryRepository
     */
    private AssetCategoryRepositoryInterface  $assetcategoryRepository;
    /**
     * Create a new AssetCategoryController instance.
     *
     * @param AssetCategoryRepository $assetcategoryRepository
     */
    public function __construct(AssetCategoryRepositoryInterface $assetcategoryRepository)
    {
        $this->assetcategoryRepository = $assetcategoryRepository;
        $this->middleware('permission:list-assetcategory')->only(['index', 'show']);
        $this->middleware('permission:create-assetcategory')->only(['store']);
        $this->middleware('permission:edit-assetcategory')->only(['update','togglestatus','edit']);
        $this->middleware('permission:delete-assetcategory')->only(['destroy']);

    }

    /**
     * Get all assetcategory
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $assetcategory = $this->assetcategoryRepository->setfilters()->paginate(Helper::getPaginationLimit($request));
        $data = AssetCategoryResource::collection($assetcategory);
        return $this->paginateResponse($data,$assetcategory);
    }

    /**
     * Create a assetcategory.
     *
     * @param AssetCategoryRequest $request
     * @return JsonResponse
     */
    public function store(AssetCategoryRequest $request): JsonResponse
    {
        return $this->assetcategoryRepository->store($request);
    }

    /**
     * Show the specified assetcategory.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        
        $assetcategory = $this->assetcategoryRepository->find($id)->load('activities');
        return $this->successResponse(new AssetCategoryResource($assetcategory));
    }
    /**
     * Show the specified account.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function edit($id): JsonResponse
    {
        $account = $this->assetcategoryRepository->find($id);
        return $this->successResponse(new AssetCategoryResource($account));
    }

    /**
     * Update the specified account.
     *
     * @param ResignationRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(AssetCategoryUpdateRequest $request, $id): JsonResponse
    {
        return $this->assetcategoryRepository->updateaccount($request->validated(), $id);
    }

    /**
     * Remove the specified account.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        return $this->assetcategoryRepository->destroy($id);
    }

    /**
     * togglestatus the specified account.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function togglestatus($id): JsonResponse
    {
        return $this->assetcategoryRepository->changeStatus($id);
    }

    public function uniqueaccountNumber()
    {
        return $this->assetcategoryRepository->uniqueaccountNumber();
    }

}
