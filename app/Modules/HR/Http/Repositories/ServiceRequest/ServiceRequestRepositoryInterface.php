<?php

namespace App\Modules\HR\Http\Repositories\ServiceRequest;

use App\Modules\HR\Http\Requests\ServiceRrequest\ValidateServiceRequest;
use Prettus\Repository\Contracts\RepositoryCriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use App\Repositories\CommonRepositoryInterface;

interface ServiceRequestRepositoryInterface extends CommonRepositoryInterface
{
    public function index();
    public function store($data);
    public function edit($data, $id);
    public function show($id);
    public function removeAttachment($id);
    public function editService($id);
}
