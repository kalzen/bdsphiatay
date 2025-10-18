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
    /**
     * Display a listing of products
     */
    public function index()
    {
        $catalogues = Catalogue::orderBy('id','asc')->get();
        $wards = Ward::all();
        $plans = Plan::all();
        $products = Product::active()->latest()->paginate(20);
        
        return view('product.index', compact('catalogues', 'products', 'wards', 'plans'));
    }
    
    /**
     * Display products by catalogue
     */
    public function catalogue($alias)
    {
        $catalogues = Catalogue::orderBy('id','asc')->get();
        $catalogue = Catalogue::where('slug', $alias)->firstOrFail();
        $wards = Ward::all();
        $plans = Plan::all();
        
        $query = $catalogue->products()->active();
        
        // Sorting
        if (request('sort') == 'price-asc') {
            $query->orderBy('price', 'asc');
        } elseif (request('sort') == 'price-desc') {
            $query->orderBy('price', 'desc');
        } else {
            $query->orderBy('created_at', 'desc');
        }
        
        // Keyword search
        if (request('keyword')) {
            $query->where(function($q) {
                $keyword = request('keyword');
                $q->where('title', 'like', '%'.$keyword.'%')
                  ->orWhere('description', 'like', '%'.$keyword.'%')
                  ->orWhere('slug', 'like', '%'.$keyword.'%')
                  ->orWhereHas('tags', function($tag) use ($keyword) {
                      $tag->where('name', 'like', '%'.$keyword.'%');
                  })
                  ->orWhereHas('catalogues', function($cat) use ($keyword) {
                      $cat->where('name', 'like', '%'.$keyword.'%')
                          ->orWhere('slug', 'like', '%'.$keyword.'%');
                  });
            });
        }
        
        $products = $query->paginate(20);
        
        return view('product.index', compact('catalogue', 'products', 'catalogues', 'wards', 'plans'));
    }
    
    /**
     * Display products by ward
     */
    public function ward($slug)
    {
        try {
            $ward = Ward::where('slug', $slug)->firstOrFail();
        } catch (\Exception $e) {
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
    
    /**
     * Search products with advanced filtering
     */
    public function search(Request $request)
    {
        $params = $request->all();
        
        // Clear cache to avoid stale data
        \Cache::flush();
        
        // Get basic data for form
        $wards = Ward::all();
        $plans = Plan::all();
        $catalogues = Catalogue::orderBy('id', 'asc')->get();
        
        // Search products
        $products = $this->searchProducts($params);
        
        return view('product.index', compact('products', 'wards', 'catalogues', 'plans'));
    }
    
    /**
     * Display product detail
     */
    public function detail($alias)
    {
        $product = Product::active()->where('slug', $alias)->firstOrFail();
        DB::table('products')->where('id', $product->id)->increment('viewed');
        
        $products = Product::latest()
            ->withCount(['images'])
            ->having('images_count', '>', 0)
            ->active()
            ->take(4)
            ->get();
        
        $wards = Ward::withCount('products')->get();
        
        return view('product.detail', compact('product', 'products', 'wards'));
    }
    
    /**
     * Advanced product search with all filters
     */
    private function searchProducts($params)
    {
        // Step 1: Basic filters on products table
        $productIds = $this->getBasicFilteredProducts($params);
        
        if (empty($productIds)) {
            return collect();
        }
        
        // Step 2: Apply attribute-based filters
        $finalProductIds = $this->applyAttributeFilters($productIds, $params);
        
        if (empty($finalProductIds)) {
            return collect();
        }
        
        // Step 3: Load final products with relationships
        return Product::whereIn('id', $finalProductIds)
            ->with(['images', 'attributes'])
            ->orderBy('price', 'asc')
            ->get();
    }
    
    /**
     * Apply basic filters (keyword, price, ward) to products table
     */
    private function getBasicFilteredProducts($params)
    {
        $query = DB::table('products')->where('status', 1);
        
        // Keyword search
        if (!empty($params['keyword'])) {
            $query->where('title', 'like', '%'.trim($params['keyword']).'%');
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
            // Custom price range (min/max in millions)
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
        
        return $query->orderBy('price', 'asc')->pluck('id')->toArray();
    }
    
    /**
     * Apply attribute-based filters to product IDs
     */
    private function applyAttributeFilters($productIds, $params)
    {
        $query = DB::table('attribute_product')->whereIn('product_id', $productIds);
        
        $conditions = [];
        
        // Direction filter
        if (!empty($params['direction']) && is_array($params['direction'])) {
            $directions = array_filter($params['direction'], function($v) {
                return !empty(trim($v));
            });
            
            if (!empty($directions)) {
                $conditions[] = function($q) use ($directions) {
                    $q->whereIn('value', $directions);
                };
            }
        }
        
        // Area filter
        if (!empty($params['area']) && is_array($params['area'])) {
            $areas = array_filter($params['area'], function($v) {
                return $v != '0' && !empty(trim($v));
            });
            
            if (!empty($areas)) {
                $conditions[] = function($q) use ($areas) {
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
                };
            }
        }
        
        // Front filter
        if (!empty($params['front']) && is_array($params['front'])) {
            $fronts = array_filter($params['front']);
            
            if (!empty($fronts)) {
                $conditions[] = function($q) use ($fronts) {
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
                };
            }
        }
        
        // Road filter
        if (!empty($params['road']) && is_array($params['road'])) {
            $roads = array_filter($params['road']);
            
            if (!empty($roads)) {
                $conditions[] = function($q) use ($roads) {
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
                };
            }
        }
        
        // Type filter
        if (!empty($params['type'])) {
            $conditions[] = function($q) use ($params) {
                $q->where('attribute_id', 8)
                  ->where('value', 'like', '%'.$params['type'].'%');
            };
        }
        
        // Function filter
        if (!empty($params['function'])) {
            $conditions[] = function($q) use ($params) {
                $q->where('attribute_id', 10)
                  ->where('value', 'like', '%'.$params['function'].'%');
            };
        }
        
        // Khu vực filter
        if (!empty($params['khuvuc'])) {
            $conditions[] = function($q) use ($params) {
                $q->where('attribute_id', 9)
                  ->where('value', 'like', '%'.$params['khuvuc'].'%');
            };
        }
        
        // Plan filter
        if (!empty($params['plan_id']) && is_array($params['plan_id'])) {
            $planIds = array_filter($params['plan_id']);
            if (!empty($planIds)) {
                $conditions[] = function($q) use ($planIds) {
                    $q->whereIn('attribute_id', $planIds);
                };
            }
        }
        
        // If no attribute filters, return original product IDs
        if (empty($conditions)) {
            return $productIds;
        }
        
        // Apply all conditions
        foreach ($conditions as $condition) {
            $condition($query);
        }
        
        // Get final product IDs
        return $query->distinct()->pluck('product_id')->toArray();
    }
}