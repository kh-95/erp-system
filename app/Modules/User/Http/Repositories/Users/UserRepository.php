<?php

namespace App\Modules\User\Http\Repositories\Users;

use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\User\Entities\User;
use App\Modules\User\Http\Requests\UserRequest;
use App\Modules\User\Transformers\UserResource;
use App\Repositories\CommonRepository;
use App\Foundation\Traits\ImageTrait;
use Illuminate\Support\Facades\DB;

class UserRepository extends CommonRepository implements UserRepositoryInterface
{
    use ImageTrait, ApiResponseTrait;
    public function filterColumns()
    {
        return [
            'id',
            'employee.jobInformation.employee_number',
            'employee.job.management_id',
            'image',
            'deactivated_at',
        ];
    }

    public function model()
    {
        return User::class;
    }

    public function edit($data, $id)
    {
        return DB::transaction(function() use($data,$id){
            $dataReady = collect($data)->except(['status', 'permissions', 'roles', 'image'])->toArray();
            if (isset($data['status'])) {
                switch ($data['status']) {
                    case "disable":
                        $dataReady['deactivated_from'] = null;
                        $dataReady['deactivated_at'] = now();
                        break;
                    case "disable_for_a_while":
                        $dataReady['deactivated_from'] = $request->get('disable_from');
                        $dataReady['deactivated_at'] = $request->get('disable_to');
                        break;
                    default: // enable
                        $dataReady['deactivated_from'] = null;
                        $dataReady['deactivated_at'] = null;
                }
            }

            if(isset($data['image'])){
                $user = $this->find($id);
                if($user->image != null){
                    $dataReady['image'] = $this->updateImage($data['image'], $user->image, 'users');
                }else{
                    $dataReady['image'] = $this->storeImage($data['image'], 'users');
                }
            }

            $user = $this->update($dataReady, $id);
            isset($data['permissions']) ? $user->syncPermissions($data['permissions']) : '';
            isset($data['roles']) ? $user->syncRoles($data['roles']) : '';
            return $this->successResponse(new UserResource($user));
        });

    }

    public function store($data)
    {
        return DB::transaction(function() use($data){
            $dataReady = collect($data)->except('image')->toArray();
            $dataReady['image'] = $this->storeImage($data['image'], 'users');
            $user = $this->create($dataReady);
            isset($data['permissions']) ? $user->syncPermissions($data['permissions']) : '';
            isset($data['roles']) ? $user->syncRoles($data['roles']) : '';
            return $this->successResponse(new UserResource($user), 201);
        });
    }

    public function removeImage($id){
      $user = $this->find($id);
      $this->deleteImage($user->image,'users');
      $user->image = null;
      $user->save();
      return $this->successResponse(['message' => __('user::messages.user_image.deleted_successfuly')]);
    }

    public function editImage($data, $id){

        $user = $this->find($id);
        if($user->image != null){
            $user->image = $this->updateImage($data['image'], $user->image, 'users');
        }else{
            $user->image = $this->storeImage($data['image'], 'users');
        }
        $user->save();
        return $this->successResponse(['message' => __('user::messages.user_image.updated_successfuly')]);
    }

}
