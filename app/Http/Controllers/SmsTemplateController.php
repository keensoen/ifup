<?php

namespace App\Http\Controllers;

use App\Entities\SmsTemplate;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SmsTemplateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $flag = true;
        $model = SmsTemplate::orderBy('created_at', 'desc');
        $templates = authRole($model, auth()->user());

        return view('general.sms_temp', compact('templates', 'flag'));
    }


    public function store(Request $request)
    {
        SmsTemplate::create([
            'organization_id' => auth()->user()->organization_id,
            'month' => Carbon::parse($request->month)->format('F'),
            'month_number' => Carbon::parse($request->month)->format('j'),
            'year' => Carbon::parse($request->month)->format('Y'),
            'message_temp' => $request->message_temp,
            'user_id' => auth()->user()->id
        ]);

        return redirect()->route('templates.index');
    }

    public function show($id)
    {

        $model = SmsTemplate::orderBy('created_at', 'asc');
        $template = authRoleFind($model, auth()->user(), $id);

        return view('general.sms_detail', compact('template'));
    }

    public function edit($id)
    {
        $flag = false;
        
        $modelFinder = SmsTemplate::orderBy('created_at', 'asc');
        $template = authRoleFind($modelFinder, auth()->user(), $id);

        $model = SmsTemplate::orderBy('created_at', 'desc');
        $templates = authRole($model, auth()->user());

        return view('general.sms_temp', compact('templates', 'template', 'flag'));
    }

    public function update(Request $request, $id)
    {
        $template = SmsTemplate::whereOrganizationId(auth()->user()->organization_id)->findOrFail($id);
        $template->update([
            'month' => Carbon::parse($request->month)->format('F'),
            'month_number' => Carbon::parse($request->month)->format('j'),
            'year' => Carbon::parse($request->month)->format('Y'),
            'message_temp' => $request->message_temp,
            'user_id' => auth()->user()->id
        ]);

        return redirect()->route('templates.index');
    }

    public function destroy(SmsTemplate $template)
    {
        $temp = SmsTemplate::findOrFail($template);
        $temp->delete();
        return redirect()->route('templates.index');
    }
}
