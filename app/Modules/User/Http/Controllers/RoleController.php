<?php

namespace App\Modules\User\Http\Controllers;

use App\Foundation\Classes\ApiResponse;
use App\Foundation\Classes\Helper;
use App\Foundation\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Modules\User\Http\Repositories\Roles\RoleRepositoryInterface;
use App\Modules\User\Http\Requests\RoleRequest;
use App\Modules\User\Transformers\RoleResource;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    use ApiResponseTrait;

    private RoleRepositoryInterface $roleRepository;

    public function __construct(RoleRepositoryInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;
        $this->middleware('permission:list-role')->only(['index', 'show']);
        $this->middleware('permission:create-role')->only('store');
        $this->middleware('permission:edit-role')->only('update');
        $this->middleware('permission:delete-role')->only('destroy');
    }

    public function index(Request $request)
    {
        $roles = $this->roleRepository->setFilters()->withCount('users')->paginate(Helper::getPaginationLimit($request));
        $data = RoleResource::collection($roles);
        return $this->paginateResponse($data,$roles);
    }

    public function store(RoleRequest $request)
    {
        try {
            $role = $this->roleRepository->create($request->all());
            $role->syncPermissions($request->permissions);
            return $this->successResponse(new RoleResource($role->loadCount('users')), 201);
        } catch (\Exception $exception) {
            return $this->errorResponse(null, 500, $exception->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $role = $this->roleRepository->find($id)->loadCount('users')->load(['permissions', 'activities']);
            return $this->successResponse(new RoleResource($role));
        } catch (\Exception $exception) {
            return $this->errorResponse(null, 500, $exception->getMessage());
        }
    }

    public function update(RoleRequest $request, $id)
    {
        try {
            $role = $this->roleRepository->update($request->validated(), $id)->loadCount('users')->load('permissions');
            if ($request->permissions) {
                $role->syncPermissions($request->permissions);
            }
            return ApiResponse::success(new RoleResource($role));
        } catch (\Exception $exception) {
            return $this->errorResponse(null, 500, $exception->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->roleRepository->delete($id);
            return $this->successResponse('deleted');
        } catch (\Exception $exception) {
            return $this->errorResponse(null, 500, $exception->getMessage());
        }
    }

    public function forExternalServices()
    {
        return $this->successResponse($this->roleRepository->forExternalServices(['id', 'name']));
    }

}

