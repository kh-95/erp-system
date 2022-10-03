<?php

namespace App\Modules\Reception\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Foundation\Classes\Helper;
use App\Modules\Reception\Http\Requests\Visitor\StoreRequest;
use App\Modules\Reception\Http\Requests\Visitor\UpdateRequest;
use App\Modules\Reception\Http\Repositories\Visitor\VisitorRepositoryInterface;
use App\Modules\Reception\Transformers\VisitResource;
use App\Foundation\Traits\ApiResponseTrait;

class VisitorController extends Controller
{
    use ApiResponseTrait;

    private VisitorRepositoryInterface $visitorRepository;

    public function __construct(VisitorRepositoryInterface $visitorRepository)
    {
        $this->visitorRepository = $visitorRepository;
        $this->middleware('permission:create-visit')->only(['store']);
        $this->middleware('permission:delete-visit')->only(['destroy']);
    }

    public function index($visit_id)
    {
       return $this->visitorRepository->index($visit_id);
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreRequest $request
     * @param int $visit_id
     */
    public function store(StoreRequest $request, $id)
    {
        return $this->visitorRepository->store($request->validated(),$id);
    }

    /**
     * Show the specified resource.
     * @param int $id
     */
    public function edit($id)
    {
        return $this->visitorRepository->editVisitor($id);
    }

    /**
     * Update specified resource in storage.
     * @param UpdateRequest $request
     * @param int $visit_id
     */
    public function update(UpdateRequest $request, $id)
    {
        return $this->visitorRepository->edit($request->validated(),$id);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     */
    public function destroy($id)
    {
        return $this->visitorRepository->destroy($id);
    }

    public function activities($id)
    {
        return $this->visitorRepository->recordActivities($id);
    }
}
