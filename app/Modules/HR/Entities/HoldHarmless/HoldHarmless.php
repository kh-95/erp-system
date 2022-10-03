<?php

namespace App\Modules\HR\Entities\HoldHarmless;

use App\Foundation\Traits\HasTablePrefixTrait;
use App\Foundation\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Modules\HR\Entities\Employee;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class HoldHarmless extends Model
{
    use HasFactory, Translatable, SoftDeletes, HasTablePrefixTrait ,Timestamp;

    public $translatedAttributes = ['note','dm_rejection_reason', 'hr_rejection_reason','it_rejection_reason',
                                   'legal_rejection_reason', 'finance_rejection_reason', 'hr_note',
                                   'it_note', 'legal_note', 'finance_note'];
    protected $guarded = ['id'];
    protected $translationForeignKey = 'hold_harmless_id';

 //responses
 const PENDING = 'pending';
 const ACCEPTED = 'accepted';
 const REJECTED = 'rejected';

 const DM_RESPONSE = [self::PENDING, self::ACCEPTED , self::REJECTED];

 const HR_RESPONSE = [self::PENDING, self::ACCEPTED , self::REJECTED];
 const IT_RESPONSE = [self::PENDING, self::ACCEPTED , self::REJECTED];
 const lEGAL_RESPONSE = [self::PENDING, self::ACCEPTED , self::REJECTED];
 const FINANACE_RESPONSE = [self::PENDING, self::ACCEPTED , self::REJECTED];


 //reason
 const RESIGNATION = 'resignation';
 const END_CONTRACT = 'end_contract';
 const END_PROBATIONARY = 'end_probationary';
 const SEGREGATION     ='segregation';

 const Reason = [self::RESIGNATION, self::END_CONTRACT , self::END_PROBATIONARY , self::SEGREGATION];





    protected static function newFactory()
    {
        return \App\Modules\HR\Database\factories\HoldHarmlessFactory::new();
    }

    public function employees(){
       return $this->belongsTo(Employee::class, 'employee_id');
    }
}
