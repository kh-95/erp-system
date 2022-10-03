<?php

namespace App\Foundation\Traits;

use Carbon\Carbon;

trait DeactivatedTrait
{
    public function scopeActive($query)
    {
        return $query->whereNull('deactivated_at');
    }

    public function scopeDisabled($query)
    {
        return $query->whereNotNull('deactivated_at');
    }

    public function setDeactivatedAtAttribute($deactivatedAt)
    {
        $this->attributes['deactivated_at'] = $deactivatedAt ? now() : null;
    }

    public function getDeactivatedAtAttribute($value)
    {
        $locale = app()->getLocale();
        return $value ? Carbon::parse($value)->locale($locale)->translatedFormat('j F Y - h:i A') : null;
    }
}
