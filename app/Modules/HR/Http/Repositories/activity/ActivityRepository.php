<?php

namespace App\Modules\HR\Http\Repositories\activity;

use App\Foundation\Classes\Helper;
use App\Repositories\CommonRepository;
use App\Modules\HR\Http\Repositories\ActivityRepositoryInterface;
use App\Modules\HR\Transformers\ActivitiesResource;
use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\HR\Entities\Activity;
use Illuminate\Support\Facades\DB;

class ActivityRepository extends CommonRepository implements ActivityRepositoryInterface
{
    use ApiResponseTrait;

    protected function filterColumns(): array
    {
        return [
            'id',
            'name',
            'main_program_id',
            'sup_program_id',
            'management_id',
            'employee_id',
            'date_from',
            'date_to',
        ];
    }

    public function model()
    {
        return Activity::class;
    }

    public function index(){
        $activities = $this->setFilters()->with(['activities', 'management', 'employee'])->paginate(Helper::PAGINATION_LIMIT);
        return $this->paginateResponse(ActivitiesResource::collection($activities),$activities);
    }

}
