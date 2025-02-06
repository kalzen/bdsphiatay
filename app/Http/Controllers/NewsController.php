<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use App\Model\Tag;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $news = Post::latest()->paginate();
        $related = Post::inRandomOrder()->paginate(5);
        $products = Product::latest()->withCount(['images'])->having('images_count','>',0)->active()->take(4)->get();
        $tags = Tag::All();
        return view('news.index', ['news' => $news, 'related' => $related, 'products' => $products, 'tags' => $tags]);
    }
    public function category($alias, Request $request)
    {
        $related = Post::inRandomOrder()->paginate(5);
        $category = Category::where('slug', $alias)->firstOrFail();
        $news = $category->posts()->orderBy('id', 'desc')->paginate();
        $products = Product::latest()->withCount(['images'])->having('images_count','>',0)->active()->take(4)->get();
        $tags = Tag::All();
        return view('news.index', ['category'=>$category,'news' => $news, 'related' => $related, 'products' => $products, 'tags' => $tags]);
    }
    public function detail($alias, Request $request)
    {
        $post = Post::where('slug',$alias)->firstOrFail();
        $related = Post::inRandomOrder()->paginate(5);
        $products = Product::latest()->withCount(['images'])->having('images_count','>',0)->active()->take(4)->get();
        $tags = Tag::All();
        return view('news.detail', ['post' => $post, 'related' => $related, 'products' => $products, 'tags' => $tags]);
    }
}
