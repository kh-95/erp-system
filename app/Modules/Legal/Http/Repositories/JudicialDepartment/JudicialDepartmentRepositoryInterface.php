<?php

namespace App\Modules\Legal\Http\Repositories\JudicialDepartment;

use App\Repositories\CommonRepositoryInterface;
use App\Modules\Legal\Http\Requests\JudicialDepartmentRequest;
use App\Modules\Legal\Entities\JudicialDepartment\JudicialDepartment;

interface JudicialDepartmentRepositoryInterface extends CommonRepositoryInterface
{
    public function show($id);

    public function store(JudicialDepartmentRequest $request);

    public function updateJudicialDepartment(JudicialDepartmentRequest $request, JudicialDepartment $judicialDepartment);
    public function deleteJudicialDepartment(JudicialDepartment $judicialDepartment);
}