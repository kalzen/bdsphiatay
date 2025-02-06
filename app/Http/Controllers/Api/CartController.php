<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Session;
use Log;

class CartController extends Controller
{
    public function index(Request $request)
    {
        return view('partials.cart');
    }
    public function remove(Request $request)
    {
        $cart = Session::get('cart')?:[];
        unset($cart[$request->id]);
        Session::put('cart', $cart);
        return response()->json(['success'=>true]);
    }
    public function add(Request $request)
    {
        try 
        {
            $cart = Session::get('cart')?:[];
            $info = Product::findOrFail($request->id);
            if (!isset($cart[$request->id])) {
                $cart[$request->id] = [];
            }
            $quantity = ($request->quantity ?? 1) + (isset($cart[$request->id]['quantity']) ? $cart[$request->id]['quantity'] : 0);
            if ($request->has('quantity')) {
                $quantity = $request->quantity;
            }
            $cart[$request->id] = [
                'product_id' => $request->id,
                'quantity' => $quantity,
                'sub_total' => $info->price * $quantity,
                'price' => $info->price,
                'id' => $info->id,
                'name' => $info->title,
                'url' => $info->url,
                'image' => $info->images->first()->url ?? ''
            ];
            Session::put('cart', $cart);
            return response()->json(['success'=>true,'data'=>$cart,'msg'=>'Cập nhật thành công']);
        }catch(Exception $ex) {
            return response()->json(['success'=>false,'msg'=>$ex->getMessage()]);

        }
    }
}
