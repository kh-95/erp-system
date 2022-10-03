<?php

namespace App\Modules\Finance\Http\Controllers;

use App\Foundation\Classes\Helper;
use App\Modules\Finance\Http\Requests\AccountingTreeRequest;
use App\Modules\Finance\Http\Requests\AccountingTreeUpdateRequest;
use App\Modules\Finance\Http\Requests\AccountingTreechildRequest;
use App\Modules\Finance\Http\Repositories\AccountingTree\AccountingTreeRepositoryInterface;
use App\Modules\Finance\Transformers\AccountingTreeResource;
use App\Modules\Finance\Entities\AccountingTree;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Foundation\Traits\ApiResponseTrait;
use Illuminate\Http\Request;


class AccountingTreeController extends Controller
{
    use ApiResponseTrait;
    /**
     * @var AccountingTreeRepository
     */
    private AccountingTreeRepositoryInterface  $accountingtreeRepository;
    /**
     * Create a new AccountingTreeController instance.
     *
     * @param AccountingTreeRepository $accountingtreeRepository
     */
    public function __construct(AccountingTreeRepositoryInterface $accountingtreeRepository)
    {
        $this->accountingtreeRepository = $accountingtreeRepository;
        $this->middleware('permission:list-accountingtree')->only(['index', 'show','forExternalServices']);
        $this->middleware('permission:create-accountingtree')->only(['store']);
        $this->middleware('permission:edit-accountingtree')->only(['update','togglestatus','edit']);
        $this->middleware('permission:delete-accountingtree')->only(['destroy']);
        $this->middleware('permission:moveaccount-accountingtree')->only(['updateparentaccount','updatechildaccount']);


    }

    /**
     * Get all AccountingTree
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $account = $this->accountingtreeRepository->setfilters()->paginate(Helper::getPaginationLimit($request));
        $data = AccountingTreeResource::collection($account);
        return $this->paginateResponse($data,$account);
    }

    /**
     * Create a AccountingTree.
     *
     * @param AccountingTreeRequest $request
     * @return JsonResponse
     */
    public function store(AccountingTreeRequest $request): JsonResponse
    {
        return $this->accountingtreeRepository->store($request);
    }

    /**
     * Show the specified accountingtree.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $account = $this->accountingtreeRepository->find($id)->load('activities');
        return $this->successResponse(new AccountingTreeResource($account));
    }
    /**
     * Show the specified account.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function edit($id): JsonResponse
    {
        $account = $this->accountingtreeRepository->find($id);
        return $this->successResponse(new AccountingTreeResource($account));
    }

    /**
     * Update the specified account.
     *
     * @param ResignationRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(AccountingTreeUpdateRequest $request, $id): JsonResponse
    {
        return $this->accountingtreeRepository->updateaccount($request->validated(), $id);
    }

    /**
     * Remove the specified account.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        return $this->accountingtreeRepository->destroy($id);
    }

    /**
     * togglestatus the specified account.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function togglestatus($id): JsonResponse
    {
        return $this->accountingtreeRepository->changeStatus($id);
    }

    public function uniqueaccountNumber()
    {
        return $this->accountingtreeRepository->uniqueaccountNumber();
    }

    public function parentaccounts($id): JsonResponse
    {
        return $this->accountingtreeRepository->parentaccounts($id);
    }

    public function childsaccounts($id): JsonResponse
    {
        return $this->accountingtreeRepository->childsaccounts($id);
    }

    public function updateparentaccount($id): JsonResponse
    {
        return $this->accountingtreeRepository->updateparentaccount($id);
    }
    public function updatechildaccount(AccountingTreechildRequest $request,$id): JsonResponse
    {
        return $this->accountingtreeRepository->updatechildaccount($request->validated(),$id);
    }

    public function forExternalServices()
    {
        return $this->successResponse($this->accountingtreeRepository->get());
    }
}
