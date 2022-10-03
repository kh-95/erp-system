<?php

namespace App\Modules\CustomerService\Http\Controllers;

use App\Foundation\Classes\Helper;
use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\CustomerService\Http\Repositories\Message\MessageRepositoryInterface;
use App\Modules\CustomerService\Transformers\MessageResource;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class MessageController extends Controller
{

    use ApiResponseTrait;

    public function __construct(private MessageRepositoryInterface $messageRepository)
    {
//        $this->middleware('permission:list-messages')->only(['index']);

    }

    public function index(Request $request)
    {
        $messages = $this->messageRepository->setFilters()
            ->defaultSort('-created_at')
            ->customDateFromTo($request)
            ->allowedSorts($this->messageRepository->sortColumns())
            ->paginate(Helper::getPaginationLimit($request));
        $data = MessageResource::collection($messages);
        return $this->paginateResponse($data, $messages);
    }

}
