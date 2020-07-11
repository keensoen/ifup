<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Entities\Attendance;
use App\Entities\PrayerRequest;
use App\Entities\MemberComment;
use App\Entities\Feedback;
use App\Entities\Member;
use Carbon\Carbon;
use App\User;
use DB;
use App\Http\Resources\AttendanceResource;
use Symfony\Component\HttpFoundation\Response;

class AppController extends Controller
{
	CONST HTTP_OK = Response::HTTP_OK;
    CONST HTTP_CREATED = Response::HTTP_CREATED;
    CONST HTTP_UNAUTHORIZED = Response::HTTP_UNAUTHORIZED;

    public function __construct() 
    {
    	$this->middleware('auth:api');
    }

    public function getMembers() 
    {
    	$user = auth()->user();
    	$today = Carbon::today();
    	$to = date('Y-m-d', strtotime($today));
    	$from = date('Y-m-d', strtotime($today->subDays(7)));
    	$startOfWeek = $today->startOfWeek();

    	if($user){

    		$member = Member::orderBy('first_name', 'asc')->whereMemberLink($user->member_id)->get();
    		$members = DB::table('members')->orderBy('first_name', 'asc')->select(
    				'members.id',
    				'members.slug',
    				'members.tel',
    				'members.birthday',
    				'members.photo',
    				DB::raw('concat(members.surname," ",members.first_name," ",members.middle_name) as fullname'),
    				DB::raw('concat(members.surname," ",members.first_name) as name')
    			)->whereMemberLink($user->member_id)->get();

	    	$attendance = Member::whereDoesntHave('attendances', function($q) use($to, $from) {
	    		$q->whereDate('attendances.created_at', '<=', $to)->whereDate('attendances.created_at','>=',$from);
	    	})->whereMemberLink($user->member_id)->get(['members.id', 'members.slug', 'members.tel', 'members.birthday', 'members.photo', 'members.address', 'members.first_name', 'members.middle_name', 'members.surname']);

	    	// $attend = Member::whereDoesntHave('attendances', function(Builder $query) use($to, $from) {
	    	// 	$query->whereBetween('created_at', [$to, $from]);
	    	// })->whereMemberLink($user->member_id)->get();

	    	// $attends = Member::whereExists(function($query) use($to, $from) {
	    	// 	$query->select(DB::raw(1))->from('attendances')->whereRaW('attendances.member_id = members.id');
	    	// })->whereMemberLink($user->member_id)->get();

	    	// $att = DB::table('members')
	    	// 	->join('attendances', 'attendances.member_id', '=', 'members.id')
	    	// 	->whereDate('attendances.created_at', '<=', $to)->whereDate('attendances.created_at','>=',$from)
	    	// 	->where('members.member_link', $user->member_id)
	    	// 	->get();

	    	//$members = new AttendanceResource($member);
	    	// $attendances = new AttendanceResource($attendance);

	 		$response = self::HTTP_OK;

	 		return $this->get_http_response('success', ['members' => $members, 'absentees' => $attendance], $response);
    	}
    	else{

    		
    		$error = "Unauthorized Access";

        	$response = self::HTTP_UNAUTHORIZED;

    		return $this->get_http_response('Error', $error, $response);
    	}
    }

    public function getPrayers(Request $request) 
    {
    	$user = auth()->user();
    	$today = Carbon::today();
    	$to = date('Y-m-d', strtotime($today));
    	$from = date('Y-m-d', strtotime($today->subDays(7)));
    	$startOfWeek = $today->startOfWeek();

    	if($user){

    		$prayers = PrayerRequest::orderBy('created_at', 'desc')
    			//->whereDate('created_at', '<=', $to)->whereDate('created_at','>=',$from)
    			->whereMemberId($user->member_id)->get(['id', 'prayer_point', 'attended_to', 'created_at']);

    		$response = self::HTTP_OK;

	 		return $this->get_http_response('success', $prayers, $response);
    	}
    	else{
    		
    		$error = "Unauthorized Access";

        	$response = self::HTTP_UNAUTHORIZED;

    		$this->get_http_response('Error', $error, $response);
    	}
    }

    public function getFeedback(Request $request) 
    {
    	$user = auth()->user();
    	$today = Carbon::today();
    	$to = date('Y-m-d', strtotime($today));
    	$from = date('Y-m-d', strtotime($today->subDays(7)));
    	$startOfWeek = $today->startOfWeek();

    	if($user){

    		$feedback = MemberComment::orderBy('created_at', 'desc')
    			//->whereDate('created_at', '<=', $to)->whereDate('created_at','>=',$from)
    			->whereMemberId($user->member_id)->get(['id', 'comment', 'created_at']);
    		$response = self::HTTP_OK;

	 		return $this->get_http_response('success', $feedback, $response);
    	}
    	else{
    		
    		$error = "Unauthorized Access";

        	$response = self::HTTP_UNAUTHORIZED;

    		return $this->get_http_response('Error', $error, $response);
    	}
    }

    public function markAttendance(Request $request) 
    {
    	$user = auth()->user();
    	$today = date('Y-m-d', strtotime(Carbon::today()));

    	if($user){

    		$member = Member::whereSlug($request->slug)->first();
    		$checkAlreadyMarked = Attendance::whereMemberId($member->id)->whereDate('created_at', '=', $today)->exists();

    		if($member && !$checkAlreadyMarked) {

    			$present = new Attendance;
    			$present->member_id = $member->id;
    			$present->organization_id = $member->organization_id;
    			$present->latitude = $request->latitude;
    			$present->longitude = $request->longitude;
    			$present->clock_in = now();
    			$present->mark_by = $user->id;
    			$present->save();

    			$response = self::HTTP_OK;
    			$msg = 'Marked Present. Thank you!';

	 			return $this->get_http_response('success', $msg, $response);
    		}
    		elseif ($checkAlreadyMarked) {
    			$error = 'Already marked Present. Thank you!';
	 			return $this->get_http_response('Error', $error, 400);
    		}
    		else {
    			$error = 'Unable to mark present. Please try again';
	 			return $this->get_http_response('Error', $error, 400);
    		}
    	}
    	else{
    		
    		$error = "Unauthorized Access";

        	$response = self::HTTP_UNAUTHORIZED;

    		return $this->get_http_response('Error', $error, $response);
    	}
    }

    public function storeToken(Request $request) 
    {
    	$user = auth()->user();
    	if($user) {
    		$user->device_token = $request->dToken;
    		$store = $user->save();

    		if($store) {
    			$response = self::HTTP_OK;
    			$msg = 'Device Token saved. Thank you!';

	 			return $this->get_http_response('success', $msg, $response);
    		}
    		else {
    			$error = 'Unable to store Token. Please try again';
	 			return $this->get_http_response('Error', $error, 400);
    		}
    	}
    	else{
    		
    		$error = "Unauthorized Access";

        	$response = self::HTTP_UNAUTHORIZED;

    		return $this->get_http_response('Error', $error, $response);
    	}
    }

    public function get_http_response( string $status = null, $data = null, $response ){

        return response()->json(
            [
                'status'    => $status,
                'data'  =>  $data
            ], 
            $response
        );
    }
}
