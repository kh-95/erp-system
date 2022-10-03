<?php

namespace App\Modules\Legal\Http\Repositories\AgenecyType;

use App\Modules\Legal\Entities\AgenecyType\AgenecyType;
use App\Modules\Legal\Http\Requests\AgenecyTypeRequest;
use App\Repositories\CommonRepositoryInterface;

interface AgenecyTypeRepositoryInterface extends CommonRepositoryInterface
{
    public function store(AgenecyTypeRequest $request);
    public function updateAgenecyType(AgenecyTypeRequest $request, AgenecyType $agenecyType);
}
