<?php

namespace App\Modules\Finance\Http\Repositories;

use App\Repositories\CommonRepositoryInterface;

interface CachRegisterRepositoryInterface extends CommonRepositoryInterface
{
    public function index();
    public function store($data);
    public function edit($data, $id);
    public function show($id);
    public function removeAttachment($id);
}
