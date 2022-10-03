<?php

namespace App\Modules\HR\Http\Controllers;

use Illuminate\Http\Request;
use App\Foundation\Classes\Helper;
use Illuminate\Routing\Controller;
use Illuminate\Contracts\Support\Renderable;
use App\Modules\HR\Http\Repositories\ActivityRepositoryInterface;


class ActivityController extends Controller
{
    private $repository;

    public function __construct(ActivityRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
       return $this->repository->index();
    }

}
