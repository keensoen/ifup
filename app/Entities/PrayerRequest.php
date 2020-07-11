<?php

namespace App\Entities;

use App\User;
use Illuminate\Database\Eloquent\Model;

class PrayerRequest extends Model
{
    protected $fillable = [
        'member_id',
        'organization_id',
        'prayer_point',
        'user_id',
        'attended_to'
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
