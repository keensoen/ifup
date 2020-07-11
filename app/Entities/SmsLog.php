<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class SmsLog extends Model
{
    protected $fillable = [
        'member_id',
        'organization_id',
        'sms_template_id',
        'content',
        'status'
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function smsTemplate()
    {
        return $this->belongsTo(SmsTemplate::class);
    }
}
