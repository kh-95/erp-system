<?php

namespace App\Modules\User\Http\Controllers;

use App\Foundation\Classes\ApiResponse;
use App\Foundation\Classes\Helper;
use App\Foundation\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Modules\User\Http\Repositories\Permissions\PermissionRepositoryInterface;
use App\Modules\User\Http\Requests\PermissionRequest;
use App\Modules\User\Transformers\PermissionResource;
use Illuminate\Http\Request;
use Nwidart\Modules\Module;

class PermissionController extends Controller
{
    use ApiResponseTrait;

    private PermissionRepositoryInterface $permissionRepository;

    public function __construct(PermissionRepositoryInterface $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
        $this->middleware('permission:list-permission')->only(['index', 'show']);
        $this->middleware('permission:create-permission')->only('store');
        $this->middleware('permission:edit-permission')->only('update');
        $this->middleware('permission:delete-permission')->only('destroy');
    }

    public function index(Request $request)
    {
        $permissions = $this->permissionRepository->setFilters()->paginate(Helper::getPaginationLimit($request));
        $data = PermissionResource::collection($permissions);
        return $this->paginateResponse($data,$permissions);
    }

    public function store(PermissionRequest $request)
    {
        try {
            $permission = $this->permissionRepository->create($request->validated());
            return $this->successResponse(new PermissionResource($permission), 201);
        } catch (\Exception $exception) {
            return $this->errorResponse(null, 500 , $exception->getMessage());
        }
    }

    public function update(PermissionRequest $request,$id)
    {
        try {
            $permission = $this->permissionRepository->update($request->all(), $id);
            return $this->successResponse(new PermissionResource($permission));
        } catch (\Exception $exception) {
            return $this->errorResponse(null, 500 , $exception->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->permissionRepository->delete($id);
            return $this->successResponse('deleted');
        } catch (\Exception $exception) {
            return $this->errorResponse(null, 500 , $exception->getMessage());
        }
    }

    public function forExternalServices()
    {
        return $this->successResponse($this->permissionRepository->forExternalServices(['id', 'name']));
    }
}


