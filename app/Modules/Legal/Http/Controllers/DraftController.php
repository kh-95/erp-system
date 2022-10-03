<?php

namespace App\Modules\Legal\Http\Controllers;

use App\Foundation\Classes\Helper;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\Legal\Http\Repositories\Draft\DraftRepositoryInterface;
use App\Modules\Legal\Http\Requests\DraftRequest;
use App\Modules\Legal\Transformers\Request\DraftResource;




class DraftController extends Controller
{
    use ApiResponseTrait;
    public function __construct(private DraftRepositoryInterface $draftRepository)
    {
        // $this->middleware('permission:list-draft')->only(['index', 'show']);
        // $this->middleware('permission:create-draft')->only('store');
        // $this->middleware('permission:edit-draft')->only('update');
        // $this->middleware('permission:delete-draft')->only('destroy');
    }



    public function index(Request $request)
    {
        $draftrequests = $this->draftRepository->setFilters()
            ->defaultSort('-created_at')
            ->allowedSorts($this->draftRepository->sortColumns())
            ->paginate(Helper::getPaginationLimit($request));
        $data = DraftResource::collection($draftrequests);
        return $this->paginateResponse($data, $draftrequests);
    }

    public function store(DraftRequest $request)
    {
        return $this->draftRepository->store($request);
    }

    public function show($id)
    {
        return $this->draftRepository->show($id);
    }

    public function edit($id)
    {
        return $this->draftRepository->edit($id);
    }
    public function update(DraftRequest $request, $draftRequest)
    {
        return $this->draftRepository->updateDraftRequset($request, $draftRequest);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
