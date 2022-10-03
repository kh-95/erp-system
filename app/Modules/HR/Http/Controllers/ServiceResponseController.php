<?php

namespace App\Modules\HR\Http\Controllers;

use App\Modules\HR\Http\Repositories\ServiceRequest\ServiceResponseRepositoryInterface;
use App\Modules\HR\Http\Requests\ServiceRrequest\StoreResponseRequest;
use App\Modules\HR\Transformers\ServiceRequestResource;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ServiceResponseController extends Controller
{

    private $repository;

    public function __construct(ServiceResponseRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function store(StoreResponseRequest $request, $id)
    {
       return $this->repository->replay($request->validated(), $id);
    }

    public function removeAttachment($id)
    {
       return $this->repository->removeAttachment($id);
    }

    public function activities($id)
    {
        return $this->repository->recordActivities($id);
    }


}
