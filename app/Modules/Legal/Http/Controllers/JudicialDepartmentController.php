<?php

namespace App\Modules\Legal\Http\Controllers;

use App\Foundation\Classes\Helper;
use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\Legal\Entities\JudicialDepartment\JudicialDepartment;
use App\Modules\Legal\Http\Repositories\JudicialDepartment\JudicialDepartmentRepositoryInterface;
use App\Modules\Legal\Http\Requests\JudicialDepartmentRequest;
use App\Modules\Legal\Transformers\JudicialDepartmentResource;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class JudicialDepartmentController extends Controller
{
    use ApiResponseTrait;

    public function __construct(
        private JudicialDepartmentRepositoryInterface $judicialDepartmentRepository,
    ) {
        //    $this->middleware('permission:list-judicial-departments-cases')->only(['index']);
        //    $this->middleware('permission:create-judicial-departments')->only(['store']);
        //    $this->middleware('permission:edit-judicial-departments')->only(['update']);
        //    $this->middleware('permission:show-judicial-departments')->only(['show']);
    }

    public function index(Request $request)
    {

        $judicialDepartments = $this->judicialDepartmentRepository->setFilters()
            ->defaultSort('-created_at')
            ->allowedSorts($this->judicialDepartmentRepository->sortColumns())
            ->paginate(Helper::getPaginationLimit($request));
        $data = JudicialDepartmentResource::collection($judicialDepartments);

        return $this->paginateResponse($data, $judicialDepartments);
    }


    public function store(JudicialDepartmentRequest $request)
    {
        $judicialDepartment = $this->judicialDepartmentRepository->store($request);
        return $this->apiResource(JudicialDepartmentResource::make($judicialDepartment), message: trans('legal::messages.general.successfully_created'));
    }

    public function show($id)
    {
        $judicialDepartment = $this->judicialDepartmentRepository->show($id);
        return $this->successResponse(JudicialDepartmentResource::make($judicialDepartment));
    }


    public function update(JudicialDepartmentRequest $request, JudicialDepartment $judicialDepartment)
    {
        $judicialDepartment = $this->judicialDepartmentRepository->updateJudicialDepartment($request, $judicialDepartment);
        return $this->apiResource(JudicialDepartmentResource::make($judicialDepartment), message: trans('legal::messages.general.successfully_updated'));
    }

    public function destroy(JudicialDepartment $judicialDepartment)
    {
        $judicialDepartment = $this->judicialDepartmentRepository->deleteJudicialDepartment($judicialDepartment);
        return $this->successResponse(null, message: trans('legal::messages.general.successfully_deleted'));
    }
}
