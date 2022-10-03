<?php

namespace App\Modules\Secretariat\Http\Repositories\Meetings;

use App\Foundation\Classes\Helper;
use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\Secretariat\Entities\EmployeeMeeting;
use App\Modules\Secretariat\Http\Requests\EmployeeMeetingRequest;
use App\Modules\Secretariat\Transformers\Meetings\MeetingResource;
use App\Repositories\CommonRepository;
use Illuminate\Http\Request;

class EmployeeMeetingRepository extends CommonRepository implements EmployeeMeetingRepositoryInterface
{
    use ApiResponseTrait;

    public function model()
    {
        return EmployeeMeeting::class;
    }

    public function index(Request $request)
    {
        $meetings = auth()->user()->employee->meetings()->with(['discussionPoints', 'decisions'])->paginate(Helper::getPaginationLimit($request));
        return $this->successResponse([
            'meetings' => MeetingResource::collection($meetings),
            'pagination' => [
                'total' => $meetings->total(),
                'count' => $meetings->count(),
                'per_page' => $meetings->perPage(),
                'current_page' => $meetings->currentPage(),
                'total_pages' => $meetings->lastPage()
            ],
        ]);
    }

    public function edit(EmployeeMeetingRequest $request, $id)
    {
        $employeeMeeting = $this->find($id);
        if ($employeeMeeting->employee_id === auth()->id()) {
            $data['rejected_reason'] = $request->rejected_reason;
            $data['status'] = now();

            if ($request->status) {
                $data['rejected_reason'] = null;
                $data['status'] = null;
            }

            $this->update($data, $id);
            return $this->successResponse(true);
        }
        abort(403);
    }
}
