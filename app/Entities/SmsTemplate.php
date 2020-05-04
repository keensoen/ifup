<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SmsTemplate extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'organization_id',
        'month',
        'month_number',
        'year',
        'message_temp',
        'user_id'
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function smsLog() 
    {
        return $this->hasMany(SmsLog::class);
    }
}
