<?php

namespace App\Modules\HR\Entities\HoldHarmless;

use App\Foundation\Traits\HasTablePrefixTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HoldHarmlessTranslation extends Model
{
    use HasFactory, HasTablePrefixTrait;
    public $timestamps = false;

    protected $fillable = ['note','hr_rejection_reason','it_rejection_reason',
                          'legal_rejection_reason', 'finance_rejection_reason', 'hr_note',
                          'it_note', 'legal_note', 'finance_note'];



}
