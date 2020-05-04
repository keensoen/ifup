<?php

namespace App\Http\Controllers;

use App\Entities\MemberGroup;
use Illuminate\Http\Request;

class MemberGroupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $flag = true;
        $model = MemberGroup::orderby('name', 'asc');
        $member_groups = authRole($model, auth()->user());

        return view('member.memberGroup', compact('member_groups', 'flag'));
    }

    public function store(Request $request)
    {
        $input = $request->all();
        
        $input['organization_id'] = auth()->user()->organization_id;

        MemberGroup::create($input);

        return redirect()->route('memberGroup');
    }

    public function edit($id)
    {
        $flag = false;
        
        $modelFind = MemberGroup::orderBy('name', 'asc');
        $member_group = authRoleFind($modelFind, auth()->user(), $id);

        $model = MemberGroup::orderby('name', 'asc');
        $member_groups = authRole($model, auth()->user());

        return view('member.memberGroup', compact('member_groups', 'member_group', 'flag'));
    }

    public function update(Request $request, $id)
    {
        $modelFind = MemberGroup::orderBy('name', 'asc');
        $member_group = authRoleFind($modelFind, auth()->user(), $id);

        $member_group->update($request->all());

        return redirect()->route('memberGroup');
    }

    public function destroy($id)
    {
        $modelFind = MemberGroup::orderBy('name', 'asc');
        $member_group = authRoleFind($modelFind, auth()->user(), $id);

        $member_group->delete();

        return redirect()->route('memberGroup');
    }
}
