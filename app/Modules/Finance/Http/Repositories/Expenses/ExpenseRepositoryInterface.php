<?php

namespace App\Modules\Finance\Http\Repositories\Expenses;

use App\Repositories\CommonRepositoryInterface;

interface ExpenseRepositoryInterface extends CommonRepositoryInterface
{
    public function index();
    public function store($data);
    public function edit($data, $id);
    public function show($id);
    public function removeAttachment($id);
}
