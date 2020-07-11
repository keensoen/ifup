<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use DB;

class Organization extends Model
{
    protected $fillable = [
        'code',
        'general_name',
        'parish',
        'logo',
        'reg_prefix',
        'contact_person',
        'phone',
        'email',
        'address'
    ];

    public static function code() 
    {
        $p = DB::table('organizations')->max('id');
        $id = $p + 1;
        $newId = 'ORG' . str_pad($id, 4, '0', STR_PAD_LEFT);
        return $newId;
    }

    public function member()
    {
        return $this->hasMany(Member::class);
    }

    public static function authRole($model, $user)
    {
        $items = null;

        foreach($user->getRoleNames() as $role) {
            if($role === 'super-admin') {
                $items = $model->get();
            }
            else {
                $items = $model->whereId(auth()->user()->organization_id)->get();
            }
        }
        return $items;
    }

    public function smsLog() 
    {
        return $this->hasMany(SmsLog::class);
    }
}
