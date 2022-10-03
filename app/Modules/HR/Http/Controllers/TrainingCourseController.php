<?php

namespace App\Modules\HR\Http\Controllers;

use Illuminate\Http\Request;
use App\Foundation\Classes\Helper;
use Illuminate\Routing\Controller;
use App\Foundation\Traits\ImageTrait;
use App\Foundation\Classes\ApiResponse;
use App\Foundation\Traits\ApiResponseTrait;
use Illuminate\Contracts\Support\Renderable;
use App\Modules\HR\Http\Requests\TrainingCourse\TrainingCourseStoreRequest;
use App\Modules\HR\Http\Repositories\TrainingCourse\TrainingCourseReporitoryInterface;
use App\Modules\HR\Http\Requests\TrainingCourse\TrainingCourseUpdateRequest;
use App\Modules\HR\Transformers\TrainingCourse\TrainingCourseCollection;
use App\Modules\HR\Transformers\TrainingCourse\TrainingCourseResource;

class TrainingCourseController extends Controller
{
    use ApiResponseTrait, ImageTrait;
    private $repository;

    public function __construct(TrainingCourseReporitoryInterface $repository)
    {
        $this->repository = $repository;
        $this->middleware('permission:list-training_course')->only(['index', 'show']);
        $this->middleware('permission:create-training_course')->only(['store']);
        $this->middleware('permission:edit-training_course')->only(['update']);
        $this->middleware('permission:delete-training_course')->only(['destroy']);
    }


    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
      return $this->repository->index();
    }

    public function show($id)
    {
        $training_course = $this->repository->find($id);
        return $this->successResponse(new TrainingCourseResource($training_course));
    }

    public function edit($id)
    {
        $training_course = $this->repository->find($id);
        return $this->successResponse(new TrainingCourseResource($training_course));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(TrainingCourseStoreRequest $request)
    {
        return $this->repository->store($request->validated());
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(TrainingCourseUpdateRequest $request, $id)
    {
       return $this->repository->update($request->validated(), $id);
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

    public function activities($id)
    {
        return $this->repository->recordActivities($id);
    }
}
