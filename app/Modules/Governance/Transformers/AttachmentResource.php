<?php

namespace App\Modules\Governance\Transformers;

use App\Foundation\Classes\Helper;
use Illuminate\Http\Resources\Json\JsonResource;

class AttachmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $path = $this->type == 'image' ? Helper::BASE_PATH : Helper::BASE_FILE;
        return [
            'id' => $this->id,
            'type' => $this->type,
            'file' => asset('storage' . '/' . $path . '/' . $this->location . '/' . $this->file)
        ];
    }
}
