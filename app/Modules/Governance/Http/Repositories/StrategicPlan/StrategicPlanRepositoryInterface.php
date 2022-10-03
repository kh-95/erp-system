<?php

namespace App\Modules\Governance\Http\Repositories\StrategicPlan;

use App\Modules\Governance\Entities\StrategicPlan\StrategicPlan;
use App\Modules\Governance\Http\Requests\StrategicPlanRequest;
use App\Repositories\CommonRepositoryInterface;

interface StrategicPlanRepositoryInterface extends CommonRepositoryInterface
{
    public function store(StrategicPlanRequest $request);
    public function updateStrategicPlan(StrategicPlanRequest $request, StrategicPlan $strategicPlan);
    public function destroy($id);

}
