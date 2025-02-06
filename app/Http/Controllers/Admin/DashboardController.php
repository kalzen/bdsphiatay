<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Product;
use App\Models\Message;

class DashboardController extends Controller
{
    public function index()
    {
        $latest_posts = Post::latest()->paginate();
        $messages = Message::latest()->paginate();
        $most_viewed_products = Product::orderBy('viewed','desc')->paginate();
        return view('admin.dashboard.index',compact('latest_posts','messages','most_viewed_products'));
    }
    public function profile(Request $request)
    {
        if ($request->isMethod('post')) {
            auth()->user()->update([
                'name' => $request->name
            ]);
            return redirect()->route('admin.profile')->with('message', 'Cập nhật thành công');
        }
        return view('admin.dashboard.profile');
    }
    public function logout()
    {
        auth()->logout();
        return redirect('/');
    }
}
