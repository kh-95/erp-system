<?php

namespace App\Modules\Legal\Http\Controllers;

use App\Foundation\Classes\Helper;
use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\Legal\Http\Repositories\CaseAgainestCompanyRepositoryInterface;
use App\Modules\Legal\Http\Requests\CaseAgainestCompanyRequest;
use App\Modules\Legal\Transformers\CaseAgainestCompany\CaseAgainestCompanyResource;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CaseAgainestCompanyController extends Controller
{
    use ApiResponseTrait;
    public function __construct(private CaseAgainestCompanyRepositoryInterface $case_againest_company)
    {
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $cases_againest_company = $this->case_againest_company->setFilters()->allowedIncludes(['attachments', 'claimant', 'employee'])
            ->defaultSort('-created_at')
            ->allowedSorts($this->case_againest_company->sortColumns())
            ->paginate(Helper::getPaginationLimit($request));
        $data = CaseAgainestCompanyResource::collection($cases_againest_company);
        return $this->paginateResponse($data, $cases_againest_company);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(CaseAgainestCompanyRequest $request)
    {
        return $this->case_againest_company->store($request);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return $this->case_againest_company->show($id);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return $this->case_againest_company->edit($id);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(CaseAgainestCompanyRequest $request, $id)
    {
        return $this->case_againest_company->updateCaseAgainestCompany($request, $id);
    }
}
