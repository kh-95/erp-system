<?php

namespace App\Modules\Legal\Entities;

use App\Foundation\Traits\HasTablePrefixTrait;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CourtSession extends Model
{
    use HasFactory,HasTablePrefixTrait;

    protected $guarded = ['id', 'created_at', 'updated_at'];

     // Scopes

     public function scopeSessionStartsFrom(Builder $query, $date): Builder
     {
         $starts_from = date('Y-m-d', strtotime($date));

         return $query->whereDate('session_date', '>=', $starts_from)->orWhereDate('session_date_hijri','>=',$starts_from);
     }

     public function scopeSessionEndsAt(Builder $query, $date): Builder
     {
         $ends_at = date('Y-m-d', strtotime($date));

         return $query->whereDate('session_date', '<=', $ends_at)->orWhereDate('session_date_hijri','<=',$ends_at);
     }


}
