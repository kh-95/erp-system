<?php

namespace App\Modules\RiskManagement\Http\Repositories\Bank;

use App\Modules\RiskManagement\Http\Requests\BankRequest;
use App\Repositories\CommonRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;


interface BankRepositoryInterface extends CommonRepositoryInterface
{
    public function show($id);

    public function store(BankRequest $request);

    public function updateBank(BankRequest $request,$id);
    public function delete($id);
    public function listBanks();
}
