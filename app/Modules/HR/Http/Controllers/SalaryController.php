<?php

namespace App\Modules\HR\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Modules\HR\Http\Repositories\Salary\SalaryRepositoryInterface;
use App\Foundation\Traits\ApiResponseTrait;
use App\Foundation\Classes\Helper;
use App\Modules\HR\Entities\SalaryApprove;
use App\Modules\HR\Http\Requests\Salary\SalaryApproveRequest;
use App\Modules\HR\Http\Requests\Salary\SalaryRequest ;
use App\Modules\HR\Transformers\Salary\SalaryApproveResource;
use App\Modules\HR\Transformers\Salary\SalaryResource;
use Illuminate\Http\JsonResponse;

class SalaryController extends Controller
{
    protected SalaryRepositoryInterface $salaryRepository;
    use ApiResponseTrait;

    /**
     * Create a new salaryController instance.
     *
     * @param SalaryRepository $salaryRepository
     */
    public function __construct(SalaryRepositoryInterface $salaryRepository)
    {
        $this->salaryRepository = $salaryRepository;
        $this->middleware('permission:list-salary')->only(['index']);
        $this->middleware('permission:edit-salary')->only('update');
        $this->middleware('permission:show-salary')->only(['show']);
        $this->middleware('permission:change-salary-status')->only(['changeSalaryStatus']);
        $this->middleware('permission:get-salary-status')->only(['getSalaryStatus','getSalariesMonths']);

    }

    /**
     * Get all managements
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $salaries = $this->salaryRepository->setFilters()->paginate(Helper::getPaginationLimit($request));
        $data = SalaryResource::collection($salaries);
        return $this->paginateResponse($data,$salaries);
    }

    public function show($id)
    {
       return $this->salaryRepository->show($id);
    }

    public function update(SalaryRequest $request, $id): JsonResponse
    {
        return $this->salaryRepository->updatedeductPercentage($request, $id);
    }


    public function getSalariesMonths(){
        return response()->json([
            'data' => SalaryApprove::select('id', 'month')->latest('month')->get(),
            'status' => true,
            'message' => '',
        ]);
    }

    public function changeSalaryStatus(SalaryApproveRequest $request): JsonResponse
    {
        $salaryApprove = SalaryApprove::findOrFail( $request->id);
        $salaryApprove->update($request->validated());
        return $this->successResponse(new SalaryApproveResource($salaryApprove));
    }


    public function getSalaryStatus($id): JsonResponse
    {
        $salaryApprove = SalaryApprove::findOrFail($id);
        return $this->successResponse(new SalaryApproveResource($salaryApprove));
    }


}
