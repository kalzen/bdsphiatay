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
        // Debug: Log all request parameters
        \Log::info('=== SEARCH REQUEST START ===');
        \Log::info('Request Method: ' . $request->method());
        \Log::info('Request Params: ', $request->all());
        
        $params = $request->all();
        
        if ($request->has('clear_session')) {
            $params = [];
        }
        
        
        $wards = Ward::All();
        $plans = Plan::All();
        $catalogues = Catalogue::orderBy('id','asc')->get();
        $query = Product::active();
        
        // Enable query logging
        \DB::enableQueryLog();

        if (isset($params['keyword'])) {
            $query->where('title','like','%'.$params['keyword'].'%');
        }
        
        if(isset($params['price_range']) && $params['price_range'] != '')
        {
            if ($params['price_range'] == 1) {
                $query->whereRaw('CAST(price as DECIMAL(20,0)) <= ?', [500000000]);
              }
            elseif ($params['price_range'] == 2) {
                $query->whereRaw('CAST(price as DECIMAL(20,0)) >= ?', [500000000])
                      ->whereRaw('CAST(price as DECIMAL(20,0)) <= ?', [1000000000]);
              }
            elseif ($params['price_range'] == 3) {
                $query->whereRaw('CAST(price as DECIMAL(20,0)) >= ?', [1000000000])
                      ->whereRaw('CAST(price as DECIMAL(20,0)) <= ?', [2000000000]);
              }
            elseif ($params['price_range'] == 4) {
                $query->whereRaw('CAST(price as DECIMAL(20,0)) >= ?', [2000000000])
                      ->whereRaw('CAST(price as DECIMAL(20,0)) <= ?', [3000000000]);
              }
            elseif ($params['price_range'] == 5) {
                $query->whereRaw('CAST(price as DECIMAL(20,0)) >= ?', [3000000000])
                      ->whereRaw('CAST(price as DECIMAL(20,0)) <= ?', [5000000000]);
              }
            elseif ($params['price_range'] == 6) {
                $query->whereRaw('CAST(price as DECIMAL(20,0)) >= ?', [5000000000])
                      ->whereRaw('CAST(price as DECIMAL(20,0)) <= ?', [10000000000]);
              }
            elseif ($params['price_range'] == 7) {
                $query->whereRaw('CAST(price as DECIMAL(20,0)) >= ?', [10000000000])
                      ->whereRaw('CAST(price as DECIMAL(20,0)) <= ?', [20000000000]);
              }
            elseif ($params['price_range'] == 8) {
                $query->whereRaw('CAST(price as DECIMAL(20,0)) >= ?', [20000000000])
                      ->whereRaw('CAST(price as DECIMAL(20,0)) <= ?', [30000000000]);
              }
             elseif ($params['price_range'] == 9) {
                $query->whereRaw('CAST(price as DECIMAL(20,0)) >= ?', [30000000000]);
              }      
        }
        else
        {
            if (isset($params['price_range_min']) && $params['price_range_min'] > 0)
            {
                $query->whereRaw('CAST(price as DECIMAL(20,0)) >= ?', [$params['price_range_min']*1000000]);
            }
            if (isset($params['price_range_max']) && $params['price_range_max'] > 0)
            {
                $query->whereRaw('CAST(price as DECIMAL(20,0)) <= ?', [$params['price_range_max']*1000000]);
            }
        }
        
        // Giữ các điều kiện theo bảng attributes (trừ plan)
        if (isset($params['direction']) && is_array($params['direction']) && !empty(array_filter($params['direction'])))
        {
            $direction = array_filter($params['direction']);
            $query->whereHas('attributes',function ($query) use($direction)
                    {
                        foreach ($direction as $key => $value)
                        {
                            if ($value && trim($value) != '')
                            {
                            if ($key == 0)
                            {
                                $query->where('value', '=', $value);
                            }
                            else
                            {
                                $query->orwhere('value', '=', $value);
                            }
                            }
                        }
                    });
        }
        if (isset($params['front']) && is_array($params['front']) && !empty(array_filter($params['front'])))
        {
            $front = array_filter($params['front']);
            $query->whereHas('attributes',function ($query) use($front)
                    {
                        $query->where('attribute_id', '=', 6);
                        foreach ($front as $key => $value)
                        {
                            
                            if ($key == 0)
                            {
                                if ($value == 1)
                                {
                                $query->whereRaw('CAST(value as float) < 5');
                                }
                                elseif ($value == 2)
                                {
                                $query->whereRaw('CAST(value as float) between 5 and 8');
                                }
                                elseif ($value == 3)
                                {
                                $query->whereRaw('CAST(value as float) between 8 and 12');
                                }
                                elseif ($value == 4)
                                {
                                $query->whereRaw('CAST(value as float) > 12');
                                }
                            }
                            else
                            {
                                if ($value == 1)
                                {
                                $query->orwhereRaw('CAST(value as float) < 5');
                                }
                                elseif ($value == 2)
                                {
                                $query->orwhereRaw('CAST(value as float) between 5 and 8');
                                }
                                elseif ($value == 3)
                                {
                                $query->orwhereRaw('CAST(value as float) between 8 and 12');
                                }
                                elseif ($value == 4)
                                {
                                $query->orwhereRaw('CAST(value as float) > 12');
                                }
                            }
                        
                        }
                    });
        }
        if (isset($params['area']) && is_array($params['area']) && !empty(array_filter($params['area'])))
        {
            $area = array_filter($params['area']);
            
            // Check if area contains only "0" values
            $areaWithoutZero = array_filter($area, function($value) {
                return $value != '0' && $value != 0;
            });
            
            if (empty($areaWithoutZero)) {
            } else {
                $query->whereHas('attributes',function ($query) use($area)
                        {
                            $query->where('attribute_id', '=', 3);
                            foreach ($area as $key => $value)
                            {
                                
                                if ($key == 0)
                                {
                                    if ($value == 1)
                                    {
                                    $query->whereRaw('CAST(value as float) < 100');
                                    }
                                    elseif ($value == 2)
                                    {
                                    $query->whereRaw('CAST(value as float) between 100 and 300');
                                    }
                                    elseif ($value == 3)
                                    {
                                    $query->whereRaw('CAST(value as float) between 300 and 500');
                                    }
                                    elseif ($value == 4)
                                    {
                                    $query->whereRaw('CAST(value as float) between 500 and 1000');
                                    }
                                    elseif ($value == 5)
                                    {
                                    $query->whereRaw('CAST(value as float) between 1000 and 5000');
                                    }
                                    elseif ($value == 6)
                                    {
                                    $query->whereRaw('CAST(value as float) between 10000 and 50000');
                                    }
                                    elseif ($value == 7)
                                    {
                                    $query->whereRaw('CAST(value as float) > 50000');
                                    }
                                }
                                else
                                {
                                    if ($value == 1)
                                    {
                                    $query->orwhereRaw('CAST(value as float) < 100');
                                    }
                                    elseif ($value == 2)
                                    {
                                    $query->orwhereRaw('CAST(value as float) between 100 and 300');
                                    }
                                    elseif ($value == 3)
                                    {
                                    $query->orwhereRaw('CAST(value as float) between 300 and 500');
                                    }
                                    elseif ($value == 4)
                                    {
                                    $query->orwhereRaw('CAST(value as float) between 500 and 1000');
                                    }
                                    elseif ($value == 5)
                                    {
                                    $query->orwhereRaw('CAST(value as float) between 1000 and 5000');
                                    }
                                    elseif ($value == 6)
                                    {
                                    $query->orwhereRaw('CAST(value as float) between 10000 and 50000');
                                    }
                                    elseif ($value == 7)
                                    {
                                    $query->orwhereRaw('CAST(value as float) > 50000');
                                    }
                                }
                            
                            }
                        });
            }
        }
        if (isset($params['road']) && is_array($params['road']) && !empty(array_filter($params['road'])))
        {
            $road = array_filter($params['road']);
            $query->whereHas('attributes',function ($query) use($road)
                    {
                        $query->where('attribute_id', '=', 3);
                        foreach ($road as $key => $value)
                        {
                            
                            if ($key == 0)
                            {
                                if ($value == 1)
                                {
                                $query->whereRaw('CAST(value as float) < 2');
                                }
                                elseif ($value == 2)
                                {
                                $query->whereRaw('CAST(value as float) between 2 and 3');
                                }
                                elseif ($value == 3)
                                {
                                $query->whereRaw('CAST(value as float) between 3 and 5');
                                }
                                elseif ($value == 4)
                                {
                                $query->whereRaw('CAST(value as float) between 5 and 10');
                                }
                                elseif ($value == 5)
                                {
                                $query->where('value','like','%QL%');
                                }
                                
                            }
                            else
                            {
                                 if ($value == 1)
                                {
                                $query->orwhereRaw('CAST(value as float) < 2');
                                }
                                elseif ($value == 2)
                                {
                                $query->orwhereRaw('CAST(value as float) between 2 and 3');
                                }
                                elseif ($value == 3)
                                {
                                $query->orwhereRaw('CAST(value as float) between 3 and 5');
                                }
                                elseif ($value == 4)
                                {
                                $query->orwhereRaw('CAST(value as float) between 5 and 10');
                                }
                                elseif ($value == 5)
                                {
                                $query->orwhere('value','like','%QL%');
                                }
                            }
                        
                        }
                    });
        }
        if (isset($params['type']) && $params['type'] != '')
        {
            $type = $params['type'];
            $query->whereHas('attributes',function ($query) use($type)
            {
                $query->where('attribute_id', '=', 8);
                $query->where('value','like','%'.$type.'%');
            });
        }
        if (isset($params['function']) && $params['function'] != '')
        {
            $function = $params['function'];
            $query->whereHas('attributes',function ($query) use($function)
            {
                $query->where('attribute_id', '=', 10);
                $query->where('value','like','%'.$function.'%');
            });
        }
        if (isset($params['khuvuc']) && $params['khuvuc'] != '')
        {
            $khuvuc = $params['khuvuc'];
            $query->whereHas('attributes',function ($query) use($khuvuc)
            {
                $query->where('attribute_id', '=', 9);
                $query->where('value','like','%'.$khuvuc.'%');
            });
        }
        
        // Chỉ lọc trực tiếp trên bảng products
        if (isset($params['ward_id']) && $params['ward_id'] != '')
        {
            $query->where('ward_id',$params['ward_id']);
        }
        // Bỏ toàn bộ điều kiện theo bảng liên quan (plan/attributes)
        // Luôn trả về bằng Eloquent thay vì SQL thô để đảm bảo đồng nhất
        $products = $query->orderByRaw('CAST(price as DECIMAL(20,0)) asc')->get();
        
        // Fallback: nếu kết quả rỗng bất thường, thử truy vấn thô tối giản theo bảng products
        if ($products->count() === 0) {
            $rawSql = "SELECT id FROM products WHERE status = 1";
            $bindings = [];
            if (isset($params['ward_id']) && $params['ward_id'] != '') {
                $rawSql .= " AND ward_id = ?";
                $bindings[] = $params['ward_id'];
            }
            if(isset($params['price_range']) && $params['price_range'] != '')
            {
                if ($params['price_range'] == 1) {
                    $rawSql .= " AND price <= ?";
                    $bindings[] = 500000000;
                } elseif ($params['price_range'] == 2) {
                    $rawSql .= " AND price >= ? AND price <= ?";
                    $bindings[] = 500000000;
                    $bindings[] = 1000000000;
                } elseif ($params['price_range'] == 3) {
                    $rawSql .= " AND price >= ? AND price <= ?";
                    $bindings[] = 1000000000;
                    $bindings[] = 2000000000;
                } elseif ($params['price_range'] == 4) {
                    $rawSql .= " AND price >= ? AND price <= ?";
                    $bindings[] = 2000000000;
                    $bindings[] = 3000000000;
                } elseif ($params['price_range'] == 5) {
                    $rawSql .= " AND price >= ? AND price <= ?";
                    $bindings[] = 3000000000;
                    $bindings[] = 5000000000;
                } elseif ($params['price_range'] == 6) {
                    $rawSql .= " AND price >= ? AND price <= ?";
                    $bindings[] = 5000000000;
                    $bindings[] = 10000000000;
                } elseif ($params['price_range'] == 7) {
                    $rawSql .= " AND price >= ? AND price <= ?";
                    $bindings[] = 10000000000;
                    $bindings[] = 20000000000;
                } elseif ($params['price_range'] == 8) {
                    $rawSql .= " AND price >= ? AND price <= ?";
                    $bindings[] = 20000000000;
                    $bindings[] = 30000000000;
                } elseif ($params['price_range'] == 9) {
                    $rawSql .= " AND price >= ?";
                    $bindings[] = 30000000000;
                }
            } else {
                if (isset($params['price_range_min']) && $params['price_range_min'] > 0) {
                    $rawSql .= " AND price >= ?";
                    $bindings[] = $params['price_range_min']*1000000;
                }
                if (isset($params['price_range_max']) && $params['price_range_max'] > 0) {
                    $rawSql .= " AND price <= ?";
                    $bindings[] = $params['price_range_max']*1000000;
                }
            }
            $rawSql .= " ORDER BY CAST(price AS DECIMAL(20,0)) ASC";
            $rawIds = DB::select($rawSql, $bindings);
            $ids = collect($rawIds)->pluck('id')->toArray();
            if (!empty($ids)) {
                \Log::info('Fallback raw returned IDs', $ids);
                $products = Product::with(['images','attributes'])->whereIn('id', $ids)->orderBy('price','asc')->get();
            }
        }
        if ($products->count() > 0) {
            \Log::info('Products: ' . $products->count());
            $products->load(['images', 'attributes']);
        }
        
        // Debug: Log all executed queries
        $queries = \DB::getQueryLog();
        \Log::info('=== EXECUTED SQL QUERIES ===');
        foreach ($queries as $index => $query) {
            \Log::info('Query #' . ($index + 1) . ': ' . $query['query']);
            \Log::info('Bindings: ', $query['bindings']);
            \Log::info('Time: ' . $query['time'] . 'ms');
        }
        
        // Debug: Log results
        \Log::info('=== SEARCH RESULTS ===');
        \Log::info('Total Products Found: ' . $products->count());
        // Log product IDs as context array to avoid "Array to string conversion"
        \Log::info('Product IDs', $products->pluck('id')->toArray());
        \Log::info('=== SEARCH REQUEST END ===');
        
        return view('product.index',compact('products', 'wards', 'catalogues', 'plans'));
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
