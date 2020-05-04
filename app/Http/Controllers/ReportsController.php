<?php

namespace App\Http\Controllers;

use DB;
use Carbon\Carbon;
use App\Entities\Member;
use App\Entities\Attendance;
use Illuminate\Http\Request;
use App\Entities\PrayerRequest;
use App\Entities\ServiceInterest;
use App\Entities\MemberComment;

class ReportsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function birthReport(Request $request)
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

        $model = Member::orderBy('birthday', 'desc')->whereDate('created_at', '>=', $date_from)->whereDate('created_at', '<=', $date_to);
        $members = authRole($model, auth()->user());

        return view('report.member.birthday', compact('members'));
    }

    public function newResident(Request $request)
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

        $model = Member::orderBy('created_at', 'desc')->where('new_resident', true)->whereDate('created_at', '>=', $date_from)->whereDate('created_at', '<=', $date_to);
        $members = authRole($model, auth()->user());

        return view('report.member.new_resident', compact('members'));
    }

    public function notBaptized(Request $request)
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

        $model = Member::orderBy('birthday', 'desc')->where('baptized', false)->whereDate('created_at', '>=', $date_from)->whereDate('created_at', '<=', $date_to);
        $members = authRole($model, auth()->user());

        return view('report.member.not_baptized', compact('members'));
    }

    public function serviceType(Request $request)
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

        $serviceTypes = null;

        foreach(ServiceInterest::get() as $key => $val ){
            $serviceTypes[$val['id']] = $val['name'];
        }

        if(!is_null($request->service_type)) {
             $model = Member::orderBy('created_at', 'desc')->whereDate('created_at', '>=', $date_from)->whereDate('created_at', '<=', $date_to)->whereServiceInterestId($request->service_type);
        }
        else{
             $model = Member::orderBy('created_at', 'desc')->whereDate('created_at', '>=', $date_from)->whereDate('created_at', '<=', $date_to);
         }

        $members = authRole($model, auth()->user());

        return view('report.member.service_type', compact('members', 'serviceTypes'));
    }

    public function memberContact(Request $request)
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

        $model = Member::orderBy('created_at', 'desc')->whereDate('created_at', '>=', $date_from)->whereDate('created_at', '<=', $date_to);
        $members = authRole($model, auth()->user());

        return view('report.member.contact', compact('members'));
    }

    public function workforce(Request $request)
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

        $model = Member::orderBy('created_at', 'desc')->where('workforce_interest', true)->whereDate('created_at', '>=', $date_from)->whereDate('created_at', '<=', $date_to);
        $members = authRole($model, auth()->user());

        return view('report.member.workforce', compact('members'));
    }

    public function membership(Request $request)
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

        $model = Member::orderBy('created_at', 'desc')->where('membership_interest', true)->whereDate('created_at', '>=', $date_from)->whereDate('created_at', '<=', $date_to);
        $members = authRole($model, auth()->user());

        return view('report.member.membership', compact('members'));
    }

    public function likeVisit(Request $request) 
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

        $model = Member::orderBy('created_at', 'desc')->where('like_visited', true)->whereDate('created_at', '>=', $date_from)->whereDate('created_at', '<=', $date_to);
        $members = authRole($model, auth()->user());

        return view('report.member.like_visit', compact('members'));
    }

    public function prayerAnalysis(Request $request)
    {
        $prayerData = null;
        $month = date('m', strtotime(Carbon::today()));

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


        $prayerQuery = PrayerRequest::whereMonth('created_at', $month)->whereDate('created_at', '>=', $date_from)->whereDate('created_at', '<=', $date_to);

        if(auth()->user()->hasRole('super-admin')) {

            foreach ($prayerQuery->get(['prayer_point'])  as $key => $item) {
                $prayerData .= $item->prayer_point.' ';
            }

            $prayers = $prayerQuery->get();
        }
        else {
          
            foreach($prayerQuery->whereOrganizationId(auth()->user()->organization_id)->get(['prayer_point']) as $item) {
                $prayerData .= $item->prayer_point.' ';
            }

            $prayers = $prayerQuery->whereOrganizationId(auth()->user()->organization_id)->get();
        }

        return view('report.analysis.prayerana', compact('prayerData', 'prayers'));
    }

    public function feedbackAnalysis(Request $request)
    {
        $commentData = null;
        $month = date('m', strtotime(Carbon::today()));

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

        $commentQuery = MemberComment::whereMonth('created_at', $month)->whereDate('created_at', '>=', $date_from)->whereDate('created_at', '<=', $date_to);

        if(auth()->user()->hasRole('super-admin')) {

            foreach ($commentQuery->get(['comment']) as $key => $item) {
                $commentData .= $item->comment.' ';
            }

            $comments = $commentQuery->get();
        }
        else {
           
            foreach($commentQuery->whereOrganizationId(auth()->user()->organization_id)->get(['comment']) as $item) {
                $commentData .= $item->comment.' ';
            }

            $comments = $commentQuery->whereOrganizationId(auth()->user()->organization_id)->get();
        }

        return view('report.analysis.feedback', compact('commentData', 'comments'));
    }

    public function presentMember(Request $request)
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

        $model = Attendance::orderBy('created_at', 'desc')->whereDate('created_at', '>=', $date_from)->whereDate('created_at', '<=', $date_to);

        $attendances = authRole($model, auth()->user());

        return view('report.attendance.present', compact('attendances'));
    }

    public function absentMember(Request $request)
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

        $model = Member::whereDoesntHave('attendances', function($q) use($date_to, $date_from) {
            $q->orderBy('created_at', 'desc')->whereDate('attendances.created_at', '>=', $date_from)->whereDate('attendances.created_at', '<=', $date_to);
        });

        $members = authRole($model, auth()->user());

        return view('report.attendance.absent', compact('members'));
    }
}
