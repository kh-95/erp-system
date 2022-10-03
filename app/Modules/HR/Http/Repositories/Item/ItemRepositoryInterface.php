<?php

namespace App\Modules\HR\Http\Repositories\Item;


use App\Modules\HR\Http\Requests\ItemRequest;
use App\Repositories\CommonRepositoryInterface;

interface ItemRepositoryInterface extends CommonRepositoryInterface
{
    public function store(ItemRequest $request);

    public function updateInterviewItem(ItemRequest $request, $id);

    public function edit($id);

    public function show($id);

    public function destroy($id);

}
