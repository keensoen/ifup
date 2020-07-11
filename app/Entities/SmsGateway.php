<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class SmsGateway extends Model
{
    protected $fillable = [
        'organization_id',
        'url',
        'token',
        'routing',
        'type',
        'username',
        'password',
        'sender_id',
        'signature'
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}
