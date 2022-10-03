<?php

namespace App\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class GlobalTransResource extends JsonResource
{
    public function toArray($request)
    {
        $allAttributes = $this->getAttributes();
        return [
            'id' => $this->id,
            'locale' => $this->locale,
            'name' => $this->when(array_key_exists('name', $allAttributes), $this->name),
            'description' => $this->when(array_key_exists('description', $allAttributes), $this->description),
            'title' => $this->when(array_key_exists('title', $allAttributes), $this->title),
            'vision' => $this->when(array_key_exists('vision', $allAttributes), $this->vision)
        ];
    }
}
