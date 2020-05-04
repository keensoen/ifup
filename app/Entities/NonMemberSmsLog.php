<?php

namespace App\Entities;

use App\User;
use Illuminate\Database\Eloquent\Model;

class NonMemberSmsLog extends Model
{
    protected $fillable = [
    	'organization_id',
    	'number',
    	'content',
    	'user_id',
    	'status'
    ];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function organization()
    {
    	return $this->belongsTo(Organization::class);
    }
}
