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
        \Log::info('DEBUG: Search method called', [
            'params' => $params
        ]);
        
        $products = $this->performSearch($params);
        
        \Log::info('DEBUG: Search method returning', [
            'products_count' => $products->count(),
            'first_3_products' => $products->take(3)->map(function($p) {
                return [
                    'id' => $p->id,
                    'title' => $p->title,
                    'price' => $p->price
                ];
            })->toArray()
        ]);
        
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
            $query->where('price', '>=', $minPrice);
            \Log::info('DEBUG: Price filter MIN', [
                'price_min_param' => $params['price_min'],
                'min_price_vnd' => $minPrice,
                'min_price_formatted' => number_format($minPrice) . ' VNĐ'
            ]);
        }
        if (!empty($params['price_max']) && $params['price_max'] > 0) {
            $maxPrice = $params['price_max'] * 1000000;
            $query->where('price', '<=', $maxPrice);
            \Log::info('DEBUG: Price filter MAX', [
                'price_max_param' => $params['price_max'],
                'max_price_vnd' => $maxPrice,
                'max_price_formatted' => number_format($maxPrice) . ' VNĐ'
            ]);
        }
        
        // TEMPORARY: Log tất cả products trước khi filter
        $allProducts = Product::active()->get(['id', 'title', 'price']);
        \Log::info('DEBUG: All products before filter', [
            'count' => $allProducts->count(),
            'sample' => $allProducts->take(5)->map(function($p) {
                return [
                    'id' => $p->id,
                    'title' => $p->title,
                    'price' => $p->price,
                    'price_formatted' => number_format($p->price) . ' VNĐ',
                    'price_type' => gettype($p->price)
                ];
            })->toArray()
        ]);
        
        // Kiểm tra products trong khoảng 5-10 tỷ
        $targetProducts = Product::active()
            ->where('price', '>=', 5000000000)
            ->where('price', '<=', 10000000000)
            ->get(['id', 'title', 'price']);
            
        \Log::info('DEBUG: Products in 5-10 billion range', [
            'count' => $targetProducts->count(),
            'sample' => $targetProducts->take(5)->map(function($p) {
                return [
                    'id' => $p->id,
                    'title' => $p->title,
                    'price' => $p->price,
                    'price_formatted' => number_format($p->price) . ' VNĐ'
                ];
            })->toArray()
        ]);
        
        // Kiểm tra products trong khoảng 0-2 tỷ (để so sánh)
        $lowPriceProducts = Product::active()
            ->where('price', '>=', 0)
            ->where('price', '<=', 2000000000)
            ->get(['id', 'title', 'price']);
            
        \Log::info('DEBUG: Products in 0-2 billion range', [
            'count' => $lowPriceProducts->count(),
            'sample' => $lowPriceProducts->take(5)->map(function($p) {
                return [
                    'id' => $p->id,
                    'title' => $p->title,
                    'price' => $p->price,
                    'price_formatted' => number_format($p->price) . ' VNĐ'
                ];
            })->toArray()
        ]);
        
        // Lọc theo phường/xã
        if (!empty($params['ward_id'])) {
            $query->where('ward_id', $params['ward_id']);
        }
        
        // Bước 2: Lấy product IDs sau khi lọc cơ bản
        \Log::info('DEBUG: SQL Query before execution', [
            'sql' => $query->toSql(),
            'bindings' => $query->getBindings()
        ]);
        
        $productIds = $query->pluck('id')->toArray();
        
        \Log::info('DEBUG: Products after basic filters', [
            'count' => count($productIds),
            'sample_ids' => array_slice($productIds, 0, 10)
        ]);
        
        // Kiểm tra giá của các sản phẩm được trả về
        if (!empty($productIds)) {
            $returnedProducts = Product::whereIn('id', array_slice($productIds, 0, 10))
                ->get(['id', 'title', 'price']);
            \Log::info('DEBUG: Sample returned products', [
                'products' => $returnedProducts->map(function($p) {
                    return [
                        'id' => $p->id,
                        'title' => $p->title,
                        'price' => $p->price,
                        'price_formatted' => number_format($p->price) . ' VNĐ'
                    ];
                })->toArray()
            ]);
        }
        
        if (empty($productIds)) {
            \Log::info('DEBUG: No products after basic filters');
            return collect();
        }
        
        // Bước 3: Áp dụng các bộ lọc theo attributes
        // Chỉ áp dụng attribute filters nếu KHÔNG có price filter
        $hasPriceFilter = !empty($params['price_min']) || !empty($params['price_max']);
        
        if ($hasPriceFilter) {
            // Nếu có price filter, bỏ qua attribute filters để tránh conflict
            $filteredProductIds = $productIds;
            \Log::info('DEBUG: Skipping attribute filters due to price filter', [
                'price_min' => $params['price_min'] ?? null,
                'price_max' => $params['price_max'] ?? null
            ]);
        } else {
            // Chỉ áp dụng attribute filters khi không có price filter
            $filteredProductIds = $this->applyAttributeFilters($productIds, $params);
        }
        
        \Log::info('DEBUG: Products after attribute filters', [
            'original_count' => count($productIds),
            'filtered_count' => count($filteredProductIds),
            'sample_filtered_ids' => array_slice($filteredProductIds, 0, 10)
        ]);
        
        if (empty($filteredProductIds)) {
            \Log::info('DEBUG: No products after attribute filters');
            return collect();
        }
        
        // Bước 4: Lấy danh sách sản phẩm cuối cùng
        \Log::info('DEBUG: Fetching products with IDs', [
            'filtered_product_ids' => array_slice($filteredProductIds, 0, 10),
            'total_ids' => count($filteredProductIds),
            'ids_type' => gettype($filteredProductIds),
            'first_id_type' => isset($filteredProductIds[0]) ? gettype($filteredProductIds[0]) : 'N/A',
            'first_id_value' => isset($filteredProductIds[0]) ? $filteredProductIds[0] : 'N/A'
        ]);
        
        // TEMPORARY: Fetch products with raw SQL to test
        $idsString = implode(',', $filteredProductIds);
        \Log::info('DEBUG: Raw SQL test', [
            'ids_string' => $idsString,
            'sql_query' => "SELECT * FROM products WHERE id IN ($idsString) ORDER BY created_at DESC"
        ]);
        
        // TEMPORARY: Test with DB::select() to bypass Eloquent
        $rawResults = \DB::select("SELECT * FROM products WHERE id IN ($idsString) ORDER BY created_at DESC");
        \Log::info('DEBUG: Raw DB results', [
            'count' => count($rawResults),
            'first_5_ids' => array_slice(array_column($rawResults, 'id'), 0, 5)
        ]);
        
        $products = Product::whereRaw("id IN ($idsString)")
            ->orderBy('created_at', 'desc')
            ->get();
            
        \Log::info('DEBUG: Actual SQL executed', [
            'sql' => $products->toSql(),
            'bindings' => $products->getBindings()
        ]);
            
        \Log::info('DEBUG: Products fetched from database', [
            'fetched_count' => $products->count(),
            'fetched_ids' => $products->pluck('id')->toArray(),
            'first_5_fetched' => $products->take(5)->map(function($p) {
                return [
                    'id' => $p->id,
                    'title' => $p->title,
                    'price' => $p->price,
                    'price_formatted' => number_format($p->price) . ' VNĐ'
                ];
            })->toArray()
        ]);
            
        // Debug: Kiểm tra data consistency
        \Log::info('DEBUG: Data consistency check', [
            'requested_ids' => array_slice($filteredProductIds, 0, 10),
            'actual_products' => $products->take(5)->map(function($p) {
                return [
                    'id' => $p->id,
                    'price' => $p->price,
                    'price_in_range' => ($p->price >= 5000000000 && $p->price <= 10000000000) ? 'YES' : 'NO'
                ];
            })->toArray()
        ]);
        
        // Debug: Log kết quả cuối cùng
        \Log::info('DEBUG: Final search results', [
            'total_products' => $products->count(),
            'product_ids' => $filteredProductIds,
            'sample_products' => $products->take(5)->map(function($p) {
                return [
                    'id' => $p->id,
                    'title' => $p->title,
                    'price' => $p->price,
                    'price_formatted' => number_format($p->price) . ' VNĐ'
                ];
            })->toArray()
        ]);
        
        // Debug: Log data được trả về cho view
        \Log::info('DEBUG: Data sent to view', [
            'products_count' => $products->count(),
            'first_5_products' => $products->take(5)->map(function($p) {
                return [
                    'id' => $p->id,
                    'title' => $p->title,
                    'price' => $p->price,
                    'price_formatted' => number_format($p->price) . ' VNĐ',
                    'price_in_range' => ($p->price >= 5000000000 && $p->price <= 10000000000) ? 'YES' : 'NO'
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
        
        \Log::info('DEBUG: Starting attribute filters', [
            'input_product_ids_count' => count($productIds),
            'params' => $params
        ]);
        
        // Lọc theo hướng
        if (!empty($params['direction']) && is_array($params['direction'])) {
            $directions = array_filter($params['direction'], function($v) {
                return !empty(trim($v)) && trim($v) != ' ';
            });
            
            \Log::info('DEBUG: Direction filter', [
                'directions' => $directions,
                'before_count' => count($filteredIds)
            ]);
            
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
                
                \Log::info('DEBUG: Direction filter result', [
                    'after_count' => count($filteredIds),
                    'found_ids' => array_slice($ids, 0, 10)
                ]);
            }
        }
        
        // Lọc theo diện tích (attribute_id = 3)
        if (!empty($params['area']) && is_array($params['area'])) {
            $areas = array_filter($params['area'], function($v) {
                return $v != '0' && !empty(trim($v));
            });
            
            \Log::info('DEBUG: Area filter', [
                'areas' => $areas,
                'before_count' => count($filteredIds)
            ]);
            
            if (!empty($areas)) {
                $ids = $this->filterByArea($filteredIds, $areas);
                $filteredIds = array_intersect($filteredIds, $ids);
                
                \Log::info('DEBUG: Area filter result', [
                    'after_count' => count($filteredIds),
                    'found_ids' => array_slice($ids, 0, 10)
                ]);
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
        
        \Log::info('DEBUG: Final attribute filter result', [
            'final_count' => count($filteredIds),
            'final_ids' => array_slice($filteredIds, 0, 20)
        ]);
        
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