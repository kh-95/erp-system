<?php

namespace App\Modules\CustomerService\Http\Repositories\Call;

use App\Modules\CustomerService\Entities\Call;
use App\Modules\CustomerService\Http\Requests\ConvertCallRequest;
use App\Repositories\CommonRepositoryInterface;
use Illuminate\Http\Request;

interface CallRepositoryInterface extends CommonRepositoryInterface
{
    public function index(Request $request);
    public function convertCall(ConvertCallRequest $request, Call $call);
}
