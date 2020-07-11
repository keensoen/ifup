<?php

namespace App\Http\Controllers;

use App\Entities\Salutation;
use Illuminate\Http\Request;

class SalutationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $flag = true;
        $salutations = Salutation::orderby('title')->get();
        return view('salutations.index', compact('salutations', 'flag'));
    }


    public function store(Request $request)
    {
        Salutation::create($request->all());
        return redirect()->route('salutes');
    }

    public function edit($id)
    {
        $flag = false;
        
        $salutation = Salutation::findOrFail($id);
        $salutations = Salutation::orderby('title')->get();

        return view('salutations.index', compact('salutations', 'salutation', 'flag'));
    }

    public function update(Request $request, $id)
    {
        $salutation = Salutation::findOrFail($id);
        $salutation->update($request->all());
        return redirect()->route('salutes');
    }

    public function destroy(Salutation $salutation)
    {
        $salutation = Salutation::findOrFail($salutation);
        $salutation->delete();
        return redirect()->route('salutes');
    }
}
