<?php

namespace App\Modules\Governance\Http\Controllers;

use App\Foundation\Classes\Helper;
use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\Governance\Http\Repositories\MeetingPlace\MeetingPlaceRepositoryInterface;
use App\Modules\Governance\Http\Requests\MeetingPlaceRequest;
use App\Modules\Governance\Transformers\MeetingPlaceResource;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class MeetingPlaceController extends Controller
{
    use ApiResponseTrait;

    public function __construct(private MeetingPlaceRepositoryInterface $meetingPlaceRepository)
    {
       $this->middleware('permission:list-meeting_places')->only(['index']);
       $this->middleware('permission:create-meeting_places')->only(['store']);
       $this->middleware('permission:edit-meeting_places')->only(['updateMeetingPlace','edit']);
       $this->middleware('permission:show-meeting_places')->only(['show']);
       $this->middleware('permission:delete-meeting_places')->only(['destroy']);

    }

    public function index(Request $request)
    {
        $meetingPlace = $this->meetingPlaceRepository->setFilters()
            ->defaultSort('-created_at')
            ->customDateFromTo($request)
            ->allowedSorts($this->meetingPlaceRepository->sortColumns())
            ->paginate(Helper::PAGINATION_LIMIT);
        $data = MeetingPlaceResource::collection($meetingPlace);

        return $this->paginateResponse($data, $meetingPlace);
    }


    public function store(MeetingPlaceRequest $request)
    {
        $meetingPlace = $this->meetingPlaceRepository->store($request);
        $data = MeetingPlaceResource::make($meetingPlace);
        return $this->successResponse($data, message: trans('legal::messages.general.successfully_created'));
    }


    public function show($id)
    {
        $meetingPlace = $this->meetingPlaceRepository->show($id);
        return $this->successResponse(MeetingPlaceResource::make($meetingPlace));
    }

    public function edit($id)
    {
        $meetingPlace = $this->meetingPlaceRepository->edit($id);
        return $this->successResponse(MeetingPlaceResource::make($meetingPlace));
    }

    public function updateMeetingPlace(MeetingPlaceRequest $request, $id)
    {
        $meetingPlace = $this->meetingPlaceRepository->updateMeetingPlace($request,$id);
        $data = MeetingPlaceResource::make($meetingPlace);
        return $this->successResponse($data, message: trans('legal::messages.general.successfully_updated'));
    }


    public function destroy($id)
    {
        return $this->meetingPlaceRepository->destroy($id);
    }




}
