<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\Message;
use App\Models\Post;
use App\Models\Slide;
use App\Models\Catalogue;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Testimonial;
use App\Models\Team;
use App\Models\Ward;
use App\Models\Plan;
use DB;

class HomeController extends Controller
{
    public function index()
    {
        $slides = Slide::orderBy('ordering','asc')->paginate();
        $testimonials = Testimonial::All();
        $teams = Team::All();
        $posts = Post::latest()->withCount(['images'])->having('images_count','>',0)->active()->take(3)->get();
        $wards = Ward::All();
        $plans = Plan::All();
        $products = Product::latest()->withCount(['images'])->having('images_count','>',0)->active()->take(3)->get();
        
        // Get featured products from catalogue with slug 'bst'
        $featuredProducts = Product::whereHas('catalogues', function($query) {
            $query->where('slug', 'bst');
        })->latest()->active()->take(3)->get();

        return view('home.index',[
            'slides'=> $slides, 
            'posts'=>$posts, 
            'testimonials' => $testimonials, 
            'teams' => $teams, 
            'products' => $products, 
            'wards' => $wards, 
            'plans'=> $plans,
            'featuredProducts' => $featuredProducts
        ]);
    }
    public function order()
    {
        DB::beginTransaction();
        try {
            $order = Order::create([
                'code' => Str::random(8),
                'name' => request('name'),
                'phone' => request('phone'),
                'address' => request('address'),
                'note' => request('note'),
            ]);
            $detail = OrderDetail::create([
                'order_id' => $order->id,
                'product_id' => request('product_id')
            ]);
            DB::commit();
            return response()->json(['success'=>true,'msg'=>'Yêu cầu của bạn đã được gửi tới Admin. Chúng tôi sẽ liên hệ lại với bạn trong thời gian sớm nhất.']);
        }catch(Exception $ex){
            DB::rollback();
            return response()->json(['success'=>false,'msg'=>$ex->getMessage()]);
        }
    }
    public function contact()
    {
        if (request()->isMethod('post')) {
            Message::create([
                'name' => request('name'),
                'mobile' => request('mobile'),
                'email' => request('email'),
                'target' => request('target'),
                'content' => request('content')
            ]);
            return redirect()->back()->with('message', 'Cảm ơn bạn đã liên hệ. Chúng tôi sẽ liên lạc với bạn ngay!');
        }
        return view('contact.index');
    }
    public function about()
    {
        return view('home.about');
    }
    public function logout()
    {
        auth()->logout();
        return redirect()->route('login');
    }
    public function login(Request $request)
    {
        $login = [
            'email' => $request->email,
            'password' => $request->password,
            'status' => 1
        ];
        if (Auth::attempt($login)) {
            return redirect('admincp');
        } else {
            return redirect()->back()->with('status', 'Email hoặc Password không chính xác');
        }
    }
    public function advise()
    {
        if (request()->isMethod('post')) {
            Message::create([
                'name' => request('name'),
                'mobile' => request('mobile'),
                'email' => request('email'),
                'target' => request('target'),
                'content' => request('content')
            ]);
            return redirect()->back()->with('message', 'Cảm ơn bạn đã liên hệ. Chúng tôi sẽ liên lạc với bạn ngay!');
        }
        return view('contact.advise');
    }
}
