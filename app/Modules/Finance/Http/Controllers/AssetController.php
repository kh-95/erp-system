<?php

namespace App\Modules\Finance\Http\Controllers;

use Illuminate\Http\Request;
use App\Foundation\Classes\Helper;
use Illuminate\Routing\Controller;
use App\Foundation\Traits\ImageTrait;
use App\Foundation\Traits\ApiResponseTrait;
use Illuminate\Contracts\Support\Renderable;
use App\Modules\Finance\Transformers\AssetResource;
use App\Modules\Finance\Http\Requests\AssetStoreRequest;
use App\Modules\Finance\Http\Requests\AssetUpdateRequest;
use App\Modules\Finance\Http\Repositories\AssetRepositoryInterface;

class AssetController extends Controller
{
    use ApiResponseTrait, ImageTrait;
    private $repository;

    public function __construct(AssetRepositoryInterface $repository)
    {
        $this->repository = $repository;
        $this->middleware('permission:list-asset')->only(['index', 'show']);
        $this->middleware('permission:create-asset')->only(['store']);
        $this->middleware('permission:edit-asset')->only(['update']);
        $this->middleware('permission:delete-asset')->only(['destroy']);
    }


    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $data =  $this->repository->setfilters()->paginate(Helper::getPaginationLimit($request));
        $assets = AssetResource::collection($data);
        return $this->paginateResponse($assets, $data);
    }

    public function show($id)
    {
        $asset = $this->repository->find($id)->load('activities');
        return $this->successResponse(new AssetResource($asset));
    }

    public function edit($id)
    {
        $asset = $this->repository->find($id);
        return $this->successResponse(new AssetResource($asset));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(AssetStoreRequest $request)
    {
        $data = $request->validated();
        unset($data['attachments']);
        $asset = $this->repository->store($data);

        if ($asset) {

            $fileNames = [];
            foreach ($request->attachments as $attachment) {
                array_push($fileNames, $this->storeImage($attachment, 'asset'));
            }

            $asset->attachments = implode('|', $fileNames);
            $asset->save();
        }

        return $this->successResponse(null, true, 'added success');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(AssetUpdateRequest $request, $id)
    { 
        $updated = $this->repository->update($request->validated(), $id);
        
        if (!$updated) {
            return $this->errorResponse(null, false, 'not updated!');
        }

        return $this->successResponse(null, true, 'updated success');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $this->repository->destroy($id);
        return $this->successResponse(null, true, 'deleted success');
    }
}
