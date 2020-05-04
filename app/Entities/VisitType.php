<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class VisitType extends Model
{
    protected $fillable = [
    	'name',
    	'short_code'
    ];
}
