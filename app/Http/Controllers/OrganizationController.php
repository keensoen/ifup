<?php

namespace App\Http\Controllers;

use Str;
use Image;
use App\Entities\Organization;
use Illuminate\Http\Request;
use App\Http\Requests\OrganizationCreateRequest;

class OrganizationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $flag = true;
        $model = Organization::orderBy('parish');
        $organizations = Organization::authRole($model, auth()->user());
        return view('general.organization', compact('organizations', 'flag'));
    }

    public function store(OrganizationCreateRequest $request)
    {
        foreach (auth()->user()->getRoleNames() as $role) {
            if(!$role == 'super-admin'){
                abort(403);
            }
            else {
                $input = $request->all();

                if($files = $request->file('logo')) {
                    $imageUpload = Image::make($files);
                    $imagePath = public_path('img/organizations/');
                    $imageUpload->resize(120,120);
                    $imageUpload->save($imagePath.time().'-'.Str::slug($input['parish']).'.'.$files->getClientOriginalExtension());
        
                    $input['logo'] = 'img/organizations/'.time().'-'.Str::slug($input['parish']).'.'.$files->getClientOriginalExtension();
                }
        
                $input['code'] = Organization::code();
        
                Organization::create($input);
            }
        }

        return redirect()->route('organization');
    }

    public function edit($id)
    {
        $flag = false;
        
        $model = Organization::orderBy('parish');
        $organization = Organization::whereId(auth()->user()->organization_id)->findOrFail($id);
        $organizations = Organization::authRole($model, auth()->user());

        return view('general.organization', compact('organizations', 'organization', 'flag'));
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();

        $organization = Organization::whereId(auth()->user()->organization_id)->findOrFail($id);

        if($files = $request->file('logo')) {
            $imageUpload = Image::make($files);
            $imagePath = public_path('img/organizations/');
            $imageUpload->resize(120,120);
            $imageUpload->save($imagePath.time().'-'.Str::slug($input['parish']).'.'.$files->getClientOriginalExtension());

            $input['logo'] = 'img/organizations/'.time().'-'.Str::slug($input['parish']).'.'.$files->getClientOriginalExtension();
        }

        $organization->update($input);

        return redirect()->route('organization');
    }

    public function destroy($id)
    {
        $organization = Organization::whereId(auth()->user()->organization_id)->findOrFail($id);
        $organization->delete();
        return redirect()->route('organization');
    }
}
