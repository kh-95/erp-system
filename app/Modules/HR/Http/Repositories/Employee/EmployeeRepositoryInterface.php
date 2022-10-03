<?php

namespace App\Modules\HR\Http\Repositories\Employee;

use App\Modules\HR\Http\Requests\Employee\StoreRequest;
use App\Modules\HR\Http\Requests\Employee\UpdateRequest;
use App\Repositories\CommonRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

interface EmployeeRepositoryInterface extends CommonRepositoryInterface
{
    public function index(Request $request);
    public function uniqueEmployeeNumber();
    public function store(StoreRequest $request);
    public function edit(UpdateRequest $request, $id);
    public function show($id);
    public function listEmployees(Request $request);
    public function listCustomerServiceEmployees();
    public function storeJobInformation(int $employeeId, $request);
    public function storeAttachements(int $employeeId, $request);
    public function storeAllowence(int $employeeId, $request);
    public function storeCustodies(int $employeeId, $request);
}
