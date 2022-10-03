<?php

namespace App\Modules\Reception\Http\Repositories\Visit;
use App\Modules\Reception\Http\Requests\Visit\StoreRequest;
use App\Modules\Reception\Http\Requests\Visit\UpdateRequest;
use App\Modules\Reception\Http\Requests\Visit\UpdateStatusRequest;
use App\Repositories\CommonRepositoryInterface;
use Illuminate\Http\Request;

interface VisitRepositoryInterface extends CommonRepositoryInterface
{
    public function index(Request $request);
    public function store(StoreRequest $request);
    public function edit(UpdateRequest $request, $id);
    public function editٍStatus(UpdateStatusRequest $request, $id);
    public function editVisit($id);
    public function restore($id);
}
