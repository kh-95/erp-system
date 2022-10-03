<?php

namespace App\Modules\HR\Http\Repositories\Employee;

use App\Modules\HR\Entities\BlackList;
use App\Modules\HR\Http\Requests\Employee\BlackListRequest;
use App\Repositories\CommonRepositoryInterface;

interface BlackListRepositoryInterface extends CommonRepositoryInterface
{
    public function store(BlackListRequest $request);
    public function edit($id);
    public function show($id);
    public function updateBlackList(BlackListRequest $request,$id);
}
