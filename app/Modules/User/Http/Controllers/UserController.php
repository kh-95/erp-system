<?php

namespace App\Modules\User\Http\Controllers;

use App\Foundation\Classes\Helper;
use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\User\Http\Repositories\Users\UserRepositoryInterface;
use App\Modules\User\Http\Requests\UserRequest;
use App\Modules\User\Http\Requests\userImageRequest;
use App\Modules\User\Transformers\UserResource;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class UserController extends Controller
{
    use ApiResponseTrait;

    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->middleware('permission:list-user')->only(['index', 'show']);
        $this->middleware('permission:create-user')->only('store');
        $this->middleware('permission:edit-user')->only('update');
        $this->middleware('permission:delete-user')->only('destroy');
    }

    public function index(Request $request)
    {
        $users = $this->userRepository->setFilters()->paginate(Helper::getPaginationLimit($request));
        return $this->paginateResponse(UserResource::collection($users),$users);
    }

    public function store(UserRequest $request)
    {
        return $this->userRepository->store($request->validated());
    }

    public function show($id)
    {
        $permission = $this->userRepository->find($id)->load(['permissions', 'roles']);
        return $this->successResponse(new UserResource($permission));
    }

    public function update(UserRequest $request, $id)
    {
        return $this->userRepository->edit($request->validated(), $id);
    }

    public function destroy($id)
    {
        try {
            $this->userRepository->delete($id);
            return $this->successResponse('deleted');
        } catch (\Exception $exception) {
            return $this->errorResponse(null, 500 , $exception->getMessage());
        }
    }

    public function destroyImage($id){
        return $this->userRepository->removeImage($id);
    }

    public function updateImage(userImageRequest $request, $id){
        return $this->userRepository->editImage($request->validated(), $id);
    }
}
