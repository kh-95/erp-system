<?php

namespace App\Modules\HR\Entities\Interviews;

use App\Foundation\Traits\HasTablePrefixTrait;
use App\Modules\HR\Entities\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InterviewCommitteeMember extends Model
{
    use HasFactory, HasTablePrefixTrait;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function member()
    {
        return $this->belongsTo(Employee::class, 'member_id');
    }

    public function interview()
    {
        return $this->belongsTo(Interview::class, 'interview_id');
    }

//    protected static function newFactory()
//    {
//        return \App\Modules\HR\Database\factories\Interviews/InterviewCommitteeMemberFactory::new();
//    }
}
