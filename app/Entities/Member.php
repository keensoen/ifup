<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use Str;
use App\User;
use App\Entities\Organization;

class Member extends Model
{
    use Sluggable, SoftDeletes;

    protected $fillable = [
        'code',
        'organization_id',
        'salutation_id',
        'first_name',
        'middle_name',
        'surname',
        'birthday',
        'tel',
        'email',
        'address',
        'service_interest_id',
        'save_before',
        'baptized',
        'past_life_experience',
        'first_time_visitor',
        'returning_visitor',
        'new_resident',
        'membership_interest',
        'like_visited',
        'workforce_interest',
        'availability',
        'member_link',
        'member_group_id',
        'photo',
        'slug',
    ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'fullname'
            ]
        ];
    }

    public function getFullnameAttribute() 
    {
    	if(is_null($this->middle_name) || empty($this->middle_name)){
    		return Str::upper($this->first_name . ' ' . $this->surname);
    	}
    	else {
    		return Str::upper($this->first_name . ' ' . $this->middle_name . ' ' . $this->surname);
    	}
    }

    public static function getFullname($req) 
    {
    	if(!is_null($req['middle_name']) || !empty($req['middle_name'])){
            
            return $req['first_name'] . ' ' . $req['middle_name'] . ' ' . $req['surname'];
            
    	}
    	else {
    		return $req['first_name'] . ' ' . $req['surname'];
    	}
    }

    public function serviceInterest() 
    {
    	return $this->belongsTo(ServiceInterest::class);
    }

    public function salute() 
    {
    	return $this->belongsTo(Salutation::class, 'salutation_id');
    }

    public function user() 
    {
    	return $this->hasOne(User::class);
    }

    public static function code()
    {
        $p = self::where('organization_id', auth()->user()->id)->max('id');
        $prefix = Organization::whereId(auth()->user()->id)->pluck('reg_prefix')->first();
        $id = $p + 1;
        $newId = $prefix . str_pad($id, 4, '0', STR_PAD_LEFT);
        return $newId;
    }

    public static function checkbox($r) {
        if($r == 'on') {
            return true;
        }
    }

    public function comments()
    {
        return $this->hasMany(MemberComment::class, 'member_id', 'id');
    }

    public function prayers()
    {
        return $this->hasMany(PrayerRequest::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'member_link');
    }

    public function dependents($id) {
        return self::where('member_link', $id)->get();
    }

    public function attendances() 
    {
        return $this->hasMany(Attendance::class);
    }

    public function smsLog() 
    {
        return $this->hasMany(SmsLog::class);
    }

    public function member_report()
    {
        return $this->hasMany(MemberReport::class);
    }

    public static function getLatLong($address)
    {
        if(!empty($address))
        {
            $formattedAddr = str_replace(' ','+',$address);
            $geocodeFromAddr = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddr.'&sensor=false');
            $output = json_decode($geocodeFromAddr);
            $data['lat'] = $output->results[0]->geometry->location->lat;
            $data['lng'] = $output->results[0]->geometry->location->lng;

            if(!empty($data)){
                return $data;
            }else{
                return false;
            }
        } 
        else 
        {
        return false;
        }
    }
}
