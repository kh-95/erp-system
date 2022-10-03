<?php

namespace App\Modules\HR\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\ManagementExport;
use Illuminate\Http\JsonResponse;
use App\Foundation\Classes\Helper;
use Illuminate\Routing\Controller;
use Maatwebsite\Excel\Facades\Excel;
use  Maatwebsite\Excel\Concerns\Exportable;
use App\Foundation\Traits\ImageTrait;
use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\HR\Http\Requests\ManagementRequest;
use App\Modules\HR\Transformers\ManagementResource;
use App\Modules\HR\Http\Repositories\Management\ManagementRepositoryInterface;

class ManagementController extends Controller
{
    use ApiResponseTrait;
    use ImageTrait;
    /**
     * @var ManagementRepository
     */
    protected ManagementRepositoryInterface $managementRepository;
    /**
     * Create a new ManagementController instance.
     *
     * @param ManagementRepository $managementRepository
     */
    public function __construct(ManagementRepositoryInterface $managementRepository)
    {
        $this->managementRepository = $managementRepository;
        $this->middleware('permission:list-management')->only(['index', 'show']);
        $this->middleware('permission:create-management')->only('store');
        $this->middleware('permission:edit-management')->only('update');
        $this->middleware('permission:delete-management')->only('destroy');
        $this->middleware('permission:archive-management')->only('archive');
    }

    /**
     * Get all managements
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $managements = $this->managementRepository->setFilters()->with('parent')->latest('id')->paginate(Helper::getPaginationLimit($request));
        $data = ManagementResource::collection($managements);
        return $this->paginateResponse($data, $managements);
    }

    /**
     * Create a management.
     *
     * @param ManagementRequest $request
     * @return JsonResponse
     */
    public function store(ManagementRequest $request): JsonResponse
    {
        $management = $this->managementRepository->create($request->validated());
        return $this->successResponse(new ManagementResource($management), true, __('hr::messages.management.add_successfuly'));
    }

    /**
     * Show the specified management.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $management = $this->managementRepository->with(['parent'])->find($id);
        return $this->successResponse(new ManagementResource($management));
    }

    /**
     * Activities of a management.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function activities($id)
    {
        return $this->managementRepository->recordActivities($id);
    }

    /**
     * Show the specified management.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function checkManagementName(string $name): JsonResponse
    {
        return $this->managementRepository->checkManagementName($name);
    }
    /**
     * list of parent management.
     *
     * @return JsonResponse
     */
    public function listParents(): JsonResponse
    {
        $managements = $this->managementRepository->where('parent_id', null)->get('id', 'name');
        return $this->successResponse(ManagementResource::collection($managements));
    }
    /**
     * Edit the specified management.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function edit($id): JsonResponse
    {
        $management = $this->managementRepository->with('parent')->find($id);
        return $this->successResponse(new ManagementResource($management));
    }
    /**
     * Update the specified management.
     *
     * @param ManagementRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(ManagementRequest $request, $id): JsonResponse
    {
        return $this->managementRepository->update($request->validated(), $id);
    }

    /**
     * Remove the specified management.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        return $this->managementRepository->destroy($id);
    }

    /**
     * togglestatus the specified management.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function deactivated($id): JsonResponse
    {
        return $this->managementRepository->deactivated_at($id);
    }

    /**
     * Get all managements for droplist
     *
     * @return JsonResponse
     */
    public function forExternalServices(): JsonResponse
    {
        $managements = $this->managementRepository->forExternalServices(['id']);
        return $this->successResponse(ManagementResource::collection($managements));
    }

    /**
     * Get all trashed managements.
     *
     * @return JsonResponse
     */
    public function archive(Request $request): JsonResponse
    {
        $managements = $this->managementRepository->onlyTrashed()->paginate(Helper::getPaginationLimit($request));
        $data = ManagementResource::collection($managements);
        return $this->paginateResponse($data, $managements);
    }

    /**
     * restore trashed management
     *
     * @return JsonResponse
     */
    public function restore($id)
    {
        return $this->managementRepository->restore($id);
    }

    public function export()
    {
        return Excel::download(new ManagementExport, 'managements.xlsx');
    }
}
