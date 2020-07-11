<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Entities\Member;
use App\Entities\Organization;
use App\Entities\PrayerRequest;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable //implements MustVerifyEmail
{
    use Notifiable, HasRoles, SoftDeletes, HasApiTokens;

    protected $fillable = [
        'organization_id', 'member_id', 'username', 'email', 'password', 'photo', 'status', 'device_token'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function prayerRequests()
    {
        return $this->hasMany(PrayerRequest::class);
    }
}
