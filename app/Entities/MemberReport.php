<?php

namespace App\Entities;

use App\User;
use Illuminate\Database\Eloquent\Model;

class MemberReport extends Model
{
    protected $fillable = [
        'organization_id',
    	'added_by',
    	'member_id',
    	'comment'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'added_by');
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }
}
