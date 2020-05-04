<?php

namespace App\Entities;

use App\Entities\Member;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'member_id',
        'organization_id',
        'latitude',
        'longitude',
        'clock_in',
        'mark_by',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }
}
