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
        // Debug: Log tất cả parameters
        \Log::info('DEBUG: Search parameters', $params);
        
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
        
        // Lọc theo khoảng giá (đơn vị: triệu)
        if (!empty($params['price_min']) && $params['price_min'] > 0) {
            $minPrice = $params['price_min'] * 1000000;
            // Sử dụng DB::raw để đảm bảo query đúng
            $query->whereRaw('CAST(price AS UNSIGNED) >= ?', [$minPrice]);
            \Log::info('DEBUG: Price filter MIN', [
                'price_min_param' => $params['price_min'],
                'min_price_vnd' => $minPrice,
                'min_price_formatted' => number_format($minPrice) . ' VNĐ'
            ]);
        }
        if (!empty($params['price_max']) && $params['price_max'] > 0) {
            $maxPrice = $params['price_max'] * 1000000;
            // Sử dụng DB::raw để đảm bảo query đúng
            $query->whereRaw('CAST(price AS UNSIGNED) <= ?', [$maxPrice]);
            \Log::info('DEBUG: Price filter MAX', [
                'price_max_param' => $params['price_max'],
                'max_price_vnd' => $maxPrice,
                'max_price_formatted' => number_format($maxPrice) . ' VNĐ'
            ]);
        }
        
        
        // Lọc theo phường/xã
        if (!empty($params['ward_id'])) {
            $query->where('ward_id', $params['ward_id']);
        }
        
        // Bước 2: Lấy product IDs sau khi lọc cơ bản
        \Log::info('DEBUG: SQL Query before execution', [
            'sql' => $query->toSql(),
            'bindings' => $query->getBindings()
        ]);
        
        // Thực hiện query và kiểm tra kết quả
        $productIds = $query->pluck('id')->toArray();
        
        // Debug: Kiểm tra SQL query thực tế được execute
        $actualSql = $query->toSql();
        $actualBindings = $query->getBindings();
        \Log::info('DEBUG: Actual SQL executed', [
            'sql' => $actualSql,
            'bindings' => $actualBindings,
            'full_query' => vsprintf(str_replace('?', '%s', $actualSql), $actualBindings)
        ]);
        
        // Debug: Kiểm tra products thực tế từ query
        $actualProductsFromQuery = $query->get(['id', 'title', 'price']);
        \Log::info('DEBUG: Actual products from query', [
            'count' => $actualProductsFromQuery->count(),
            'products' => $actualProductsFromQuery->map(function($p) {
                return [
                    'id' => $p->id,
                    'title' => $p->title,
                    'price' => $p->price,
                    'price_formatted' => number_format($p->price) . ' VNĐ'
                ];
            })->toArray()
        ]);
        
        \Log::info('DEBUG: Product IDs after basic filters', [
            'count' => count($productIds),
            'sample_ids' => array_slice($productIds, 0, 10)
        ]);
        
        if (empty($productIds)) {
            return collect();
        }
        
        // Bước 3: Áp dụng các bộ lọc theo attributes
        // CHỈ áp dụng attribute filters nếu KHÔNG có price filter
        $hasPriceFilter = !empty($params['price_min']) || !empty($params['price_max']);
        
        if ($hasPriceFilter) {
            // Nếu có price filter, bỏ qua attribute filters để tránh conflict
            $filteredProductIds = $productIds;
            \Log::info('DEBUG: Skipping attribute filters due to price filter', [
                'price_min' => $params['price_min'] ?? null,
                'price_max' => $params['price_max'] ?? null,
                'product_ids' => $productIds
            ]);
        } else {
            // Chỉ áp dụng attribute filters khi không có price filter
            \Log::info('DEBUG: Before attribute filters', [
                'original_count' => count($productIds),
                'original_ids' => $productIds,
                'params' => $params
            ]);
            
            $filteredProductIds = $this->applyAttributeFilters($productIds, $params);
            
            \Log::info('DEBUG: After attribute filters', [
                'filtered_count' => count($filteredProductIds),
                'filtered_ids' => $filteredProductIds,
                'sample_filtered_ids' => array_slice($filteredProductIds, 0, 10)
            ]);
        }
        
        if (empty($filteredProductIds)) {
            return collect();
        }
        
        // Bước 4: Lấy danh sách sản phẩm cuối cùng
        $products = Product::with(['images', 'attributes', 'catalogues', 'ward'])
            ->whereIn('id', $filteredProductIds)
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Debug: Kiểm tra tất cả products trong database có price 3-5 tỷ
        $allProductsInRange = Product::whereRaw('CAST(price AS UNSIGNED) >= ?', [3000000000])
            ->whereRaw('CAST(price AS UNSIGNED) <= ?', [5000000000])
            ->get(['id', 'title', 'price', 'status']);
            
        \Log::info('DEBUG: All products in 3-5 billion range from database', [
            'count' => $allProductsInRange->count(),
            'products' => $allProductsInRange->map(function($p) {
                return [
                    'id' => $p->id,
                    'title' => $p->title,
                    'price' => $p->price,
                    'status' => $p->status,
                    'price_formatted' => number_format($p->price) . ' VNĐ'
                ];
            })->toArray()
        ]);
        
        // Debug: Kiểm tra products có status = 1 trong khoảng 3-5 tỷ
        $activeProductsInRange = Product::where('status', 1)
            ->whereRaw('CAST(price AS UNSIGNED) >= ?', [3000000000])
            ->whereRaw('CAST(price AS UNSIGNED) <= ?', [5000000000])
            ->get(['id', 'title', 'price', 'status']);
            
        \Log::info('DEBUG: Active products (status=1) in 3-5 billion range', [
            'count' => $activeProductsInRange->count(),
            'products' => $activeProductsInRange->map(function($p) {
                return [
                    'id' => $p->id,
                    'title' => $p->title,
                    'price' => $p->price,
                    'status' => $p->status,
                    'price_formatted' => number_format($p->price) . ' VNĐ'
                ];
            })->toArray()
        ]);
        
        // Debug: So sánh với query trực tiếp từ database
        $directQuery = \DB::select('SELECT id FROM products WHERE status = 1 AND CAST(price AS UNSIGNED) >= ? AND CAST(price AS UNSIGNED) <= ?', [3000000000, 5000000000]);
        \Log::info('DEBUG: Direct database query result', [
            'count' => count($directQuery),
            'ids' => array_column($directQuery, 'id')
        ]);
        
        // Debug: So sánh với query KHÔNG có status filter
        $directQueryNoStatus = \DB::select('SELECT id FROM products WHERE CAST(price AS UNSIGNED) >= ? AND CAST(price AS UNSIGNED) <= ?', [3000000000, 5000000000]);
        \Log::info('DEBUG: Direct database query WITHOUT status filter', [
            'count' => count($directQueryNoStatus),
            'ids' => array_column($directQueryNoStatus, 'id')
        ]);
        
        // Debug: Kiểm tra một số products cụ thể
        $testProducts = \DB::select('SELECT id, price, CAST(price AS UNSIGNED) as price_unsigned FROM products WHERE id IN (2, 46, 60, 68, 77)');
        \Log::info('DEBUG: Test specific products', [
            'products' => $testProducts
        ]);
        
        // Debug: Kiểm tra products có giá thực tế 3-5 tỷ
        $realBillionProducts = \DB::select('SELECT id, price, CAST(price AS UNSIGNED) as price_unsigned FROM products WHERE CAST(price AS UNSIGNED) >= 3000000000 AND CAST(price AS UNSIGNED) <= 5000000000 LIMIT 5');
        \Log::info('DEBUG: Products with real 3-5 billion price', [
            'products' => $realBillionProducts
        ]);
        
        // Debug: Log kết quả cuối cùng
        \Log::info('DEBUG: Final search results', [
            'total_products' => $products->count(),
            'price_min' => $params['price_min'] ?? null,
            'price_max' => $params['price_max'] ?? null,
            'sample_products' => $products->take(5)->map(function($p) {
                return [
                    'id' => $p->id,
                    'title' => $p->title,
                    'price' => $p->price,
                    'price_formatted' => number_format($p->price) . ' VNĐ',
                    'price_in_range' => ($p->price >= ($params['price_min'] ?? 0) * 1000000 && $p->price <= ($params['price_max'] ?? 999999999999) * 1000000) ? 'YES' : 'NO'
                ];
            })->toArray()
        ]);
        
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
        
        \Log::info('DEBUG: applyAttributeFilters start', [
            'input_ids' => $productIds,
            'params' => $params
        ]);
        
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