<?php

namespace App\Modules\Legal\Http\Repositories\Consult;

use App\Repositories\CommonRepositoryInterface;
use App\Modules\Legal\Http\Requests\ConsultRequest;


interface ConsultRepositoryInterface extends CommonRepositoryInterface
{

    public function store(ConsultRequest $request);
    public function edit($id);
    public function show($id);
    public function updateConsultRequset(ConsultRequest $request, $id);
}
