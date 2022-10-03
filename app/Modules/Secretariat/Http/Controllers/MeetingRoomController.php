<?php

namespace App\Modules\Secretariat\Http\Controllers;

use App\Foundation\Classes\Helper;
use App\Foundation\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Modules\Secretariat\Http\Repositories\MeetingRooms\MeetingRoomRepositoryInterface;
use App\Modules\Secretariat\Http\Requests\MeetingRoomRequest;
use Illuminate\Http\Request;

class MeetingRoomController extends Controller
{
    use ApiResponseTrait;

    private MeetingRoomRepositoryInterface $meetingRoomRepository;

    public function __construct(MeetingRoomRepositoryInterface $meetingRoomRepository)
    {
        $this->meetingRoomRepository = $meetingRoomRepository;
        $this->middleware('permission:list-meetingRoom')->only(['index']);
        $this->middleware('permission:create-meetingRoom')->only('store');
        $this->middleware('permission:edit-meetingRoom')->only('update');
        $this->middleware('permission:delete-meetingRoom')->only('destroy');
    }

    public function index(Request $request)
    {
        $meetingRooms = $this->meetingRoomRepository
            ->setFilters()
            ->select(['id', 'name'])
            ->get();
//            ->paginate(Helper::getPaginationLimit($request));
        return $this->successResponse($meetingRooms);
    }

    public function store(MeetingRoomRequest $request)
    {
        $meetingRoom = $this->meetingRoomRepository->create($request->validated());
        return $this->successResponse($meetingRoom, 201);
    }

    public function update(MeetingRoomRequest $request, $id)
    {
        $meetingRoom = $this->meetingRoomRepository->update($request->validated(), $id);
        return $this->successResponse($meetingRoom);
    }

    public function destroy($id)
    {
        $this->meetingRoomRepository->delete($id);
        return $this->successResponse('deleted');
    }
}
