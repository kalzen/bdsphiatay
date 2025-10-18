<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Catalogue;
use App\Models\Ward;
use App\Models\Plan;
use DB;

class ProductController extends Controller
{
    public function index()
    {
        $catalogues = Catalogue::orderBy('id','asc')->get();
        $wards = Ward::All();
        $plans = Plan::All();
        $products = Product::active()->latest()->paginate(20);
        return view('product.index',compact('catalogues','products', 'wards', 'plans'));
    }
    public function catalogue($alias)
    {
        $catalogues = Catalogue::orderBy('id','asc')->get();
        $catalogue = Catalogue::where('slug',$alias)->firstOrFail();
        $wards = Ward::All();
        $plans = Plan::All();
        //keyword
        $query = $catalogue->products()->active();
        if (request('sort')=='price-asc') {
            $query->orderBy('price','asc');
        } else if (request('sort') == 'price-desc') {
            $query->orderBy('price','desc');
        } else {
            $query->orderBy('created_at','desc');
        }
        if (request('keyword')) {
            $query->where(function($p){
                $p->where('title','like','%'.request('keyword').'%')
                ->orWhere('description','like','%'.request('keyword').'%')
                ->orWhere('slug','like','%'.request('keyword').'%')
                ->orWhereHas('tags',function($tag){
                    $tag->where('name','like','%'.request('keyword').'%');
                })
                ->orWhereHas('catalogues',function($tag){
                    $tag->where('name','like','%'.request('keyword').'%')
                    ->orWhere('slug','like','%'.request('keyword').'%');
                });
            });
        }
        $products = $query->paginate(20);
        return view('product.index',compact('catalogue','products','catalogues', 'wards', 'plans'));
    }
    
    public function searchPage()
    {
        $wards = Ward::All();
        $plans = Plan::All();
        $catalogues = Catalogue::orderBy('id','asc')->get();
        $products = collect(); // Empty collection for initial page
        return view('product.index',compact('catalogues','products', 'wards', 'plans'));
    }
    
    public function search(Request $request)
    {
        // Get request parameters
        $params = $request->all();
        
        // Clear cache to avoid stale data
        \Cache::flush();
        
        // Get basic data for form
        $wards = Ward::all();
        $plans = Plan::all();
        $catalogues = Catalogue::orderBy('id','asc')->get();
        
        // Start with fresh query - no global scopes
        $query = \DB::table('products')->where('status', 1);
        
        // Keyword search
        if (!empty($params['keyword'])) {
            $query->where('title', 'like', '%'.$params['keyword'].'%');
        }
        
        // Price range filter
        if (!empty($params['price_range'])) {
            $priceRanges = [
                1 => [0, 500000000],
                2 => [500000000, 1000000000], 
                3 => [1000000000, 2000000000],
                4 => [2000000000, 3000000000],
                5 => [3000000000, 5000000000],
                6 => [5000000000, 10000000000],
                7 => [10000000000, 20000000000],
                8 => [20000000000, 30000000000],
                9 => [30000000000, PHP_INT_MAX],
            ];
            
            if (isset($priceRanges[$params['price_range']])) {
                [$minPrice, $maxPrice] = $priceRanges[$params['price_range']];
                $query->whereBetween('price', [$minPrice, $maxPrice]);
            }
        } else {
            // Custom price range
            if (!empty($params['price_range_min']) && $params['price_range_min'] > 0) {
                $query->where('price', '>=', $params['price_range_min'] * 1000000);
            }
            if (!empty($params['price_range_max']) && $params['price_range_max'] > 0) {
                $query->where('price', '<=', $params['price_range_max'] * 1000000);
            }
        }
        
        // Ward filter
        if (!empty($params['ward_id'])) {
            $query->where('ward_id', $params['ward_id']);
        }
        
        // Execute main query to get product IDs
        $productIds = $query->orderBy('price', 'asc')->pluck('id')->toArray();
        
        // If no products found, return empty collection
        if (empty($productIds)) {
                $products = collect();
        } else {
            // Load products with relationships using the filtered IDs
            $products = Product::whereIn('id', $productIds)
                ->with(['images', 'attributes'])
                ->orderBy('price', 'asc')
                ->get();
        }
        
        return view('product.index', compact('products', 'wards', 'catalogues', 'plans'));
    }
    public function detail($alias)
    {
        $product = Product::active()->where('slug',$alias)->firstOrFail();
        DB::table('products')->where('id',$product->id)->increment('viewed');
        $products = Product::latest()->withCount(['images'])->having('images_count','>',0)->active()->take(4)->get();
        
        // Get all wards with product counts
        $wards = Ward::withCount('products')->get();
        
        return view('product.detail',compact('product', 'products', 'wards'));
    }
    
    public function ward($slug)
    {
        try {
            $ward = Ward::where('slug', $slug)->firstOrFail();
        } catch (\Exception $e) {
            // If the exact slug is not found, try to find by a normalized version of the slug
            $ward = Ward::where('name', 'like', '%'.str_replace('-', '%', $slug).'%')->firstOrFail();
        }
        
        $wards = Ward::all();
        $plans = Plan::all();
        $catalogues = Catalogue::orderBy('id', 'asc')->get();
        
        $products = Product::with(['images', 'attributes'])
            ->where('ward_id', $ward->id)
            ->active()
            ->orderBy('created_at', 'desc')
            ->get();
        $khuvuc = $ward->name;
        return view('product.index', compact('products', 'wards', 'catalogues', 'plans', 'khuvuc'));
    }
}
