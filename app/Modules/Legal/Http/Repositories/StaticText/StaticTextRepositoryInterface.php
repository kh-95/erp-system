<?php

namespace App\Modules\Legal\Http\Repositories\StaticText;

use App\Modules\Legal\Entities\StaticText\StaticText;
use App\Modules\Legal\Http\Requests\StaticTextRequest;
use App\Repositories\CommonRepositoryInterface;

interface StaticTextRepositoryInterface extends CommonRepositoryInterface
{
    public function store(StaticTextRequest $request);
    public function updateStaticText(StaticTextRequest $request, StaticText $staticText);
}
