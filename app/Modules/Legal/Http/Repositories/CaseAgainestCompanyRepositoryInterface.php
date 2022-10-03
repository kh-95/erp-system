<?php

namespace App\Modules\Legal\Http\Repositories;

use App\Modules\Legal\Http\Requests\CaseAgainestCompanyRequest;
use App\Repositories\CommonRepositoryInterface;

interface CaseAgainestCompanyRepositoryInterface extends CommonRepositoryInterface
{
    public function store(CaseAgainestCompanyRequest $request);
    public function edit($id);
    public function show($id);
    public function updateCaseAgainestCompany(CaseAgainestCompanyRequest $request,$id);
}
