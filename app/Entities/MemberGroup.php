<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MemberGroup extends Model
{
	use SoftDeletes;

    protected $fillable = [
    	'organization_id',
    	'name',
    	'short_code',
    	'description'
    ];

    protected $casts = [
        'deleted_at' => 'datetime',
    ];
}
