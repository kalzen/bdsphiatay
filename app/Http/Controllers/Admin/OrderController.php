<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Validator;
use Log;
use DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::latest();
        $records = $query->paginate();
        return view('admin.order.index',compact('records'));
    }
    
    public function destroy($id)
    {
        OrderDetail::where('order_id',$id)->delete();
        Order::find($id)->delete();
        return response()->json(['success'=>true,'message'=>'Xóa thành công']);
    }
    
}
