<?php

namespace App\Modules\Reception\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Modules\Reception\Http\Requests\ReceptionReportRequest;
use App\Modules\Reception\Http\Repositories\ReceptionReport\ReceptionReportRepositoryInterface;
use App\Foundation\Traits\ApiResponseTrait;
use App\Foundation\Classes\Helper;
use App\Modules\Reception\Transformers\ReceptionReportResource;
use Illuminate\Http\JsonResponse;

class ReceptionReportController extends Controller
{
    protected ReceptionReportRepositoryInterface $receptionReportRepository;
    use ApiResponseTrait;

    /**
     * Create a new ReceptionReportController instance.
     *
     * @param ReceptionReportRepository $receptionReportRepository
     */
    public function __construct(ReceptionReportRepositoryInterface $receptionReportRepository)
    {
        $this->receptionReportRepository = $receptionReportRepository;
        $this->middleware('permission:list-reception-report')->only(['index', 'show']);
        $this->middleware('permission:create-reception-report')->only('store');
        $this->middleware('permission:edit-reception-report')->only(['update','updateStatus']);
        $this->middleware('permission:delete-reception-report')->only('destroy');
        $this->middleware('permission:archive-reception-report')->only('archive');
        $this->middleware('permission:archive-reception-report')->only('restore');

    }
    /**
     * Get all managements
     *
     * @return JsonResponse
     */

    public function index(Request $request): JsonResponse
    {
        $receptionReport = $this->receptionReportRepository->setFilters()->with('management')->paginate(Helper::getPaginationLimit($request));
        $data = ReceptionReportResource::collection($receptionReport);
        return $this->paginateResponse($data, $receptionReport);
    }
    /**
     * Create a ReceptionReport.
     *
     * @param ReceptionReportRequest $request
     * @return JsonResponse
     */

    public function store(ReceptionReportRequest $request): JsonResponse
    {
        $receptionReport = $this->receptionReportRepository->store($request->validated());
        return $this->successResponse(new ReceptionReportResource($receptionReport));
    }

    /**
     * Show the specified ReceptionReport.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $receptionReport = $this->receptionReportRepository->with('management')->find($id);
        return $this->successResponse(new ReceptionReportResource($receptionReport));
    }

    public function activities($id)
    {
        return $this->receptionReportRepository->recordActivities($id);
    }

    /**
     * Update the specified ReceptionReport.
     *
     * @param ReceptionReportRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(ReceptionReportRequest $request, $id): JsonResponse
    {
        $receptionReport = $this->receptionReportRepository->updateReceptionReport($request->validated(), $id);
        return $this->successResponse(new ReceptionReportResource($receptionReport));
    }
    /**
     * update status Reception Report
     *
     * @return JsonResponse
    */

    public function updateStatus($id, $status): JsonResponse
    {
        return $this->receptionReportRepository->updateStatus($id, $status);
    }
    /**
     * Remove the specified ReceptionReport.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        return $this->receptionReportRepository->destroy($id);
    }

    /**
     * Get all trashed reception Reports.
     *
     * @return JsonResponse
     */
    public function archive(Request $request): JsonResponse
    {
        $receptionReport = $this->receptionReportRepository->onlyTrashed()->paginate(Helper::getPaginationLimit($request));
        $data = ReceptionReportResource::collection($receptionReport);
        return $this->paginateResponse($data,$receptionReport);
    }
    /**
     * restore trashed Reception Report
     *
     * @return JsonResponse
     */
    public function restore($id): JsonResponse
    {
        return $this->receptionReportRepository->restore($id);
    }
}
