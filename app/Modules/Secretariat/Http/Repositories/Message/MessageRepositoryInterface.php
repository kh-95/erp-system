<?php

namespace App\Modules\Secretariat\Http\Repositories\Message;
use App\Modules\Reception\Http\Requests\Visit\StoreRequest;
use App\Modules\Reception\Http\Requests\Visit\UpdateRequest;
use App\Modules\Reception\Http\Requests\Visit\UpdateStatusRequest;
use App\Repositories\CommonRepositoryInterface;
use Illuminate\Http\Request;

interface MessageRepositoryInterface extends CommonRepositoryInterface
{
    public function index(Request $request);
    public function store(StoreRequest $request);
    public function edit(UpdateRequest $request, $id);
    public function show($id);
    public function destroy($id);
    public function restore($id);
}
