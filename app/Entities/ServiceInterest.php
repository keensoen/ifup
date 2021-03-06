<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class ServiceInterest extends Model
{
    protected $fillable = [
    	'name',
        'short_code',
        'starts_at',
        'ends_at',
        'capacity',
    ];
}
