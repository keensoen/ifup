<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Entities\Member;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Entities\Organization;
use Str;
use Arr;
use DB;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $flag = true;
        $model = User::orderBy('created_at', 'desc');
        $users = authRole($model, auth()->user());

        $roles = [];
        $members = [];

        $modelMember = Member::orderBy('created_at', 'desc');
        foreach(authRole($modelMember, auth()->user()) as $m) {
            $members[$m->id] = Str::upper($m->fullname);
        }

        foreach (auth()->user()->getRoleNames() as $key => $rol) {
            if($rol == 'super-admin') {
                foreach(Role::get() as $r) {
                    $roles[$r->id] = Str::upper($r->name);
                }
            }
            else {
                foreach(Role::where('name', '<>', 'super-admin')->get() as $r) {
                    $roles[$r->id] = Str::upper($r->name);
                }
            }
        }
        
        $organizations = Organization::whereId(auth()->user()->organization_id)->pluck('parish', 'id')->all();

        return view('user.index', compact('users', 'organizations', 'roles', 'members', 'flag'));
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $userData = Arr::except($input, ['role']);

        $userData['password'] = bcrypt($request->get('password'));
        $user = User::create($userData);

        $user->assignRole($input['role']);

        return redirect()->route('user');
    }

    public function edit($id)
    {
        $flag = false;
        
        $user = User::findOrFail($id);
        $model = User::orderBy('created_at', 'desc');
        $users = authRole($model, auth()->user());

        $roles = [];
        $members = [];

        $modelMember = Member::orderBy('created_at', 'desc');
        foreach(authRole($modelMember, auth()->user()) as $m) {
            $members[$m->id] = Str::upper($m->fullname);
        }

        foreach (auth()->user()->getRoleNames() as $key => $rol) {
            if($rol == 'super-admin') {
                foreach(Role::get() as $r) {
                    $roles[$r->id] = Str::upper($r->name);
                }
            }
            else {
                foreach(Role::where('name', '<>', 'super-admin')->get() as $r) {
                    $roles[$r->id] = Str::upper($r->name);
                }
            }
        }

        $organizations = Organization::whereId(auth()->user()->organization_id)->pluck('parish', 'id')->all();

        return view('user.index', compact('users', 'organizations', 'user', 'roles', 'members', 'flag'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $input = $request->all();

        $userData = Arr::except($input, ['role', 'password']);
        $userData['password'] = Hash::make($request->get('password'));
        $user->update($userData);

        $uCheck = DB::table('model_has_roles')->whereModelId($user->id)->first();
        //dd($uCheck->model_id);
        if($uCheck) {
            DB::table('model_has_roles')->where('model_id', '=', $uCheck->model_id)->update([
                'role_id' => $input['role']
            ]);
        }else{
            $user->assignRole($input['role']);
        }

        return redirect()->route('user');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('user');
    }
}
