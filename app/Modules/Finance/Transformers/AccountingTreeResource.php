<?php

namespace App\Modules\Finance\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Transformers\ActivityResource;

class AccountingTreeResource extends JsonResource
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
            'account_type'=>($this->parent_id=='0')?'حساب رئيسى':'حساب فرعى',
            'parent_id' => $this->parent_id,
            'payment_check'=>$this->payment_check,
            'payment_check_label'=>($this->payment_check=='0')?'لا يمكن الدفع':'يمكن الدفع به',
            'collect_check'=>$this->collect_check,
            'collect_check_label'=>($this->collect_check=='0')?'لا يمكن التحصيل به':'يمكن التحصيل به',
            'account_code'=>$this->account_code,
            'account_name'=>$this->account_name,
            'notes'=>$this->notes,
            'deactivated_at' => ($this->deactivated_at)?false:true,
            'created_at' => $this->created_at,
            'activities' => ActivityResource::collection($this->whenLoaded('activities')),
        ];
    }
}
