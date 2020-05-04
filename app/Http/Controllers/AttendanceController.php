<?php

namespace App\Http\Controllers;

use App\Entities\Attendance;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $today = date('Y-m-d', strtotime(Carbon::today()));
        $week = date('Y-m-d', strtotime(Carbon::today()->subDays(7)));

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
        
        $model = Attendance::orderBy('created_at', 'asc')->whereDate('created_at', '>=', $date_from)->whereDate('created_at', '<=', $date_to);
        $attendances = authRole($model, auth()->user());
        
        return view('member.attendance', compact('attendances'));
    }
}
