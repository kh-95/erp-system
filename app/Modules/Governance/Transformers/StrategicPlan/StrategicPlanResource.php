<?php

namespace App\Modules\Governance\Transformers\StrategicPlan;

use App\Transformers\GlobalTransResource;
use Illuminate\Http\Resources\Json\JsonResource;

class StrategicPlanResource extends JsonResource
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
            'achieved' => $this->achieved . '%',
            'from' => $this->from,
            'to' => $this->to,
            'created_at' => $this->created_at,
        ] + $locales;
    }
}
