<?php

namespace App\Modules\Governance\Http\Repositories\CandidacyApplication;

use App\Repositories\CommonRepositoryInterface;
use App\Modules\Governance\Http\Requests\CandidacyApplicationRequest;


interface CandidacyApplicationRepositoryInterface extends CommonRepositoryInterface
{

    public function store(CandidacyApplicationRequest $request);
    public function edit($id);
    public function show($id);
    public function updateCandidacyRequset(CandidacyApplicationRequest $request, $id);

    public function destroy($id);

    public function deleteAttachmentCandidacy($id);
}
