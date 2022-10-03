<?php

namespace App\Modules\Secretariat\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Modules\Secretariat\Http\Repositories\Message\MessageRepositoryInterface;
use App\Modules\Secretariat\Http\Requests\Message\MessageRequest;

class MessageController extends Controller
{

    private $repository;

    public function __construct(MessageRepositoryInterface $messageRepository)
    {
        $this->repository = $messageRepository;
        $this->middleware('permission:list-messages')->only(['index']);
        $this->middleware('permission:create-messages')->only('store');
        $this->middleware('permission:edit-messages')->only('update');
        $this->middleware('permission:delete-messages')->only('destroy');
        $this->middleware('permission:restore-messages')->only('restore');
    }

    public function index(Request $request){
        return $this->repository->index($request);
    }

    public function store(MessageRequest $request)
    {
        return $this->repository->store($request->validated());
    }

    public function show($id)
    {
        return $this->repository->show($id);
    }

    public function update(MessageRequest $request, $id)
    {
        return $this->repository->edit($request->validated(),$id);
    }

    public function destroy($id)
    {
        return $this->repository->destroy($id);
    }

    public function restore($id)
    {
        return $this->repository->restore($id);
    }

    public function activities($id)
    {
        return $this->repository->recordActivities($id);
    }
}
