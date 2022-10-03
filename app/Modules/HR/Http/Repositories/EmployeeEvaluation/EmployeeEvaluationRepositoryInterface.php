<?php

namespace App\Modules\HR\Http\Repositories\EmployeeEvaluation;

use App\Modules\HR\Http\Requests\EvaluateEmployeeRequest;
use App\Modules\HR\Http\Requests\ServiceRrequest\ValidateServiceRequest;
use Prettus\Repository\Contracts\RepositoryCriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

interface EmployeeEvaluationRepositoryInterface extends RepositoryInterface, RepositoryCriteriaInterface
{
    public function store(EvaluateEmployeeRequest $request);
    public function updateEmployeeEvaluation(EvaluateEmployeeRequest $request, $id);
    public function show($id);
    public function edit($id);
    public function destroy($id);
}
