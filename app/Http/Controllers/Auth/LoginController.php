<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{

    use AuthenticatesUsers;

  
    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'login' => 'required',
            'password' => 'required',
        ]);

        $login_type = filter_var($request->input('login'), FILTER_VALIDATE_EMAIL)
            ? 'email'
            : 'username';

        $request->merge([
            $login_type => $request->input('login')
        ]);

        $userCheck = User::where('email', $request->input('login'))->orWhere('username', $request->input('login'))->exists();

        if (!$userCheck) {
            return redirect()->back()
                ->withInput()
                ->withErrors([
                    'login' => 'Hey! User does not exist Ok.',
                ]);
        }

        if (Auth::attempt($request->only($login_type, 'password'))) {
            return redirect()->intended($this->redirectPath($this->authenticated()));
        }

        return redirect()->back()
            ->withInput()
            ->withErrors([
                'login' => 'These credentials do not match our records.',
            ]);
    }

    public function authenticated()
    {
        $user = auth()->user();

        if ($user->hasRole('super-admin') && $user->status === 1) 
        {
            return redirect()->route('home');
        } 
        elseif ($user->hasRole('church-admin') && $user->status === 1) 
        {
            return redirect()->route('home');
        } 
        elseif ($user->hasRole('followup-team') && $user->status === 1) 
        {
            return redirect()->route('home');
        }
        elseif ($user->hasRole('prayer-warrior') && $user->status === 1) 
        {
            return redirect()->route('home');
        }
        else 
        {

            Auth::logout();

            session()->flush();

            session()->regenerate();

            return redirect('/');
        }
    }
}
