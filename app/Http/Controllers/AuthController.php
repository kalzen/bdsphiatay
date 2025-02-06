<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Store;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        if ($request->otp) {
            $exists = User::where('username',$request->username)->first();
            if ($exists && $exists->code == $request->otp) {
                $user = User::updateOrCreate([
                    'email' => $request->email,
                ],[
                    'type' => $request->check_shop ? User::TYPE_BOOTH_USER : User::TYPE_NORMAL_USER,
                    'status' => 0,
                    'username' => $request->username,
                    'password' => bcrypt($request->password),
                    'name' => $request->shop_name,
                    'code' => null,
                    'phone_verified_at' => now(),
                ]);
                if ($request->check_shop) {
                    Store::updateOrCreate([
                        'slug' => Str::slug($request->shop_name).$user->id,
                    ],[
                        'title' => $request->shop_name,
                        'user_id' => $user->id
                    ]);
                }
                auth()->loginUsingId($user->id);
                return response()->json(['success'=>true,'redirect'=>$request->check_shop ? 'shop' : '']);
            }else if($exists && $exists->code != $request->otp) {
                return response()->json(['success'=>false,'sent_failed'=>true]);
            }
        }
        $code = rand(100000,999999);
        $user = User::updateOrCreate([
            'email' => $request->email,
        ],[
            'type' => $request->check_shop ? User::TYPE_BOOTH_USER : User::TYPE_NORMAL_USER,
            'status' => 0,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'name' => $request->shop_name,
            'code' => $code
        ]);
        $response = Http::get('http://rest.esms.vn/MainService.svc/json/SendMultipleMessage_V4_get?Phone='.$request->username.'&Content=Cam on quy khach da su dung dich vu cua chung toi. Chuc quy khach mot ngay tot lanh!&ApiKey=97BDE83360E1AECFD3FEB03FB3932F&SecretKey=85EC950CEFF5A787120112C62F5E54&SmsType=2&Brandname=Baotrixemay');
        return response()->json(['success'=>true,'sent'=>true]);
    }
}
