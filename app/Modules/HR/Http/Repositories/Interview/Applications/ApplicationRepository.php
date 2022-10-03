<?php

namespace App\Modules\HR\Http\Repositories\Interview\Applications;

use App\Foundation\Classes\Helper;
use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\HR\Entities\Interviews\Interview;
use App\Modules\HR\Entities\Interviews\InterviewApplication;
use App\Repositories\CommonRepository;
use Carbon\Carbon;
use App\Modules\HR\Transformers\Interview\InterviewApplicationResource;
use Illuminate\Http\Request;

class ApplicationRepository extends CommonRepository implements ApplicationRepositoryInterface
{
    use ApiResponseTrait;

    public function filterColumns()
    {
        return [
            'id',
            'interview_id',
            'name',
            'email',
            'identity_number',
            'mobile',
            'interview_date',
            'note',
            'created_at'
        ];
    }

    public function sortColumns()
    {
        return [
            'id',
        ];
    }

    public function model()
    {
        return InterviewApplication::class;
    }


    public function index(){
        $interveiws = $this->setFilters()->defaultSort('-id')
        ->allowedSorts(
        'id',
        'interview_id',
        'name',
        'email',
        'identity_number',
        'mobile',
        'interview_date',
        'note',
        'created_at')->paginate(Helper::PAGINATION_LIMIT);
        return $this->paginateResponse(InterviewApplicationResource::collection($interveiws),$interveiws);
    }

    public function show($id)
    {
       try{
        $application = $this->findOrFail($id);
        return $this->successResponse(data:InterviewApplicationResource::make($application));
       }catch(\Exception $exception){
        return $this->errorResponse(null, 500, $exception->getMessage());
       }
    }

}
