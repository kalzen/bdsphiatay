<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    public function submitLogin() {
        if (\Illuminate\Support\Facades\Auth::attempt(['email' => request('username'), 'password' => request('password')])||
        \Illuminate\Support\Facades\Auth::attempt(['username' => request('username'), 'password' => request('password')])) {
            if (auth()->user()->type == \App\Models\User::TYPE_SUPER_ADMIN ||
            auth()->user()->type == \App\Models\User::TYPE_EDITOR) {
                return response()->json(['success'=>true,'redirect'=>'/admin']);
            }
            return response()->json(['success'=>true,'redirect'=>'/profile/edit']);
        }
        return response()->json(['success'=>false]);
    }
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
