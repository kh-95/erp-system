<?php

namespace App\Modules\Reception\Http\Repositories\Visitor;
use App\Modules\Reception\Http\Requests\Visitor\StoreRequest;
use App\Modules\Reception\Http\Requests\Visitor\UpdateRequest;
use App\Repositories\CommonRepositoryInterface;

interface VisitorRepositoryInterface extends CommonRepositoryInterface
{
    public function store(StoreRequest $request, $visit_id);
    public function edit(UpdateRequest $request, $id);
    public function editVisitor($id);
}
