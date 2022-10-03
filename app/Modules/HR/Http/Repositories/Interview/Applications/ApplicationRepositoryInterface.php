<?php

namespace App\Modules\HR\Http\Repositories\Interview\Applications;


use App\Modules\HR\Http\Requests\InterviewRequest;
use App\Repositories\CommonRepositoryInterface;
use Illuminate\Http\Request;

interface ApplicationRepositoryInterface extends CommonRepositoryInterface
{
    public function index();
    public function show($id);
}
