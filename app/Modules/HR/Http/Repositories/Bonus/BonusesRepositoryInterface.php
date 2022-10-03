<?php

namespace App\Modules\HR\Http\Repositories\Bonus;

use App\Modules\HR\Http\Requests\BonusRequest;
use App\Modules\HR\Http\Requests\BounsStatusRequest;
use App\Repositories\CommonRepositoryInterface;
use App\Modules\HR\Http\Requests\BounsPaidRequest;

interface BonusesRepositoryInterface extends CommonRepositoryInterface
{
    public function store(BonusRequest $request);

    public function updateBonus(BonusRequest $request, $id);

    public function edit($id);

    public function show($id);
    public function destroy($id);

    public function bonusPaid(BounsPaidRequest $request, $id);

    public function bonusStatus(BounsStatusRequest $request, $id);
}
