<?php

namespace App\Modules\HR\Http\Repositories\VacationAttachment;

use App\Modules\HR\Entities\VacationAttachment;
use App\Repositories\CommonRepository;
use Spatie\QueryBuilder\QueryBuilder;
use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\HR\Transformers\VacationResource;
use App\Repositories\CommonRepositoryInterface;
use App\Modules\HR\Http\Requests\VacationRequest;
use App\Foundation\Traits\ImageTrait;



class VacationAttachmentRepository extends CommonRepository implements VacationAttachmentRepositoryInterface
{
    
    use ApiResponseTrait;
   

    public function model()
    {
        return VacationAttachment::class;
    }


}
