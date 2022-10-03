<?php

namespace App\Modules\Collection\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Modules\Collection\Http\Repositories\RasidMaeak\RasidMaeakRepositoryInterface;

class RasidMaeakController extends Controller
{
    private $repository;

    public function __construct(RasidMaeakRepositoryInterface $repository)
    {
        $this->repository = $repository;
        $this->middleware('permission:list-collection_rasid_maeak')->only(['index', 'show']);
    }

    public function index()
    {
        return $this->repository->index();
    }

    public function show($id)
    {
        return $this->repository->show($id);
    }
}
