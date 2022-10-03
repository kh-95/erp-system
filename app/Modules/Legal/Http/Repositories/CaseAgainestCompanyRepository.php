<?php

namespace App\Modules\Legal\Http\Repositories;

use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\Legal\Entities\CaseAgainestCompany;
use App\Modules\Legal\Http\Requests\CaseAgainestCompanyRequest;
use App\Modules\Legal\Transformers\CaseAgainestCompany\CaseAgainestCompanyResource;
use App\Repositories\AttachesRepository;
use App\Repositories\CommonRepository;
use Spatie\QueryBuilder\AllowedFilter;

class CaseAgainestCompanyRepository extends CommonRepository implements CaseAgainestCompanyRepositoryInterface
{

    use ApiResponseTrait;

    protected function filterColumns(): array
    {
        return [
            'court_number',
            'area',
            'court_type',
            'status',
            AllowedFilter::scope('sessions.session_starts_from'),
            AllowedFilter::scope('sessions.session_ends_at'),
            'claimant.claimant_name',
            'claimant.identity_number',
            'employee.first_name',
            'employee.second_name',
            'employee.third_name',
            'employee.last_name',
        ];
    }

    public function sortColumns()
    {
        return [
            'court_number',
            'area',
            'court_type',
            'status',

        ];
    }

   public function model()
   {
      return CaseAgainestCompany::class;
   }
   public function store(CaseAgainestCompanyRequest $request)
   {

      $case_againest_company = $this->create($request->validated());
      $case_againest_company->claimant()->create($request->only('claimant_name','identity_number'));
      $case_againest_company->sessions()->createMany($request->sessions);
      if (array_key_exists('attachments', $request->validated())) {
        $attaches = new AttachesRepository('case_againest_company_attaches', $request, $case_againest_company);
        $case_againest_company = $attaches->addAttaches();

    }

     $case_againest_company->load(['attachments', 'claimant', 'employee']);
     return $this->apiResource(CaseAgainestCompanyResource::make($case_againest_company), true, __('Common::message.success_create'), code: 201);

   }

   public function edit($id)
   {
    $case_againest_company = $this->find($id);
    return $this->apiResource(CaseAgainestCompanyResource::make($case_againest_company),true);
   }

   public function show($id)
   {
    $case_againest_company = $this->find($id);
    return $this->apiResource(CaseAgainestCompanyResource::make($case_againest_company),true);
   }

   public function updateCaseAgainestCompany(CaseAgainestCompanyRequest $request, $id)
   {
    $case_againest_company = $this->find($id);
    $case_againest_company->update($request->validated());
    $case_againest_company->claimant()->update($request->only('claimant_name','identity_number'));
    $case_againest_company->sessions()->delete();
    $case_againest_company->sessions()->createMany($request->sessions);
    if (array_key_exists('attachments', $request->validated())) {

        $attaches = new AttachesRepository('case_againest_company_attaches', $request, $case_againest_company);
        $attaches->deleteAttachment($case_againest_company->attachments);
        $case_againest_company = $attaches->addAttaches();

        // $service_request->load(['attachments', 'management', 'employee']);
    }
    $case_againest_company->load(['attachments', 'claimant', 'employee']);
    return $this->apiResource(CaseAgainestCompanyResource::make($case_againest_company),true);
   }
}
