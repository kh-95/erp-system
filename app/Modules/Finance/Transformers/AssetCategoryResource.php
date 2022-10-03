<?php

namespace App\Modules\Finance\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Transformers\ActivityResource;

class AssetCategoryResource extends JsonResource
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
            'revise_no' => $this->revise_no,
            'accountname' => $this->account?->account_name,
            'destroy_check'=>$this->destroy_check,
            'destroy_check_check_label'=>($this->destroy_check=='0')?'غير قابل للهلاك':'قابل للهلاك',
            'destroy_ratio'=>$this->destroy_ratio,
            'name'=>$this->name,
            'notes'=>$this->notes,
            'deactivated_at' => ($this->deactivated_at)?false:true,
            'created_at' => $this->created_at,
            'activities' => ActivityResource::collection($this->whenLoaded('activities')),
        ];
    }
}
