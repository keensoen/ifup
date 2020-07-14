<?php

//use Str;
use Carbon\Carbon;
use App\Entities\SmsLog;
use App\Entities\Member;
use App\Entities\SmsGateway;
use App\Entities\SmsTemplate;
use Illuminate\Support\Facades\Http;

if (!function_exists('authRole')) {

    function authRole($model, $user)
    {
        $items = null;

        foreach($user->getRoleNames() as $role) {
            if($role === 'super-admin') {
                $items = $model->get();
            }
            else {
                $items = $model->whereOrganizationId(auth()->user()->organization_id)->get();
            }
        }
        return $items;
    }
}

if(!function_exists('authRoleFind')) {

    function authRoleFind($model, $user, $id)
    {
        $items = null;

        foreach($user->getRoleNames() as $role) {
            if($role === 'super-admin') {
                $items = $model->findOrFail($id);
            }
            else {
                $items = $model->whereOrganizationId(auth()->user()->organization_id)->findOrFail($id);
            }
        }
        return $items;
    }
}

if(!function_exists('authRoleFindWithSlug')) {

    function authRoleFindWithSlug($model, $user, $slug)
    {
        $items = null;

        foreach($user->getRoleNames() as $role) {
            if($role === 'super-admin') {
                $items = $model->whereSlug($slug)->first();
            }
            else {
                $items = $model->whereOrganizationId(auth()->user()->organization_id)->whereSlug($slug)->first();
            }
        }
        return $items;
    }
}

if(!function_exists('autoSendSMS')) {

    function autoSendSMS() 
    {
        $day = date('d', strtotime(Carbon::today()));
        $month = date('m', strtotime(Carbon::today()));

        $members = Member::whereDay('birthday', $day)->whereMonth('birthday', $month)->get();
        
        foreach ($members as $member) {

            $recipient = $member['tel'];

            $birthMonth = Carbon::parse($member->birthday)->format('F');
            $msg_temp = SmsTemplate::whereOrganizationId($member['organization_id'])->where('month', $birthMonth)->inRandomOrder()->select('message_temp', 'id')->first();

            $gateway = SmsGateway::whereOrganizationId($member['organization_id'])->first();

            if($gateway)
            {
                $baseurl = $gateway['url'];
                $signature = $gateway['signature'];
                $sender = $gateway['sender_id'];

                if(!is_null($msg_temp)) {
                    $message = $msg_temp['message_temp'].' '.$signature ;

                    if(!is_null($gateway['token'])) {
                        $sms_array = [
                            'sender' => $sender,
                            'to' => $recipient,
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
                            'recipient' => $recipient,
                            'message' => $message
                        ];

                        $params = http_build_query($sms_array);
                    }
                    
                    $res = curl_get_contents($baseurl, $params);
                    
                    if(Str::contains($res, 'Completed Successfully')) {
                        SmsLog::create([
                            'member_id' => $member['id'],
                            'organization_id'   => $member['organization_id'],
                            'sms_template_id'   => $msg_temp['id'],
                            'status'    => true
                        ]);
                    }
                    else{
                        SmsLog::create([
                            'member_id' => $member['id'],
                            'organization_id'   => $member['organization_id'],
                            'sms_template_id'   => $msg_temp['id'],
                            'status'    => false
                        ]);
                    }
                }
                else {
                    echo 'No Template Found';
                }
            }
        }
    }
}

if(!function_exists('sendSMSx')) {

    function sendSMSx($sender, $recipients=[], $message, $members=[]) 
    {
        //dd($recipients);
        $gateway = SmsGateway::whereOrganizationId(auth()->user()->organization_id)->first();

        if($gateway) 
        {
            $baseurl = $gateway['url'];
            $msg = $message;

            foreach ($recipients as $key => $recept) {

                if(!is_null($gateway['token'])) {
                    $sms_array = [
                        'sender' => $sender,
                        'to' => $recept,
                        'message' => $msg,
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
                        'recipient' => $recept,
                        'message' => $msg
                    ];

                    $params = http_build_query($sms_array);
                }
                
                $res = curl_get_contents($baseurl, $params);

                $member = Member::whereTel([$recept])->first();
                
                if(Str::contains($res, 'Completed Successfully')) {
                    SmsLog::create([
                        'member_id' => $member['id'],
                        'organization_id'   => $member['organization_id'],
                        'content'   => $msg,
                        'status'    => true
                    ]);
                }
                else{
                    SmsLog::create([
                        'member_id' => $member['id'],
                        'organization_id'   => $member['organization_id'],
                        'content'   => $msg,
                        'status'    => false
                    ]);
                }
            } 
        }
    }
}

