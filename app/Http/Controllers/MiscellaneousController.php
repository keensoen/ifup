<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\Member;
use App\Entities\PrayerRequest;

class MiscellaneousController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function prayerRoom(Request $request) 
    {
        $model = Member::orderBy('created_at', 'asc');
        $members = authRole($model, auth()->user());
        //$prayers = PrayerRequest::
        return view('general.prayer_room', compact($members));
    }
}
