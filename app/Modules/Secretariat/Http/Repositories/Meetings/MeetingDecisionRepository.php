<?php

namespace App\Modules\Secretariat\Http\Repositories\Meetings;

use App\Modules\Secretariat\Entities\MeetingDecision;
use App\Repositories\CommonRepository;

class MeetingDecisionRepository extends CommonRepository implements MeetingDecisionRepositoryInterface
{
    public function model()
    {
        return MeetingDecision::class;
    }

}
