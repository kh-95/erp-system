<?php

namespace App\Modules\HR\Http\Repositories\Resignation;

use App\Modules\HR\Http\Requests\ResignationRequest;
use App\Modules\HR\Http\Requests\ResignationupdateRequest;
use Prettus\Repository\Contracts\RepositoryCriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use App\Repositories\CommonRepositoryInterface;

interface ResignationRepositoryInterface extends CommonRepositoryInterface
{
    public function destroy($id);
    public function changeStatus($id);
    public function updateresignation(ResignationRequest $request,$id);

}
