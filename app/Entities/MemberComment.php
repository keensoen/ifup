<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class MemberComment extends Model
{
    protected $fillable = [
        'member_id',
        'organization_id',
        'comment'
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'id');
    }
}
