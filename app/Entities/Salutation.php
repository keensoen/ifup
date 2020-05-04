<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Salutation extends Model
{
    protected $fillable = [
    	'title',
    	'short_code'
    ];
}
