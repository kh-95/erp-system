<?php

namespace App\Modules\Governance\Http\Repositories\Committee;

use App\Modules\Governance\Http\Requests\CommitteeRequest;
use App\Repositories\CommonRepositoryInterface;
use Illuminate\Http\Request;

interface CommitteeRepositoryInterface extends CommonRepositoryInterface
{
    public function show($id);
    public function store(CommitteeRequest $request);
    public function updateCommittee(CommitteeRequest $request,$id);
    public function destroy($id);


}
