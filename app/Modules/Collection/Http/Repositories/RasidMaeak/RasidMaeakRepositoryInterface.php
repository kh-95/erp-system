<?php

namespace App\Modules\Collection\Http\Repositories\RasidMaeak;

use App\Repositories\CommonRepositoryInterface;

interface RasidMaeakRepositoryInterface extends CommonRepositoryInterface
{
    public function index();
    public function show($id);
}
