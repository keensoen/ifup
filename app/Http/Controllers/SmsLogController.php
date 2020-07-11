<?php

namespace App\Http\Controllers;

use Str;
use App\Entities\SmsLog;
use Illuminate\Http\Request;
use App\Entities\Member;
use App\Entities\Organization;
use App\Entities\NonMemberSmsLog;
use App\Entities\SmsGateway;
use App\Entities\MemberGroup;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class SmsLogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $today = date('Y-m-d', strtotime(Carbon::today()));
        //$week = date('Y-m-d', strtotime(Carbon::today()->subDays(7)));

        $members = [];
        $member_groups = [];

        $modelMember = Member::orderBy('created_at', 'desc');
        $modelMemberGroup = MemberGroup::orderBy('name', 'asc');

        foreach(authRole($modelMember, auth()->user()) as $m) {
            $members[$m->tel] = Str::upper($m->fullname);
        }

        foreach(authRole($modelMemberGroup, auth()->user()) as $m) {
            $member_groups[$m->id] = Str::upper($m->name);
        }

        $modelLog = SmsLog::orderBy('created_at', 'desc')->whereDate('created_at', $today);
        $recentLogs = authRole($modelLog, auth()->user());
        //dd($recentLogs);

        return view('general.send_sms', compact('recentLogs', 'members', 'member_groups'));
    }

    public function sendSMS(Request $request)
    {
        $recipient = null;
        
        $gateway = SmsGateway::whereId(auth()->user()->organization_id)->first();

        if($gateway) 
        {
            $signature = $gateway['signature'];
            $sender = $gateway['sender_id'];
            $message = $request->get('message').'. '.$signature;

            if($request->get('recipient_check') == 'all') {

                if(auth()->user()->hasRole('supper-admin'))
                {
                    $recipient = Member::pluck('tel')->all();
                    $sender = 'SuperAdmin';
                    
                    $sms = sendSMSx($sender, $recipient, $message);
                    
                    if($ms) {
                        return redirect()->back()->with(['success' => 'Thank you! message has been sent successfully']);
                    }
                    else {
                        return redirect()->back()->with(['error' => 'Thank you! message could not sent successfully']);
                    }     
                }
                else {
                    $recipient = Member::whereOrganizationId(auth()->user()->organization_id)->pluck('tel')->all();
                    $sms = sendSMSx($sender, $recipient, $message);
                    
                    if($ms) {
                        return redirect()->back()->with(['success' => 'Thank you! message has been sent successfully']);
                    }
                    else {
                        return redirect()->back()->with(['error' => 'Thank you! message could not sent successfully']);
                    }
                }
            }
            elseif($request->get('recipient_check') == 'member_list') {
                $recipient = $request->recipient;

                $sms = sendSMSx($sender, $recipient, $message);
                    
                if($sms) {
                    return redirect()->back()->with(['success' => 'Thank you! message has been sent successfully']);
                }
                else {
                    return redirect()->back()->with(['error' => 'Thank you! message could not sent successfully']);
                }
            }
            elseif($request->get('recipient_check') == 'custom'){
                
                $recipient = $request->manaul_recipient;
                $baseurl = $gateway['url'];
                $recepts = Str::of($recipient)->explode(',');
                $response = null;

                try {
                    foreach ($recepts as $key => $number) {

                        if(!is_null($gateway['token'])) {
                            $sms_array = [
                                'sender' => $sender,
                                'to' => $number,
                                'message' => $message,
                                'type' => $gateway['type'],
                                'routing' => $gateway['routing'],
                                'token' => $gateway['token']
                            ];
                            $params = http_build_query($sms_array);
                        }
                        else{
                            $username = $gateway['username'];
                            $password = $gateway['password'];

                            $sms_array = [
                                'username' => $username,
                                'password' => $password,
                                'sender' => $sender,
                                'recipient' => $number,
                                'message' => $message
                            ];

                            $params = http_build_query($sms_array);
                        }
                        
                        $res = $this->curl_get_contents($baseurl, $params);
                        
                        if(Str::contains($res, 'Completed Successfully')) {
                            NonMemberSmsLog::create([
                                'organization_id'   => auth()->user()->organization_id,
                                'number'    => $number,
                                'content'   => $message,
                                'user_id'   => auth()->user()->id,
                                'status'    => true
                            ]);
                        }
                        else{
                            NonMemberSmsLog::create([
                                'organization_id'   => auth()->user()->organization_id,
                                'number'    => $number,
                                'content'   => $message,
                                'user_id'   => auth()->user()->id,
                                'status'    => false
                            ]);
                        }
                    }

                    return redirect()->back()->with(['success' => 'Thank you! message has been sent successfully']);
                } catch (Throwable $e) {
                    echo $e;

                    return redirect()->back()->with(['error' => 'Thank you! message has been sent successfully']);
                }

            }
            elseif($request->get('recipient_check') == 'member_group') {
                $contactsFetch = $request->recipient;

                $recipient = Member::whereMemberGroupId([$contactsFetch])->pluck('tel')->all();

                $sms = sendSMSx($sender, $recipient, $message);
                    
                if($sms) {
                    return redirect()->back()->with(['success' => 'Thank you! message has been sent successfully']);
                }
                else {
                    return redirect()->back()->with(['error' => 'Thank you! message could not sent successfully']);
                }
            }
            else {
                return redirect()->back();
            }
        }
        else{
            return redirect()->back()->with(['error' => 'Gateway Error' ]);
        }
    }

    public function sentSMS(Request $request)
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

        $modelLog = SmsLog::orderBy('created_at', 'desc')->whereStatus(true)
                ->whereDate('created_at', '>=', $date_from)->whereDate('created_at', '<=', $date_to);
        $logs = authRole($modelLog, auth()->user());

        return view('general.sent_sms', compact('logs'));
    }

    public function failedSMS(Request $request)
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

        $modelLog = SmsLog::orderBy('created_at', 'desc')->whereStatus(false)
            ->whereDate('created_at', '>=', $date_from)->whereDate('created_at', '<=', $date_to);

        $logs = authRole($modelLog, auth()->user());

        return view('general.failed_sms', compact('logs'));
    }

    public function externalSMS(Request $request)
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

        $modelLog = null;

        if(!is_null($request->status)) 
        {
            $modelLog = NonMemberSmsLog::orderBy('created_at', 'desc')->whereDate('created_at', '>=', $date_from)->whereDate('created_at', '<=', $date_to)->where('status', $request->status);
        }
        else {
            $modelLog = NonMemberSmsLog::orderBy('created_at', 'desc')->whereDate('created_at', '>=', $date_from)->whereDate('created_at', '<=', $date_to);
        }

        $logs = authRole($modelLog, auth()->user());
        
        
        return view('general.external_sms', compact('logs'));
    }

    public function resendSMS() 
    {
        $member = request()->get('member');
        $date = request()->get('date');
        resendSMS($member, $date);

        return redirect()->back();
    }

    public function curl_get_contents($baseurl, $params)
    {

        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL,$baseurl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        $response = curl_exec($ch);

        curl_close($ch);

        return $response;
    }
}