if(!function_exists('sendRegistrationSMS')) {

    function sendRegistrationSMS($member, $message) 
    {
        //dd($recipients);

        $member = Member::whereId($member)->first();

        $gateway = SmsGateway::whereOrganizationId($member['organization_id'])->first();

        if($gateway)
        {
            $baseurl = $gateway['url'];
            //$sender = $gateway['sender_id'];
            $sender = $gateway['sender_id'];

            $recipient = $member['tel'];

            $msg = $message.' Welcome to '.$gateway['signature'];

            if(!is_null($gateway['token'])) {
                $sms_array = [
                    'sender' => $sender,
                    'to' => $recipient,
                    'message' => $msg,
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
                    'recipient' => $recipient,
                    'message' => $msg
                ];

                $params = http_build_query($sms_array);
            }
            
            
            $res = curl_get_contents($baseurl, $params);
            
            if(Str::contains($res, 'Completed Successfully')) {
                SmsLog::create([
                    'member_id' => $member['id'],
                    'organization_id'   => $member['organization_id'],
                    'content'   => $msg,
                    'status'    => true
                ]);
            }
            else{
                SmsLog::create([
                    'member_id' => $member['id'],
                    'organization_id'   => $member['organization_id'],
                    'content'   => $msg,
                    'status'    => false
                ]);
            }
        }
    }
}

if(!function_exists('resendSMS')) {

    function resendSMS($id, $date=null) 
    {

        $member = Member::whereId($id)->first();

        $gateway = SmsGateway::whereOrganizationId($member['organization_id'])->first();

        $baseurl = $gateway['url'];
        //$sender = $gateway['sender_id'];
        $sender = 'eFellowUP'; // $gateway['sender_id'];
        $recipient = $member['tel'];


        $msg = null;
        $params = null;
        $createDate = $date;

        $message = SmsLog::whereMember_id($member['id'])->whereDate('created_at', '=', $createDate)->first();

        if(is_null($message['sms_template_id'])) {
            $msg = $message['content'];
        }
        else {
            $msg = SmsTemplate::whereSmsTemplateId($message['sms_template_id'])->pluck('msg_temp')->first();
        }
        
        $msgz = $msg;

        if(!is_null($gateway['token'])) {
            $sms_array = [
                'sender' => $sender,
                'to' => $recipient,
                'message' => $msgz,
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
                'recipient' => $recipient,
                'message' => $msgz
            ];

            $params = http_build_query($sms_array);
        }
        
        
        $res = curl_get_contents($baseurl, $params);
        
        if(Str::contains($res, 'Completed Successfully')){
            $message->status = true;
            $message->save();
        }
        
    }
}

if(!function_exists('sendSmsPost')) {

    function sendSmsPost()
    {
        $message = 'Test message';
        $senderid = 'eFellowUP';
        $to = '07034608345';
        $token = 'ZGFuc2VzdTpkYW5zZXN1Z2g=';
        $baseurl = 'https://bulksms247.com/sms/api?action=send-sms&';

        $sms_array = array 
        (
        'api_key' => $token,
        'to' => $to,
        'from' => $senderid,
        'sms' => $message
        );

        $params = http_build_query($sms_array);
        $ch = curl_init(); 

        curl_setopt($ch, CURLOPT_URL,$baseurl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        $response = curl_exec($ch);

        curl_close($ch);

        echo $response;
    }
}

if(!function_exists('sendSmsGet')) {

    function sendSmsGet()
    {
        $message = urlencode('Test message');
        $senderid = urlencode('keensoen');
        $to = '2347034608345';
        $token = 'LLaOCtzf1dfndnDPQ5c1latmZ2aZ3RzZkCOnTqIV00wO4xuumh56mUpTZW84wZn0NERgc5qvUWPads2Reqv7h3XIPKgjbuAAY2qn';
        $routing = 3;
        $type = 0;
        $baseurl = 'https://smartsmssolutions.com/api/json.php?';
        $sendsms = $baseurl.'message='.$message.'&to='.$to.'&sender='.$senderid.'&type='.$type.'&routing='.$routing.'&token='.$token;

        $response = file_get_contents($sendsms);

        echo $response;

    }
}

if(!function_exists('curl_get_contents')) {
    function curl_get_contents($baseurl, $params)
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