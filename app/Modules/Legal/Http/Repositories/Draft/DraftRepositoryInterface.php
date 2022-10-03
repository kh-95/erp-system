<?php

namespace App\Modules\Legal\Http\Repositories\Draft;

use App\Repositories\CommonRepositoryInterface;
use App\Modules\Legal\Http\Requests\DraftRequest;


interface DraftRepositoryInterface extends CommonRepositoryInterface
{

    public function store(DraftRequest $request);
     public function edit($id);
     public function show($id);
     public function updateDraftRequset(DraftRequest $request,$id);
}
