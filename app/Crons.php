<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Crons extends Model
{
	protected $primaryKey = 'command';

    protected $fillable = ['command', 'next_run', 'last_run'];

    public static function shouldIRun($command, $minutes) {
        $cron = self::find($command);
        $now  = Carbon::now();
        if ($cron && $cron->next_run > $now->timestamp) {
            return false;
        }
        self::updateOrCreate(
            ['command'  => $command],
            ['next_run' => Carbon::now()->addMinutes($minutes)->timestamp,
             'last_run' => Carbon::now()->timestamp]
        );
        return true;
    }
}
