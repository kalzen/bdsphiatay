<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Mail\OrderConfirmed;
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{
    public function index()
    {
        return view('payment.index');
    }
    public function submit(Request $request){
        $cart = Session::get('cart')?:[];
        if ($request->name && $request->email && $request->address && $request->mobile) {
            Mail::to('nguyendattmdt@gmail.com')
            ->cc('hungvphp@gmail.com')
            ->bcc('quangiahopan@gmail.com')->send(new OrderConfirmed($cart, $request->all()));
            Session::put('cart',[]);
            return response()->json(['success'=>true,'msg'=>'Đã gửi đơn hàng thành công']);
        }
        return response()->json(['success'=>false,'msg'=>'Vui lòng điền hết các thông tin']);
    }
}
