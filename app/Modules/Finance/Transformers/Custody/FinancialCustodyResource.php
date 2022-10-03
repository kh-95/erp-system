<?php

namespace App\Modules\Finance\Transformers\Custody;

use App\Foundation\Classes\Helper;
use Illuminate\Http\Resources\Json\JsonResource;

class FinancialCustodyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {

        $attachments = explode("|", $this->attachments); 
        $attachmentsArray = [];
        if($attachments[0] !== ""){
            foreach ($attachments as $attachment) {
                array_push($attachmentsArray,storage_path() .  '/'.Helper::BASE_PATH . '/' . 'asset/' . $attachment);
            }
        }

        return [
            'id' => $this->id,
            'bill_number' => $this->bill_number,
            'tax_number' => $this->tax_number,
            'supplier_name' => $this->supplier_name,
            'total' => $this->total,
            'tax' => $this->tax,
            'net' => $this->net,
            'date' => $this->date,
            'cost_center_id' => $this->cost_center_id,
            'allowance_type' => $this->allowance_type,
            'supply_employee_name' => $this->supply_employee_name,
            'notes' => $this->notes,
            'management_id' => $this->management_id,
            'employee_id' => $this->employee_id,
            'attachments' => $attachmentsArray,
        ];
    }
}
