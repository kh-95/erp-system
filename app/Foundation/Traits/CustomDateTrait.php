<?php

namespace App\Foundation\Traits;

use Carbon\Carbon;

trait CustomDateTrait
{
    public function getCreatedAtAttribute($value)
    {
        $locale = app()->getLocale();
        return Carbon::parse($value)->locale($locale)->translatedFormat('j F Y - h:i A');
    }

}
