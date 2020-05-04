<?php

namespace App\Http\Controllers;

use App\Entities\ServiceInterest;
use Illuminate\Http\Request;

class ServiceInterestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $flag = true;
        $service_types = ServiceInterest::orderby('name', 'asc')->get();
        return view('serviceType.index', compact('service_types', 'flag'));
    }

    public function store(Request $request)
    {
        ServiceInterest::create($request->all());
        return redirect()->route('servicetype');
    }

    public function edit($id)
    {
        $flag = false;
        
        $service_type = ServiceInterest::findOrFail($id);
        $service_types = ServiceInterest::orderby('name')->get();

        return view('serviceType.index', compact('service_types', 'service_type', 'flag'));
    }

    public function update(Request $request, $id)
    {
        $service_type = ServiceInterest::findOrFail($id);
        $service_type->update($request->all());
        return redirect()->route('servicetype');
    }

    public function destroy($id)
    {
        $service_type = ServiceInterest::findOrFail($id);
        $service_type->delete();
        return redirect()->route('servicetype');
    }
}
