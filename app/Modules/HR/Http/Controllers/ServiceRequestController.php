<?php

namespace App\Modules\HR\Http\Controllers;


use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\HR\Http\Repositories\ServiceRequest\ServiceRequestRepositoryInterface;
use App\Modules\HR\Http\Requests\ServiceRrequest\ValidateServiceRequest;
use App\Modules\HR\Transformers\ServiceRequestResource;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ServiceRequestController extends Controller
{
    use ApiResponseTrait;
    private $service_request_repository;

    public function __construct(ServiceRequestRepositoryInterface $service_request_repository)
    {
        $this->service_request_repository = $service_request_repository;
        $this->middleware('permission:list-hr_service_request')->only(['index']);
        $this->middleware('permission:create-hr_service_request')->only(['store']);
        $this->middleware('permission:edit-hr_service_request')->only(['update']);
        $this->middleware('permission:show-hr_service_request')->only(['show']);
    }

    public function index(Request $request)
    {
        $this->service_request_repository->index();
    }

    public function store(ValidateServiceRequest $request)
    {
        return $this->service_request_repository->store($request->validated());
    }

    public function show($id)
    {
        return $this->service_request_repository->show($id);
    }

    public function edit($id)
    {
        return $this->service_request_repository->editService($id);
    }

    public function update(ValidateServiceRequest $request, $id)
    {
        return $this->service_request_repository->edit($request->validated(), $id);
    }

    public function removeAttachment($id){
        return $this->repository->removeAttachment($id);
    }

    public function activities($id)
    {
        return $this->repository->recordActivities($id);
    }
}
