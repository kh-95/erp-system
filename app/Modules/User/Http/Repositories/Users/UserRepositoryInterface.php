<?php

namespace App\Modules\User\Http\Repositories\Users;

use App\Modules\User\Http\Requests\UserRequest;
use App\Repositories\CommonRepositoryInterface;

interface UserRepositoryInterface extends CommonRepositoryInterface
{
    public function store($data);
    public function edit($data, $id);
    public function removeImage($id);
    public function editImage($data, $id);
}
