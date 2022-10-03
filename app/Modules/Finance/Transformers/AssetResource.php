<?php

namespace App\Modules\Finance\Transformers;

use App\Foundation\Classes\Helper;
use App\Transformers\ActivityResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AssetResource extends JsonResource
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
            'purchase_date'             => $this->purchase_date,
            'operation_date'            => $this->operation_date ,
            'measure_value'             => $this->measure_value ,
            'barcode'                   => $this->barcode ,
            'account'                   => $this->account ,
            'value'                     => $this->scrap_value ,
            'scrap_value'               => $this->expiration_date ,
            'expiration_date'           => $this->is_depreciable ,
            'is_depreciable'            => $this->depreciation_fees ,
            'depreciation_fees'         => $this->depreciation_fees ,
            'total_depreciation_fees'   => $this->total_depreciation_fees ,
            'is_assurance_exists'       => $this->is_assurance_exists ,
            'assurance_expiration_date' => $this->assurance_expiration_date ,
            'attachments'               => $attachmentsArray,
            'name'                      => $this->name ,
            'category'                  => $this->category ,
            'measure_unit'              => $this->measure_unit ,
            'tax'                       => $this->tax ,
            'description'               => $this->description ,
            'activities'                => ActivityResource::collection($this->whenLoaded('activities'))

        ];
    }
}
