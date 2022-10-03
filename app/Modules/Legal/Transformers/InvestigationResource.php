<?php

namespace App\Modules\Legal\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Modules\HR\Transformers\EmployeeResource;
use App\Modules\HR\Transformers\ManagementResource;
use App\Modules\Legal\Entities\InvestigationQuestions;

class InvestigationResource extends JsonResource
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
            'investigation_number '   => $this->investigation_number ,
            'month_one '              => $this->month_one,
            'month_one_hijri'         => $this->month_one_hijri ?? "",
            'month_two'               => $this->month_two ?? "",
            'month_two_hijri'         => $this->month_two_hijri,
            'old_investigation_count' => $this->old_investigation_count,
            'subject'                 => $this->subject,
            'reason'                  => $this->reason,
            'status'                  => $this->status,
            'investigation_result'    => $this->investigation_result,
            'notes'                   => $this->notes,
            'asigned_employee'        => EmployeeResource::make($this->whenLoaded('asignedEmployee')),
            'employee'                => EmployeeResource::make($this->whenLoaded('employee')),
            'management'              => ManagementResource::make($this->whenLoaded('management')),
            'questions'               => InvestigationQuestionsResource::collection($this->whenLoaded('investigationQuestions')),
            'attachments'             => AttachmentResource::collection($this->whenLoaded('attachments')),
            'actions' => [
                'create' => auth()->user()->can('create-investigations'),
                'update' => auth()->user()->can('edit-investigations'),
                'show' => auth()->user()->can('show-investigations'),
            ],


        ];
    }
}
