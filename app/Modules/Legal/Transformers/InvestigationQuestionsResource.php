<?php

namespace App\Modules\Legal\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Modules\HR\Transformers\EmployeeResource;
use App\Modules\HR\Transformers\ManagementResource;
use App\Modules\Legal\Entities\InvestigationQuestions;

class InvestigationQuestionsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'                      => $this->id,
            'question'                => $this->question,
            'answer'                  => $this->answer
        ];
    }
}
