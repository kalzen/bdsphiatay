<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Catalogue;
use App\Models\Ward;
use App\Models\Plan;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Hiển thị danh sách tất cả các dự án
     * Route: GET /du-an
     * View: resources/views/product/index.blade.php
     */
    public function index()
    {
        $catalogues = Catalogue::orderBy('id', 'asc')->get();
        $wards = Ward::all();
        $plans = Plan::all();
        
        // Lấy danh sách sản phẩm với relationships
        $products = Product::with(['images', 'attributes', 'catalogues', 'ward'])
            ->active()
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('product.index', compact('catalogues', 'products', 'wards', 'plans'));
    }
    
    /**
     * Hiển thị danh sách dự án theo danh mục
     * Route: GET /danh-muc/{alias}
     * View: resources/views/product/index.blade.php
     */
    public function catalogue($alias)
    {
        $catalogues = Catalogue::orderBy('id', 'asc')->get();
        $catalogue = Catalogue::with(['tags', 'image'])
            ->where('slug', $alias)
            ->firstOrFail();
        
        $wards = Ward::all();
        $plans = Plan::all();
        
        // Query sản phẩm theo catalogue
        $query = $catalogue->products()
            ->with(['images', 'attributes', 'ward'])
            ->active();
        
        // Tìm kiếm theo từ khóa
        if (request('keyword')) {
            $keyword = request('keyword');
            $query->where(function($q) use ($keyword) {
                $q->where('title', 'like', '%'.$keyword.'%')
                  ->orWhere('description', 'like', '%'.$keyword.'%')
                  ->orWhere('content', 'like', '%'.$keyword.'%');
            });
        }
        
        // Sắp xếp
        if (request('sort') == 'price-asc') {
            $query->orderBy('price', 'asc');
        } elseif (request('sort') == 'price-desc') {
            $query->orderBy('price', 'desc');
        } else {
            $query->orderBy('created_at', 'desc');
        }
        
        $products = $query->get();
        
        return view('product.index', compact('catalogue', 'products', 'catalogues', 'wards', 'plans'));
    }
    
    /**
     * Hiển thị danh sách dự án theo khu vực (Ward)
     * Route: GET /khu-vuc/{slug}
     * View: resources/views/product/index.blade.php
     */
    public function ward($slug)
    {
        // Tìm ward theo slug
        $ward = Ward::where('slug', $slug)->firstOrFail();
        
        $wards = Ward::all();
        $plans = Plan::all();
        $catalogues = Catalogue::orderBy('id', 'asc')->get();
        
        // Lấy sản phẩm theo ward
        $products = Product::with(['images', 'attributes', 'catalogues'])
            ->where('ward_id', $ward->id)
            ->active()
            ->orderBy('created_at', 'desc')
            ->get();
            
        $khuvuc = $ward->name;
        
        return view('product.index', compact('products', 'wards', 'catalogues', 'plans', 'khuvuc'));
    }
    
    /**
     * Tìm kiếm nâng cao với nhiều bộ lọc
     * Route: GET /tim-kiem
     * View: resources/views/product/index.blade.php
     */
    public function search(Request $request)
    {
        $params = $request->all();
        
        // Dữ liệu cho form filters
        $wards = Ward::all();
        $plans = Plan::all();
        $catalogues = Catalogue::orderBy('id', 'asc')->get();
        
        // Tìm kiếm sản phẩm
        $products = $this->performSearch($params);
        
        return view('product.index', compact('products', 'wards', 'catalogues', 'plans'));
    }
    
    /**
     * Hiển thị chi tiết dự án
     * Route: GET /du-an/{alias}
     * View: resources/views/product/detail.blade.php
     */
    public function detail($alias)
    {
        // Lấy chi tiết sản phẩm với tất cả relationships
        $product = Product::with([
                'images',
                'attributes',
                'catalogues',
                'ward',
                'user.images',
                'tags'
            ])
            ->active()
            ->where('slug', $alias)
            ->firstOrFail();
        
        // Tăng lượt xem
        $product->increment('viewed');
        
        // Lấy các sản phẩm nổi bật (có ảnh)
        $products = Product::with(['images'])
            ->active()
            ->has('images')
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();
        
        // Lấy danh sách các ward với số lượng sản phẩm
        $wards = Ward::withCount('products')
            ->orderBy('name', 'asc')
            ->get();
        
        return view('product.detail', compact('product', 'products', 'wards'));
    }
    
    /**
     * Thực hiện tìm kiếm với các bộ lọc
     * 
     * @param array $params Tham số tìm kiếm
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function performSearch($params)
    {
        // Bước 1: Lọc cơ bản trên bảng products
        $query = Product::with(['images', 'attributes', 'catalogues', 'ward'])
            ->active();
        
        // Tìm kiếm theo từ khóa
        if (!empty($params['keyword'])) {
            $keyword = trim($params['keyword']);
            $query->where(function($q) use ($keyword) {
                $q->where('title', 'like', '%'.$keyword.'%')
                  ->orWhere('description', 'like', '%'.$keyword.'%')
                  ->orWhere('content', 'like', '%'.$keyword.'%');
            });
        }
        
        // Lọc theo khoảng giá định sẵn
        if (!empty($params['price_range'])) {
            $priceRanges = [
                1 => [0, 500000000],                    // Dưới 500 triệu
                2 => [500000000, 1000000000],           // 500 triệu - 1 tỷ
                3 => [1000000000, 2000000000],          // 1 - 2 tỷ
                4 => [2000000000, 3000000000],          // 2 - 3 tỷ
                5 => [3000000000, 5000000000],          // 3 - 5 tỷ
                6 => [5000000000, 10000000000],         // 5 - 10 tỷ
                7 => [10000000000, 20000000000],        // 10 - 20 tỷ
                8 => [20000000000, 30000000000],        // 20 - 30 tỷ
                9 => [30000000000, PHP_INT_MAX],        // Trên 30 tỷ
            ];
            
            if (isset($priceRanges[$params['price_range']])) {
                [$minPrice, $maxPrice] = $priceRanges[$params['price_range']];
                $query->whereBetween('price', [$minPrice, $maxPrice]);
            }
        } 
        // Lọc theo khoảng giá tùy chỉnh (đơn vị: triệu)
        else {
            if (!empty($params['price_range_min']) && $params['price_range_min'] > 0) {
                $query->where('price', '>=', $params['price_range_min'] * 1000000);
            }
            if (!empty($params['price_range_max']) && $params['price_range_max'] > 0) {
                $query->where('price', '<=', $params['price_range_max'] * 1000000);
            }
        }
        
        // Lọc theo phường/xã
        if (!empty($params['ward_id'])) {
            $query->where('ward_id', $params['ward_id']);
        }
        
        // Bước 2: Lấy product IDs để lọc theo attributes
        $productIds = $query->pluck('id')->toArray();
        
        if (empty($productIds)) {
            return collect();
        }
        
        // Bước 3: Áp dụng các bộ lọc theo attributes
        $productIds = $this->applyAttributeFilters($productIds, $params);
        
        if (empty($productIds)) {
            return collect();
        }
        
        // Bước 4: Lấy danh sách sản phẩm cuối cùng
        $products = Product::with(['images', 'attributes', 'catalogues', 'ward'])
            ->whereIn('id', $productIds)
            ->orderBy('created_at', 'desc')
            ->get();
        
        return $products;
    }
    
    /**
     * Áp dụng các bộ lọc dựa trên attributes
     * 
     * @param array $productIds Danh sách product IDs
     * @param array $params Tham số lọc
     * @return array
     */
    private function applyAttributeFilters($productIds, $params)
    {
        $filteredIds = $productIds;
        
        // Lọc theo hướng
        if (!empty($params['direction']) && is_array($params['direction'])) {
            $directions = array_filter($params['direction'], function($v) {
                return !empty(trim($v)) && trim($v) != ' ';
            });
            
            if (!empty($directions)) {
                $ids = DB::table('attribute_product')
                    ->whereIn('product_id', $filteredIds)
                    ->where(function($query) use ($directions) {
                        foreach ($directions as $direction) {
                            $query->orWhere('value', 'like', '%'.$direction.'%');
                        }
                    })
                    ->pluck('product_id')
                    ->unique()
                    ->toArray();
                
                $filteredIds = array_intersect($filteredIds, $ids);
            }
        }
        
        // Lọc theo diện tích (attribute_id = 3)
        if (!empty($params['area']) && is_array($params['area'])) {
            $areas = array_filter($params['area'], function($v) {
                return $v != '0' && !empty(trim($v));
            });
            
            if (!empty($areas)) {
                $ids = $this->filterByArea($filteredIds, $areas);
                $filteredIds = array_intersect($filteredIds, $ids);
            }
        }
        
        // Lọc theo mặt tiền (attribute_id = 6)
        if (!empty($params['front']) && is_array($params['front'])) {
            $fronts = array_filter($params['front']);
            
            if (!empty($fronts)) {
                $ids = $this->filterByFront($filteredIds, $fronts);
                $filteredIds = array_intersect($filteredIds, $ids);
            }
        }
        
        // Lọc theo đường (attribute_id = 4 hoặc tùy theo database)
        if (!empty($params['road']) && is_array($params['road'])) {
            $roads = array_filter($params['road']);
            
            if (!empty($roads)) {
                $ids = $this->filterByRoad($filteredIds, $roads);
                $filteredIds = array_intersect($filteredIds, $ids);
            }
        }
        
        // Lọc theo chức năng/tiện ích (plan_id)
        if (!empty($params['plan_id']) && is_array($params['plan_id'])) {
            $planIds = array_filter($params['plan_id']);
            
            if (!empty($planIds)) {
                $ids = DB::table('plan_product')
                    ->whereIn('product_id', $filteredIds)
                    ->whereIn('plan_id', $planIds)
                    ->pluck('product_id')
                    ->unique()
                    ->toArray();
                
                $filteredIds = array_intersect($filteredIds, $ids);
            }
        }
        
        return array_values($filteredIds);
    }
    
    /**
     * Lọc sản phẩm theo diện tích
     */
    private function filterByArea($productIds, $areas)
    {
        $query = DB::table('attribute_product')
            ->whereIn('product_id', $productIds)
            ->where('attribute_id', 3); // Attribute ID cho diện tích
        
        $query->where(function($q) use ($areas) {
            foreach ($areas as $area) {
                switch ($area) {
                    case '1':
                        $q->orWhereRaw('CAST(value AS DECIMAL(10,2)) < 100');
                        break;
                    case '2':
                        $q->orWhereRaw('CAST(value AS DECIMAL(10,2)) BETWEEN 100 AND 300');
                        break;
                    case '3':
                        $q->orWhereRaw('CAST(value AS DECIMAL(10,2)) BETWEEN 300 AND 500');
                        break;
                    case '4':
                        $q->orWhereRaw('CAST(value AS DECIMAL(10,2)) BETWEEN 500 AND 1000');
                        break;
                    case '5':
                        $q->orWhereRaw('CAST(value AS DECIMAL(10,2)) BETWEEN 1000 AND 5000');
                        break;
                    case '6':
                        $q->orWhereRaw('CAST(value AS DECIMAL(10,2)) BETWEEN 10000 AND 50000');
                        break;
                    case '7':
                        $q->orWhereRaw('CAST(value AS DECIMAL(10,2)) > 50000');
                        break;
                }
            }
        });
        
        return $query->pluck('product_id')->unique()->toArray();
    }
    
    /**
     * Lọc sản phẩm theo mặt tiền
     */
    private function filterByFront($productIds, $fronts)
    {
        $query = DB::table('attribute_product')
            ->whereIn('product_id', $productIds)
            ->where('attribute_id', 6); // Attribute ID cho mặt tiền
        
        $query->where(function($q) use ($fronts) {
            foreach ($fronts as $front) {
                switch ($front) {
                    case '1':
                        $q->orWhereRaw('CAST(value AS DECIMAL(10,2)) < 5');
                        break;
                    case '2':
                        $q->orWhereRaw('CAST(value AS DECIMAL(10,2)) BETWEEN 5 AND 8');
                        break;
                    case '3':
                        $q->orWhereRaw('CAST(value AS DECIMAL(10,2)) BETWEEN 8 AND 12');
                        break;
                    case '4':
                        $q->orWhereRaw('CAST(value AS DECIMAL(10,2)) > 12');
                        break;
                }
            }
        });
        
        return $query->pluck('product_id')->unique()->toArray();
    }
    
    /**
     * Lọc sản phẩm theo đường
     */
    private function filterByRoad($productIds, $roads)
    {
        $query = DB::table('attribute_product')
            ->whereIn('product_id', $productIds)
            ->where('attribute_id', 4); // Attribute ID cho đường
        
        $query->where(function($q) use ($roads) {
            foreach ($roads as $road) {
                switch ($road) {
                    case '1':
                        $q->orWhereRaw('CAST(value AS DECIMAL(10,2)) < 2');
                        break;
                    case '2':
                        $q->orWhereRaw('CAST(value AS DECIMAL(10,2)) BETWEEN 2 AND 3');
                        break;
                    case '3':
                        $q->orWhereRaw('CAST(value AS DECIMAL(10,2)) BETWEEN 3 AND 5');
                        break;
                    case '4':
                        $q->orWhereRaw('CAST(value AS DECIMAL(10,2)) BETWEEN 5 AND 10');
                        break;
                    case '5':
                        $q->orWhere('value', 'like', '%QL%');
                        break;
                }
            }
        });
        
        return $query->pluck('product_id')->unique()->toArray();
    }
}