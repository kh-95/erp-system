<?php

namespace App\Modules\HR\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Modules\HR\Http\Requests\JobRequest;
use App\Modules\HR\Http\Repositories\Job\JobRepositoryInterface;
use App\Foundation\Traits\ApiResponseTrait;
use App\Foundation\Classes\Helper;
use App\Modules\HR\Transformers\JobResource;
use Illuminate\Http\JsonResponse;

class JobController extends Controller
{
    protected JobRepositoryInterface $jobRepository;
    use ApiResponseTrait;

    /**
     * Create a new jobController instance.
     *
     * @param JobRepository $JobRepository
     */
    public function __construct(JobRepositoryInterface $jobRepository)
    {
        $this->jobRepository = $jobRepository;
        $this->middleware('permission:list-hr_job')->only(['index', 'show']);
        $this->middleware('permission:create-hr_job')->only('store');
        $this->middleware('permission:edit-hr_job')->only('update');
        $this->middleware('permission:delete-hr_job')->only('destroy');
        $this->middleware('permission:archive-hr_job')->only('archive');
    }

    /**
     * Get all managements
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $jobs = $this->jobRepository->setFilters()->with('management')->withCount('employees')->latest('id')->paginate(Helper::getPaginationLimit($request));
        $data = JobResource::collection($jobs);
        return $this->paginateResponse($data,$jobs);
    }

    /**
     * Create a Job.
     *
     * @param JobRequest $request
     * @return JsonResponse
     */
    public function store(JobRequest $request): JsonResponse
    {
        try {
            $job = $this->jobRepository->create($request->validated());
            return $this->successResponse(new jobResource($job),true, __('hr::messages.job.add_successfuly'));
        } catch (\Exception $exception) {
            return $this->errorResponse(null, 500, $exception->getMessage());
        }
    }

    /**
     * Show the specified Job.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $job = $this->jobRepository->with('management')->withCount('employees')->find($id)->load('activities');
        return $this->successResponse(new jobResource($job));
    }

     /**
     * Show the specified Job.
     *
     * @param string  $name , int $management_id
     * @return JsonResponse
     */
    public function checkJobName(string $name , int $management_id): JsonResponse
    {
        return $this->jobRepository->checkJobName($name ,$management_id );
    }
     /**
     * Edit the specified Job.
     *
     * @param int $id
     * @return JsonResponse
     */

    public function edit($id): JsonResponse
    {
        $job = $this->jobRepository->with('management')->withCount('employees')->find($id);
        return $this->successResponse(new jobResource($job));
    }
    /**
     * Update the specified Job.
     *
     * @param JobRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(JobRequest $request, $id): JsonResponse
    {
            return $this->jobRepository->update($request->validated(), $id);
    }

    public function activities($id)
    {
        return $this->jobRepository->recordActivities($id);
    }

    /**
     * Remove the specified job.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        return $this->jobRepository->destroy($id);
    }

    /**
     * togglestatus the specified job.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function deactivated($id): JsonResponse
    {
        return $this->jobRepository->deactivated_at($id);
    }
    /**
     * Get all job for droplist
     *
     * @return JsonResponse
     */
    public function forExternalServices(): JsonResponse
    {
        return $this->successResponse($this->jobRepository->forExternalServices(['id', 'management_id']));
    }

    /**
     * Get all trashed jobs.
     *
     * @return JsonResponse
     */
    public function archive(Request $request): JsonResponse
    {
        $jobs = $this->jobRepository->onlyTrashed()->paginate(Helper::getPaginationLimit($request));
        $data['jobs'] = jobResource::collection($jobs)->response()->getData(true);
        return $this->successResponse($data);
    }

    /**
     * restore trashed job
     *
     * @return JsonResponse
     */
    public function restore($id): JsonResponse
    {
        return $this->jobRepository->restore($id);
    }
}
