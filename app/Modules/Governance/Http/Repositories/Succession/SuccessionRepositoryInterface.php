<?php

namespace App\Modules\Governance\Http\Repositories\Succession;

use App\Modules\Governance\Http\Requests\SuccessionRequest;
use App\Repositories\CommonRepositoryInterface;
use Illuminate\Http\Request;

interface SuccessionRepositoryInterface extends CommonRepositoryInterface
{
    public function show($id);

    public function store(SuccessionRequest $request);

    public function updateSuccession(SuccessionRequest $request,$id);
    public function destroy($id);

}
