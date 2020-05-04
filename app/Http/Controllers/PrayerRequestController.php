<?php

namespace App\Http\Controllers;

use DB;
use Carbon\Carbon;
use App\Entities\Member;
use App\Entities\PrayerRequest;
use Illuminate\Http\Request;

class PrayerRequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
 
    public function index(Request $request)
    {
        if (isset($request->date_filter)) {
            $parts = explode(' - ', $request->date_filter);
            $date_from = $parts[0];
            $date_to = $parts[1];
        } else {
            $carbon_date_from = Carbon::now()->subDays(6);
            $date_from = $carbon_date_from->toDateString();
            $carbon_date_to = Carbon::now();
            $date_to = $carbon_date_to->toDateString();
        }

        $model = PrayerRequest::orderBy('attended_to', 'asc')->whereDate('created_at', '>=', $date_from)->whereDate('created_at', '<=', $date_to);
        $prayer_requests = authRole($model, auth()->user());
        
        return view('member.prayer', compact('prayer_requests'));
    }

    public function clearPrayer($id)
    {
        $model = PrayerRequest::orderBy('created_at', 'asc');
        $prayer_requests = authRoleFind($model, auth()->user(), $id);

        $prayer_requests->user_id = auth()->user()->id;
        $prayer_requests->attended_to = true;

        DB::transaction(function() use($prayer_requests){
            $prayer_requests->save();
        });
        
        return redirect()->route('prayer_request');
    }
}
