<?php

namespace App\Modules\HR\Http\Repositories\ServiceRequest;

use App\Modules\HR\Http\Requests\ServiceRrequest\ValidateServiceRequest;
use Prettus\Repository\Contracts\RepositoryCriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use App\Repositories\CommonRepositoryInterface;

interface ServiceResponseRepositoryInterface extends CommonRepositoryInterface
{
    public function replay($data, $id);
    public function removeAttachment($id);
}
