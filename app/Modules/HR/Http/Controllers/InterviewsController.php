<?php

namespace App\Modules\HR\Http\Controllers;

use App\Foundation\Classes\Helper;
use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\HR\Entities\Interviews\Interview;
use App\Modules\HR\Entities\Interviews\InterviewApplication;
use App\Modules\HR\Http\Repositories\Interview\InterviewRepositoryInterface;
use App\Modules\HR\Http\Requests\InterviewRequest;
use App\Modules\HR\Transformers\Interview\InterviewResource;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class InterviewsController extends Controller
{
    use ApiResponseTrait;

    private InterviewRepositoryInterface $interviewRepository;

    public function __construct(interviewRepositoryInterface $interviewRepository)
    {
        $this->interviewRepository = $interviewRepository;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $Item = $this->interviewRepository->setFilters()->allowedIncludes('addedBy')
            ->defaultSort('-created_at')
            ->allowedSorts($this->interviewRepository->sortColumns())
         //   ->with(['addedBy', 'job', 'committeeMembers', 'applications'])->withCount('applications')
            ->with(['applications'])->withCount('applications')
            ->paginate(Helper::getPaginationLimit($request));

        $data = InterviewResource::collection($Item);
        return $this->paginateResponse($data, $Item);
    }

    public function indexInteviewApplication()
    {
        return $this->interviewRepository->indexInteviewApplication();
    }

    /**
     * Store a newly created resource in storage.
     * @param InterviewRequest $request
     * @return Renderable
     */
    public function store(InterviewRequest $request)
    {
        $data = $this->interviewRepository->store($request);
        return $this->apiResource(data: InterviewResource::make($data), message: __('Common::message.success_create'));

    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $data = $this->interviewRepository->show($id);
        return $this->apiResource(InterviewResource::make($data));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $data = $this->interviewRepository->edit($id);
        return $this->apiResource(data: InterviewResource::make($data));
    }

    /**
     * Update the specified resource in storage.
     * @param InterviewRequest $request
     * @param int $id
     * @return Renderable
     */
    public function update(InterviewRequest $request, $id)
    {
        $data = $this->interviewRepository->updateInterview($request, $id);
        return $this->apiResource(data: InterviewResource::make($data), message: __('Common::message.success_update'));
    }

    public function destroy($id)
    {
        $this->interviewRepository->destroy($id);
        return $this->apiResource(message: __('Common.message.success_delete'));
    }
}
