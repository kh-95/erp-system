<?php

namespace App\Modules\HR\Http\Controllers;

use App\Foundation\Classes\Helper;
use App\Modules\HR\Http\Requests\NationalityRequest;
use App\Modules\HR\Http\Repositories\Nationality\NationalityRepositoryInterface;
use App\Modules\HR\Transformers\NationalityResource;
use App\Modules\HR\Entities\Nationality;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Foundation\Traits\ApiResponseTrait;
use Illuminate\Http\Request;


class NationalityController extends Controller
{
    use ApiResponseTrait;
    /**
     * @var NationalityRepository
     */
    private NationalityRepositoryInterface  $nationalityRepository;
    /**
     * Create a new NationalityController instance.
     *
     * @param NationalityRepository $nationalityRepository
     */
    public function __construct(NationalityRepositoryInterface $nationalityRepository)
    {
        $this->nationalityRepository = $nationalityRepository;
        $this->middleware('permission:list-nationality')->only(['index', 'show','forExternalServices']);
        $this->middleware('permission:create-nationality')->only(['store']);
        $this->middleware('permission:edit-nationality')->only(['update','togglestatus']);
        $this->middleware('permission:delete-nationality')->only(['destroy']);
        $this->middleware('permission:archive-nationality')->only(['onlyTrashed','restore']);

    }

    /**
     * Get all nationalities
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $nationalities = $this->nationalityRepository->setfilters()->paginate(Helper::getPaginationLimit($request));
        $data = NationalityResource::collection($nationalities);
        return $this->paginateResponse($data,$nationalities);
    }

    /**
     * Create a nationality.
     *
     * @param nationalityRequest $request
     * @return JsonResponse
     */
    public function store(NationalityRequest $request): JsonResponse
    {
        try {
            $nationality = $this->nationalityRepository->create($request->validated());
            return $this->successResponse(new NationalityResource($nationality));
        } catch (\Exception $exception) {
            return $this->errorResponse(null, 500 , $exception->getMessage());
        }
    }

    /**
     * Show the specified natinality.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $nationality = $this->nationalityRepository->find($id);
        return $this->successResponse(new NationalityResource($nationality));
    }

    /**
     * Update the specified nationality.
     *
     * @param NationalityRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(NationalityRequest $request, $id): JsonResponse
    {
        try {
        $this->nationalityRepository->update($request->validated(), $id);
        $nationality = $this->nationalityRepository->find($id);
        return $this->successResponse(new NationalityResource($nationality));
        } catch (\Exception $exception) {
            return $this->errorResponse(null, 500 , $exception->getMessage());
        }

    }

    /**
     * Remove the specified nationality.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        return $this->nationalityRepository->destroy($id);
    }

    /**
     * Get all nationalities for droplist non permission
     *
     * @return JsonResponse
     */
    public function forExternalServices()
    {
        return $this->successResponse($this->nationalityRepository->forExternalServices(['id', 'name']));
    }

    /**
     * togglestatus the specified nationality.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function togglestatus($id): JsonResponse
    {
        return $this->nationalityRepository->changeStatus($id);
    }

    /**
     * Get all trashed nationalities
     *
     * @return JsonResponse
     */
    public function onlyTrashed()
    {
        return $this->successResponse($this->nationalityRepository->onlyTrashed()->get());
    }

     /**
     * restore trashed nationality
     *
     * @return JsonResponse
     */
    public function restore($id)
    {
        return $this->nationalityRepository->restore($id);
    }
}
