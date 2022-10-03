<?php

namespace App\Modules\RiskManagement\Entities;

use App\Foundation\Traits\HasTablePrefixTrait;
use App\Foundation\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TakenAction extends Model
{
    use HasFactory, HasTablePrefixTrait, Timestamp;

    protected $guarded = [];

    const IMAGE = 'image';
    const DOCUMENT = 'document';
    const VIDEO = 'video';

    const FILE_TYPES = [self::IMAGE, self::DOCUMENT, self::VIDEO];

    public function notification()
    {
        return $this->belongsTo(NotificationVendor::class);
    }

    public function attachments()
    {
        return $this->hasMany(TakenActionAttachment::class, 'taken_action_id');
    }

    protected static function newFactory()
    {
        return \App\Modules\RiskManagement\Database\factories\TakenActionFactory::new();
    }

}
