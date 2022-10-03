<?php

namespace App\Modules\User\Entities;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Foundation\Traits\HasTablePrefixTrait;
use App\Modules\HR\Entities\Employee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, HasTablePrefixTrait;

    protected $fillable = [
        'employee_id', 'employee_number', 'password',
        'is_send_otp', 'otp', 'blocked_key', 'image',
        'deactivated_from', 'deactivated_at',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'deactivated_from' => 'datetime',
        'deactivated_at' => 'datetime',
    ];

    protected $appends = ['status'];

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    protected static function newFactory()
    {
        return \App\Modules\User\Database\factories\UserFactory::new();
    }


    public function getStatusAttribute()
    {
        return $this->deactivated_at === null ? 'enable' : 'disable' ;
    }


}
