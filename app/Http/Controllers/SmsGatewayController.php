<?php

namespace App\Http\Controllers;

use App\Entities\SmsGateway;
use App\Entities\Organization;
use Illuminate\Http\Request;

class SmsGatewayController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $flag = true;
        $model = SmsGateway::orderBy('created_at', 'desc');
        $gateways = authRole($model, auth()->user());

        if(auth()->user()->hasRole('super-admin')) {
            $organization = Organization::pluck('parish', 'id')->all();
        }
        else {
            $organization = Organization::whereId(auth()->user()->organization_id)->pluck('parish', 'id')->all();
        }
        
        return view('general.gateway', compact('gateways', 'organization', 'flag'));
    }

    public function store(Request $request)
    {
        $input = $request->all();

        SmsGateway::create($input);

        return redirect()->route('gateway');
    }

    public function edit($id)
    {
        $flag = false;
        
        $gateway = SmsGateway::findOrFail($id);

        $model = SmsGateway::orderBy('created_at', 'desc');
        $gateways = authRole($model, auth()->user());

        $organization = Organization::pluck('parish', 'id')->all();

        return view('general.gateway', compact('gateways', 'gateway', 'organization', 'flag'));
    }

    public function update(Request $request, $id)
    {
        $gateway = SmsGateway::findOrFail($id);
        $gateway->update($request->all());
        return redirect()->route('gateway');
    }

    public function destroy($id)
    {
        $gateway = SmsGateway::whereOrganizationId(auth()->user()->organization_id)->findOrFail($id);
        $gateway->delete();
        return redirect()->route('gateway');
    }
}
