<?php

namespace App\Modules\Legal\Http\Repositories\Agenecy;

use App\Modules\Legal\Entities\Agenecy;
use App\Modules\Legal\Http\Requests\AgenecyRequest;
use App\Repositories\CommonRepositoryInterface;

interface AgenecyRepositoryInterface extends CommonRepositoryInterface
{
    public function store(AgenecyRequest $request);
    public function updateAgenecy(AgenecyRequest $request, Agenecy $agenecy);
}
