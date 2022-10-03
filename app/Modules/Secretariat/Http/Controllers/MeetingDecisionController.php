<?php

namespace App\Modules\Secretariat\Http\Controllers;

use App\Foundation\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Modules\Secretariat\Http\Repositories\Meetings\MeetingDecisionRepositoryInterface;
use App\Modules\Secretariat\Http\Requests\DecisionRequest;

class MeetingDecisionController extends Controller
{
    use ApiResponseTrait;

    private MeetingDecisionRepositoryInterface $decisionRepository;

    public function __construct(MeetingDecisionRepositoryInterface $decisionRepository)
    {
        $this->decisionRepository = $decisionRepository;
    }

    public function store(DecisionRequest $request, $meetingId)
    {
        try {

            $this->decisionRepository->create(array_merge($request->all(), ['meeting_id' => $meetingId]));
            return $this->successResponse(true);

        } catch (\Exception $exception) {

            return $this->errorResponse(null, 500, $exception->getMessage());

        }
    }

    public function update(DecisionRequest $request, $meetingId, $id)
    {
        try {

            $this->decisionRepository->update($request->all(), $id);
            return $this->successResponse(true);

        } catch (\Exception $exception) {

            return $this->errorResponse(null, 500, $exception->getMessage());

        }
    }

    public function destroy($meetingId, $id)
    {
        try {

            $this->decisionRepository->delete($id);
            return $this->successResponse(true);

        } catch (\Exception $exception) {

            return $this->errorResponse(null, 500, $exception->getMessage());

        }
    }
}
