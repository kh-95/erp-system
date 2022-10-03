<?php

namespace App\Modules\Governance\Http\Repositories\Regulation;


use App\Modules\Governance\Http\Requests\RegulationRequest;
use App\Repositories\CommonRepositoryInterface;

interface RegulationRepositoryInterface extends CommonRepositoryInterface
{

    public function store(RegulationRequest $request);

    public function updateRegulation(RegulationRequest $request, $id);

    public function edit($id);

    public function show($id);

    public function destroy($id);

    public function deleteAttachmentRegulation($id);

}
