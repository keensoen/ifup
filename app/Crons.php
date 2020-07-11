<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Crons extends Model
{
	protected $primaryKey = 'command';

    protected $fillable = ['command', 'next_run', 'last_run'];
}
