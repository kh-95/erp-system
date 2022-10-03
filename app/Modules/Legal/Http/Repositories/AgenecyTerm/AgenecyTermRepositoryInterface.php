<?php

namespace App\Modules\Legal\Http\Repositories\AgenecyTerm;

use App\Modules\Legal\Entities\AgenecyTerm\AgenecyTerm;
use App\Modules\Legal\Http\Requests\AgenecyTermRequest;
use App\Repositories\CommonRepositoryInterface;

interface AgenecyTermRepositoryInterface extends CommonRepositoryInterface
{
    public function store(AgenecyTermRequest $request);
    public function updateAgenecyTerm(AgenecyTermRequest $request, AgenecyTerm $agenecyTerm);
}
