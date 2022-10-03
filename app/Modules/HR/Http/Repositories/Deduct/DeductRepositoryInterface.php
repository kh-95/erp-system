<?php

namespace App\Modules\HR\Http\Repositories\Deduct;

use App\Modules\HR\Http\Requests\DeductRequest;
use App\Repositories\CommonRepositoryInterface;
use App\Modules\HR\Http\Requests\DeductStatusRequest;


interface DeductRepositoryInterface extends CommonRepositoryInterface
{

    public function store(DeductRequest $request);
    public function updateDeduct(DeductRequest $request, $id);
    public function destroy($id);
    public function getEmployeeByNumber($employee_number);
    public function deductStatus(DeductStatusRequest $request, $id);

}
