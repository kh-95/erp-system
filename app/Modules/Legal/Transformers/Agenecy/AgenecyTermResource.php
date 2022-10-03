<?php

namespace App\Modules\Legal\Transformers\Agenecy;

use App\Transformers\GlobalTransResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AgenecyTermResource extends JsonResource
{
    public function toArray($request)
    {
        $locales = [];
        if ($this->relationLoaded('translations')) {
            foreach (config('translatable.locales') as $locale) {
                $locales['translations'][$locale] = GlobalTransResource::make($this->translations->firstWhere('locale', $locale));
            }
        }

        return [
            'id' => $this->id,
            'is_active' => (bool) $this->is_active,
            'type' => AgenecyTypeResource::make($this->agenecyType)
        ] + $locales;
    }
}
