<?php

namespace App\Modules\HR\Transformers\Interview;

use App\Modules\HR\Entities\Interviews\InterviewApplication;
use App\Modules\HR\Transformers\EmployeeResource;
use App\Modules\HR\Transformers\JobResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class InterviewItemResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'is_active' => (boolean)$this->is_active,
            'final_score' => number_format($this->score, 2, '.', ''),
            'score' => number_format($this->pivot->score, 2, '.', ''),



        ];
    }
}
