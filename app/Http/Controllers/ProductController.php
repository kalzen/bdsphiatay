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
        $params = $request->all();
        
        if ($request->has('clear_session')) {
            $params = [];
        }
        
        $wards = Ward::all();
        $plans = Plan::all();
        $catalogues = Catalogue::orderBy('id','asc')->get();
        $query = Product::active();

        // Keyword search
        if (!empty($params['keyword'])) {
            $query->where('title','like','%'.$params['keyword'].'%');
        }
        
        // Price range filter - optimized
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
        
        // Direction filter - optimized
        if (!empty($params['direction']) && is_array($params['direction'])) {
            $directions = array_filter($params['direction'], function($v) {
                return !empty(trim($v));
            });
            
            if (!empty($directions)) {
                $query->whereHas('attributes', function($q) use($directions) {
                    $q->whereIn('value', $directions);
                });
            }
        }
        
        // Area filter - optimized
        if (!empty($params['area']) && is_array($params['area'])) {
            $areas = array_filter($params['area'], function($v) {
                return $v != '0' && !empty(trim($v));
            });
            
            if (!empty($areas)) {
                $query->whereHas('attributes', function($q) use($areas) {
                    $q->where('attribute_id', 3);
                    $areaConditions = [];
                    
                    foreach ($areas as $area) {
                        switch ($area) {
                            case '1': $areaConditions[] = 'CAST(value as DECIMAL) < 100'; break;
                            case '2': $areaConditions[] = 'CAST(value as DECIMAL) BETWEEN 100 AND 300'; break;
                            case '3': $areaConditions[] = 'CAST(value as DECIMAL) BETWEEN 300 AND 500'; break;
                            case '4': $areaConditions[] = 'CAST(value as DECIMAL) BETWEEN 500 AND 1000'; break;
                            case '5': $areaConditions[] = 'CAST(value as DECIMAL) BETWEEN 1000 AND 5000'; break;
                            case '6': $areaConditions[] = 'CAST(value as DECIMAL) BETWEEN 10000 AND 50000'; break;
                            case '7': $areaConditions[] = 'CAST(value as DECIMAL) > 50000'; break;
                        }
                    }
                    
                    if (!empty($areaConditions)) {
                        $q->whereRaw('(' . implode(' OR ', $areaConditions) . ')');
                            }
                        });
            }
        }
        
        // Front filter - optimized
        if (!empty($params['front']) && is_array($params['front'])) {
            $fronts = array_filter($params['front']);
            
            if (!empty($fronts)) {
                $query->whereHas('attributes', function($q) use($fronts) {
                    $q->where('attribute_id', 6);
                    $frontConditions = [];
                    
                    foreach ($fronts as $front) {
                        switch ($front) {
                            case '1': $frontConditions[] = 'CAST(value as DECIMAL) < 5'; break;
                            case '2': $frontConditions[] = 'CAST(value as DECIMAL) BETWEEN 5 AND 8'; break;
                            case '3': $frontConditions[] = 'CAST(value as DECIMAL) BETWEEN 8 AND 12'; break;
                            case '4': $frontConditions[] = 'CAST(value as DECIMAL) > 12'; break;
                        }
                    }
                    
                    if (!empty($frontConditions)) {
                        $q->whereRaw('(' . implode(' OR ', $frontConditions) . ')');
                    }
                });
            }
        }
        
        // Road filter - optimized
        if (!empty($params['road']) && is_array($params['road'])) {
            $roads = array_filter($params['road']);
            
            if (!empty($roads)) {
                $query->whereHas('attributes', function($q) use($roads) {
                    $q->where('attribute_id', 3);
                    $roadConditions = [];
                    
                    foreach ($roads as $road) {
                        switch ($road) {
                            case '1': $roadConditions[] = 'CAST(value as DECIMAL) < 2'; break;
                            case '2': $roadConditions[] = 'CAST(value as DECIMAL) BETWEEN 2 AND 3'; break;
                            case '3': $roadConditions[] = 'CAST(value as DECIMAL) BETWEEN 3 AND 5'; break;
                            case '4': $roadConditions[] = 'CAST(value as DECIMAL) BETWEEN 5 AND 10'; break;
                            case '5': $roadConditions[] = "value LIKE '%QL%'"; break;
                        }
                    }
                    
                    if (!empty($roadConditions)) {
                        $q->whereRaw('(' . implode(' OR ', $roadConditions) . ')');
                        }
                    });
        }
        }
        
        // Type filter
        if (!empty($params['type'])) {
            $query->whereHas('attributes', function($q) use($params) {
                $q->where('attribute_id', 8)
                  ->where('value', 'like', '%'.$params['type'].'%');
            });
        }
        
        // Function filter
        if (!empty($params['function'])) {
            $query->whereHas('attributes', function($q) use($params) {
                $q->where('attribute_id', 10)
                  ->where('value', 'like', '%'.$params['function'].'%');
            });
        }
        
        // Khu vực filter
        if (!empty($params['khuvuc'])) {
            $query->whereHas('attributes', function($q) use($params) {
                $q->where('attribute_id', 9)
                  ->where('value', 'like', '%'.$params['khuvuc'].'%');
            });
        }

        // Clear any potential cache/session issues
        \Cache::flush();
        \Session::flush();
        
        // Execute query with explicit casting to ensure numeric comparison
        $products = $query->whereRaw('CAST(price AS UNSIGNED) BETWEEN ? AND ?', [3000000000, 5000000000])
                         ->with(['images', 'attributes'])
                         ->orderBy('price', 'asc')
                         ->get();
        
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
