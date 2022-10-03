<?php

namespace App\Modules\Governance\Entities;

use App\Foundation\Traits\FileTrait;
use App\Foundation\Traits\HasTablePrefixTrait;
use App\Foundation\Traits\ImageTrait;
use App\Modules\HR\Entities\Nationality;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CandidacyApplication extends Model
{
    use HasFactory ,HasTablePrefixTrait ,FileTrait ,ImageTrait ;

    const CANDIDACYAPPLICATION = 'candidacyapplication'; //location upload files


    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $table = 'governance_candidacy_applications';


    const HIGH_SCHOOL = 'highschool';
    const DIPLOMA = 'diplom';
    const BACHELOR = 'bachelor';
    const MASTER =  'master';
    const PHD    = 'phd';
    const QULAIFICATION_LEVELS = [self::HIGH_SCHOOL,  self::DIPLOMA,  self::BACHELOR,  self::MASTER, self::PHD];

    const WAITING_MEETING = 'Waitingmeeting';
    const WORK_PROGRESS = 'Workinprogress';
    const ACCEPTED = 'accepted';
    const REFUSED =  'refused';

    const ORDER_STATUSES =[self::WAITING_MEETING,  self::WORK_PROGRESS,  self::ACCEPTED,  self::REFUSED];

  const IMAGE = 'image';
    const DOCUMENT = 'document';
    const VIDEO = 'video';

    const FILE_TYPES = [self::IMAGE, self::DOCUMENT, self::VIDEO];


    public function attachments()
    {
        return $this->hasMany(CandidacyAttachment::class,'candidacy_id');
    }



    public function nationality()
    {
        return $this->belongsTo(Nationality::class,'nationality_id');
    }
}
