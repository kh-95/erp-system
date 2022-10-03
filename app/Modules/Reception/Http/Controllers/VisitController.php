<?php

namespace App\Modules\Reception\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Foundation\Classes\Helper;
use App\Modules\Reception\Http\Requests\Visit\StoreRequest;
use App\Modules\Reception\Http\Requests\Visit\UpdateRequest;
use App\Modules\Reception\Http\Requests\Visit\UpdateStatusRequest;
use App\Modules\Reception\Http\Repositories\Visit\VisitRepositoryInterface;
use App\Modules\Reception\Transformers\VisitResource;
use App\Foundation\Traits\ApiResponseTrait;


class VisitController extends Controller
{
    use ApiResponseTrait;

    private VisitRepositoryInterface $visitRepository;

    public function __construct(VisitRepositoryInterface $visitRepository)
    {
        $this->visitRepository = $visitRepository;
        $this->middleware('permission:list-visit')->only(['index', 'show']);
        $this->middleware('permission:create-visit')->only(['store']);
        $this->middleware('permission:edit-visit')->only(['update','updateStatus']);
        $this->middleware('permission:delete-visit')->only(['destroy']);
    }

    public function index(Request $request)
    {
       return $this->visitRepository->index($request);
    }

    public function store(StoreRequest $request)
    {
       return $this->visitRepository->store($request->validated());
    }

    /**
     * Show the specified resource.
     * @param int $id
     */
    public function show($id)
    {
        return $this->visitRepository->show($id);
    }

     /**
     * Show the specified resource.
     * @param int $id
     */
    public function edit($id)
    {
        return $this->visitRepository->editVisit($id);
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateRequest $request
     * @param int $id
     */
    public function update(UpdateRequest $request, $id)
    {
        return $this->visitRepository->edit($request->validated(),$id);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     */
    public function destroy($id)
    {
      return $this->visitRepository->destroy($id);
    }

    public function restore($id)
    {
      return $this->visitRepository->restore($id);
    }

    public function updateStatus(UpdateStatusRequest $request,$id){
      return $this->visitRepository->editٍStatus($request->validated(),$id);
    }

    public function activities($id)
    {
        return $this->visitRepository->recordActivities($id);
    }
}
