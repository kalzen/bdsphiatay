<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Product;
use DB;

class PostController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('name','asc')->get();
        $featured_posts = Post::active()->orderBy('viewed','desc')->paginate();
        $related = Post::inRandomOrder()->paginate(5);
        $products = Product::latest()->withCount(['images'])->having('images_count','>',0)->active()->take(4)->get();
        $tags = Tag::All();
        $posts = Post::active()->paginate();
        return view('post.index',compact('categories','posts','featured_posts', 'products', 'tags', 'related'));
    }
    public function detail($alias)
    {
        $post = Post::active()->where('slug',$alias)->firstOrFail();
        DB::table('posts')->where('id',$post->id)->increment('viewed');
        $categories = Category::orderBy('name','asc')->whereNull('parent_id')->get();
        $most_view = Post::active()->orderBy('id','desc')->limit(5)->get();
        $products = Product::latest()->withCount(['images'])->having('images_count','>',0)->active()->take(3)->get();
        $tags = Tag::All();
        $related = Post::inRandomOrder()->paginate(3);
        //dd($related);
        return view('post.detail',compact('post', 'categories', 'most_view', 'products', 'tags', 'related'));
    }
    public function category($alias)
    {
        $categories = Category::orderBy('name','asc')->get();
        $category = Category::where('slug',$alias)->firstOrFail();
        if ($category->parent_id != '0')
        {
            $category_parent = Category::find($category->parent_id);
        }
        $posts = $category->posts()->active()->orderBy('id','desc')->paginate();
        $featured_posts = Post::active()->orderBy('id','desc')->paginate();
        $products = Product::latest()->withCount(['images'])->having('images_count','>',0)->active()->take(3)->get();
        $tags = Tag::All();
        return view('post.index',compact('category','posts','categories','featured_posts', 'category_parent', 'products', 'tags'));
    }
    public function search()
    {
        $featured_posts = Post::active()->orderBy('viewed','desc')->paginate();
        $categories = Category::orderBy('name','asc')->get();
        $query = Post::latest()->active()->with(['tags','images']);
        $posts = $query->where(function($p){
            $p->where('title','like','%'.request('keyword').'%')
            ->orWhereHas('categories',function($q){
                $q->where('name','like','%'.request('keyword').'%');
            });
        })->paginate();
        return view('post.index',compact('posts','categories','featured_posts'));
    }
}
