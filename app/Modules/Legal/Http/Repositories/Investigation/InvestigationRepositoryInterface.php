<?php

namespace App\Modules\Legal\Http\Repositories\Investigation;

use App\Modules\Legal\Http\Requests\Investigation\StoreInvestigationRequest;
use App\Modules\Legal\Http\Requests\Investigation\UpdateInvestigationRequest;
use App\Repositories\CommonRepositoryInterface;

interface InvestigationRepositoryInterface extends CommonRepositoryInterface
{

    public function store(StoreInvestigationRequest $request);
    public function updateInvestigation(UpdateInvestigationRequest $request, $id);
    public function edit($id);
    public function show($id);

}
