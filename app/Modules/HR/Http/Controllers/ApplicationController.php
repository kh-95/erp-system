<?php

namespace App\Modules\HR\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Modules\HR\Http\Repositories\Interview\Applications\ApplicationRepositoryInterface;
use App\Foundation\Traits\ApiResponseTrait;

class ApplicationController extends Controller
{
    use ApiResponseTrait;

    private $applicationRepository;

    public function __construct(ApplicationRepositoryInterface $applicationRepository)
    {
        $this->applicationRepository = $applicationRepository;
    }

    public function index(){
        return $this->applicationRepository->index();
    }

    public function show($id){
        return $this->applicationRepository->show($id);
    }

}
