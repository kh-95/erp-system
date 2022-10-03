<?php

namespace App\Modules\HR\Entities\Items;

use App\Foundation\Traits\HasTablePrefixTrait;
use App\Modules\HR\Entities\Employee;
use App\Modules\HR\Entities\Management;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Item extends Model implements TranslatableContract
{
    use HasFactory, Translatable, HasTablePrefixTrait;

    const INTERVIEW = 'interview';
    const PROBATION = 'probation';
    const TYPE = [self::INTERVIEW, self::PROBATION];


    protected $table = 'hr_items';
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $dates = ['created_at', 'updated_at'];
    public $translatedAttributes = ['name'];


    public function scopeScoreFrom($query, $score)
    {
        return $query->where('score', '>=', $score);
    }

    public function scopeScoreTo($query, $score)
    {
        return $query->where('score', '<=', $score);
    }

    public function addedBy()
    {
        return $this->belongsTo(Employee::class, 'added_by_id');
    }

    public function management()
    {
        return $this->belongsTo(Management::class, 'management_id');
    }

    //    protected static function newFactory()
    //    {
    //        return \App\Modules\HR\Database\factories\Item / ItemFactory::new();
    //    }

    public function employeeEvaluationItems()
    {
        return $this->hasMany(EmployeeEvaluationItem::class, 'item_id');
    }
}
