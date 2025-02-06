<?php

namespace App\Http\Controllers\Auth;

use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SocialController extends Controller
{
    public function redirectFacebook() {
        return Socialite::driver('facebook')->redirect();
    }
    public function callbackFacebook() {
        $facebookUser = Socialite::driver('facebook')->user();
    
        $user = User::where('facebook_id', $facebookUser->id)->first();
    
        if ($user) {
            $user->update([
                'avatar' => $facebookUser->getAvatar(),
                'facebook_token' => $facebookUser->token,
                'facebook_refresh_token' => $facebookUser->refreshToken,
            ]);
        } else {
            $user = User::create([
                'avatar' => $facebookUser->getAvatar(),
                'password' => bcrypt('123456789'),
                'name' => $facebookUser->name,
                'username' => $facebookUser->email ?: ($facebookUser->id.'@facebook.com'),
                'email' => $facebookUser->email ?: ($facebookUser->id.'@facebook.com'),
                'facebook_id' => $facebookUser->id,
                'facebook_token' => $facebookUser->token,
                'facebook_refresh_token' => $facebookUser->refreshToken,
            ]);
        }
    
        Auth::login($user);
    
        return redirect('/home');
    }
}
