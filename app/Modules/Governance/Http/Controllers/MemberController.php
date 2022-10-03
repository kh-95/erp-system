<?php

namespace App\Modules\Governance\Http\Controllers;

use App\Foundation\Classes\Helper;
use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\Governance\Transformers\MemberResource;
use App\Modules\Governance\Http\Repositories\Member\MemberRepositoryInterface;
use App\Modules\Governance\Http\Requests\Member\AssigneAsDirectorRequest;
use App\Modules\Governance\Http\Requests\Member\MemberRequest;
use App\Modules\HR\Entities\Employee;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class MemberController extends Controller
{
    use ApiResponseTrait;

    public function __construct(
        private MemberRepositoryInterface $memberRepository
    )
    {
        $this->middleware('permission:list-members')->only(['index']);
        $this->middleware('permission:create-members')->only(['store']);
        $this->middleware('permission:edit-members')->only(['update']);
        $this->middleware('permission:delete-members')->only(['destroy']);
        $this->middleware('permission:show-members')->only(['show']);
    }

    public function index()
    {
        $members = $this->memberRepository->with('holdharmlesses')
            ->setFilters()
            ->directorMemeber()
            ->defaultSort('-created_at')
            ->allowedSorts($this->memberRepository->sortColumns())
            ->paginate(Helper::PAGINATION_LIMIT);

        $data = MemberResource::collection($members);

        return $this->paginateResponse($data, $members);
    }

    public function show($id)
    {
        return $this->apiResource(MemberResource::make($this->memberRepository->show($id)));
    }

    public function update(MemberRequest $request, $id)
    {
        $employee = $this->memberRepository->updateMember($request, $id);

        return $this->apiResource(MemberResource::make($employee), message: trans('governance::messages.general.successfully_updated'));
    }

    public function isThereAnotherDirector()
    {
        if (Employee::where('is_directorship_president', true)->exists()) {
            return $this->successResponse(message: trans('governance::messages.general.there_was_one_president'));
        }

        return $this->errorResponse(message: trans('governance::messages.general.there_was_any_president'));
    }

    public function assignAsPresidentOfDirectorship(AssigneAsDirectorRequest $request, $id)
    {
        return $this->successResponse(
            MemberResource::make($this->memberRepository->assignAsDirector($request, $id)),
            message: trans('governance::messages.general.successfully_updated')
        );
    }

    public function getSingleMember($id)
    {
        return $this->memberRepository->getSingleMember($id);
    }

    public function getActiveDirectories()
    {
        $members = $this->memberRepository->getActiveDirectories();
        return $this->successResponse(MemberResource::collection($members));
    }

}
