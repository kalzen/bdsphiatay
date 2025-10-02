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
        // Store search parameters in session if it's a POST request
        if ($request->isMethod('post')) {
            $request->flash();
            $request->session()->put('search_params', $request->all());
        }

        // Get parameters - either from POST or from session for subsequent pages
        $params = $request->isMethod('post') ? $request->all() : session('search_params', []);
        
        // Clear session if no parameters are provided (for debugging)
        if ($request->has('clear_session')) {
            $request->session()->forget('search_params');
            $params = [];
        }
        
        // Debug: Log the parameters being used
        \Log::info('Search Parameters: ', $params);
        
        // Debug: Check which filters are being applied
        \Log::info('Direction isset: ' . (isset($params['direction']) ? 'Yes' : 'No'));
        if (isset($params['direction'])) {
            \Log::info('Direction value: ', $params['direction']);
        }
        \Log::info('Front isset: ' . (isset($params['front']) ? 'Yes' : 'No'));
        \Log::info('Area isset: ' . (isset($params['area']) ? 'Yes' : 'No'));
        if (isset($params['area'])) {
            \Log::info('Area value: ', $params['area']);
        }
        \Log::info('Road isset: ' . (isset($params['road']) ? 'Yes' : 'No'));
        \Log::info('Type isset: ' . (isset($params['type']) ? 'Yes' : 'No'));
        \Log::info('Function isset: ' . (isset($params['function']) ? 'Yes' : 'No'));
        \Log::info('Khuvuc isset: ' . (isset($params['khuvuc']) ? 'Yes' : 'No'));
        
        $wards = Ward::All();
        $plans = Plan::All();
        $catalogues = Catalogue::orderBy('id','asc')->get();
        $query = Product::active(); // Remove with() to avoid exists clauses conflicts

        // Use saved parameters for filtering
        if (isset($params['keyword'])) {
            $query->where('title','like','%'.$params['keyword'].'%');
        }
        
        // Price filtering logic - prioritize price_range over price_range_min/max
        if(isset($params['price_range']) && $params['price_range'] != '')
        {
            if ($params['price_range'] == 1) {
                $query->where('price','<=',500000000);
              }
            elseif ($params['price_range'] == 2) {
                $query->where('price', '>=', 500000000)
                      ->where('price', '<=', 1000000000);
              }
            elseif ($params['price_range'] == 3) {
                $query->where('price', '>=', 1000000000)
                      ->where('price', '<=', 2000000000);
              }
            elseif ($params['price_range'] == 4) {
                $query->where('price', '>=', 2000000000)
                      ->where('price', '<=', 3000000000);
              }
            elseif ($params['price_range'] == 5) {
                $query->where('price', '>=', 3000000000)
                      ->where('price', '<=', 5000000000);
              }
            elseif ($params['price_range'] == 6) {
                $query->where('price', '>=', 5000000000)
                      ->where('price', '<=', 10000000000);
              }
            elseif ($params['price_range'] == 7) {
                $query->where('price', '>=', 10000000000)
                      ->where('price', '<=', 20000000000);
              }
            elseif ($params['price_range'] == 8) {
                $query->where('price', '>=', 20000000000)
                      ->where('price', '<=', 30000000000);
              }
             elseif ($params['price_range'] == 9) {
                $query->where('price','>=',30000000000);
              }      
        }
        else
        {
            // Fallback to price_range_min/max if price_range is not set
            if (isset($params['price_range_min']) && $params['price_range_min'] > 0)
            {
                $query->where('price','>=',$params['price_range_min']*1000000);
            }
            if (isset($params['price_range_max']) && $params['price_range_max'] > 0)
            {
                $query->where('price','<=',$params['price_range_max']*1000000);
            }
        }
        
        if (isset($params['direction']) && is_array($params['direction']) && !empty(array_filter($params['direction'])))
        {
            \Log::info('Applying direction filter: ', $params['direction']);
            $direction = array_filter($params['direction']); // Remove empty values
            \Log::info('Direction after filter: ', $direction);
            $query->whereHas('attributes',function ($query) use($direction)
                    {
                        foreach ($direction as $key => $value)
                        {
                            if ($value && trim($value) != '') // Check for non-empty values
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
            \Log::info('Applying front filter: ', $params['front']);
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
            \Log::info('Applying area filter: ', $params['area']);
            $area = array_filter($params['area']);
            \Log::info('Area after filter: ', $area);
            
            // Check if area contains only "0" values
            $areaWithoutZero = array_filter($area, function($value) {
                return $value != '0' && $value != 0;
            });
            \Log::info('Area without zero: ', $areaWithoutZero);
            
            if (empty($areaWithoutZero)) {
                \Log::info('Area filter contains only zero values, skipping...');
                // Don't apply area filter if it only contains "0"
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
        if (isset($params['ward_id']) && $params['ward_id'] != '')
        {
            $query->where('ward_id',$params['ward_id']);
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
        if (isset($params['plan_id']))
        {
            //$plans = $params['plans'];
            $product_ids = DB::table('plan_product')->whereIn('id',$params['plan_id'])->pluck('product_id')
                            ->toArray();
           // var_dump($product_ids);
            $query->whereIn('id', $product_ids);
        }
        
        // Debug: Log final query for verification
        \Log::info('Final SQL Query: ' . $query->toSql());
        \Log::info('Query Bindings: ', $query->getBindings());
        
        // Test: Create a completely fresh query to compare
        $testQuery = Product::where('status', 1)
            ->where('price', '>=', 5000000000)
            ->where('price', '<=', 10000000000)
            ->where('ward_id', 1);
        
        $testProducts = $testQuery->get();
        \Log::info('Test query results: ' . $testProducts->count());
        foreach($testProducts as $product) {
            \Log::info('Test Product: ' . $product->title . ' - Price: ' . $product->price);
        }
        
        // Debug: Check database connection and table
        \Log::info('Database connection: ' . DB::connection()->getName());
        \Log::info('Database name: ' . DB::connection()->getDatabaseName());
        
        // Debug: Check if products exist in database
        $allProducts = Product::where('ward_id', 1)->get();
        \Log::info('All products in ward_id=1: ' . $allProducts->count());
        foreach($allProducts as $product) {
            \Log::info('All Product: ' . $product->title . ' - Price: ' . $product->price . ' - Status: ' . $product->status);
        }
        
        // FINAL FIX: Use Raw SQL to bypass Laravel Query Builder bug
        if (isset($params['price_range']) && $params['price_range'] != '') {
            \Log::info('Using Raw SQL to bypass Laravel Query Builder bug');
            
            // Build Raw SQL query with proper parameter order
            $rawSql = "SELECT * FROM products WHERE status = ?";
            $bindings = [1];
            
            // Apply ward_id filter first
            if (isset($params['ward_id']) && $params['ward_id'] != '') {
                $rawSql .= " AND ward_id = ?";
                $bindings[] = $params['ward_id'];
            }
            
            // Apply price filter
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
            
            $rawSql .= " ORDER BY price ASC";
            
            \Log::info('Raw SQL: ' . $rawSql);
            \Log::info('Raw SQL Bindings: ', $bindings);
            
            // Debug: Check price column data type
            $priceColumnInfo = DB::select("DESCRIBE products price");
            \Log::info('Price column info: ', $priceColumnInfo);
            
            // Debug: Check actual price values and types
            $priceDebug = DB::select("SELECT id, title, price, TYPEOF(price) as price_type FROM products WHERE ward_id = 1 LIMIT 5");
            \Log::info('Price debug info: ', $priceDebug);
            
            // Debug: Check MySQL version and configuration
            $mysqlVersion = DB::select("SELECT VERSION() as version");
            \Log::info('MySQL version: ', $mysqlVersion);
            
            // Debug: Test simple comparison
            $simpleTest = DB::select("SELECT id, title, price FROM products WHERE ward_id = 1 AND price > 1000000000 LIMIT 3");
            \Log::info('Simple price > 1 billion test: ', $simpleTest);
            
            // Execute raw SQL
            $rawResults = DB::select($rawSql, $bindings);
            $productIds = collect($rawResults)->pluck('id')->toArray();
            
            \Log::info('Raw SQL results: ' . count($rawResults));
            foreach($rawResults as $product) {
                \Log::info('Raw SQL Product: ' . $product->title . ' - Price: ' . $product->price . ' - Type: ' . gettype($product->price));
            }
            
            // Debug: Test with explicit CAST
            $castSql = "SELECT * FROM products WHERE status = ? AND ward_id = ? AND CAST(price AS DECIMAL(20,0)) >= ? AND CAST(price AS DECIMAL(20,0)) <= ? ORDER BY price ASC";
            $castResults = DB::select($castSql, $bindings);
            \Log::info('CAST SQL results: ' . count($castResults));
            foreach($castResults as $product) {
                \Log::info('CAST Product: ' . $product->title . ' - Price: ' . $product->price);
            }
            
            // Load products with relationships
            if (!empty($productIds)) {
                $products = Product::with(['images', 'attributes'])
                    ->whereIn('id', $productIds)
                    ->orderBy('price', 'asc')
                    ->get();
            } else {
                $products = collect();
            }
        } else {
            // Use Query Builder for non-price-range searches
            $products = $query->orderBy('price', 'asc')->get();
            
            // Load relationships separately
            if ($products->count() > 0) {
                $products->load(['images', 'attributes']);
            }
        }
        
      
        // Debug: Log the results
        \Log::info('Products found: ' . $products->count());
        foreach($products as $product) {
            \Log::info('Product: ' . $product->title . ' - Price: ' . $product->price . ' - Ward ID: ' . $product->ward_id);
        }
        
        // Debug: Check if there are any products in the 5-10 billion range
        $productsInRange = Product::where('status', 1)
            ->whereBetween('price', [5000000000, 10000000000])
            ->get();
        \Log::info('Products in 5-10 billion range: ' . $productsInRange->count());
        foreach($productsInRange as $product) {
            \Log::info('Product in range: ' . $product->title . ' - Price: ' . $product->price);
        }
        
        // Debug: Check products in ward_id = 1
        $productsInWard = Product::where('status', 1)
            ->where('ward_id', 1)
            ->get();
        \Log::info('Products in ward_id=1: ' . $productsInWard->count());
        foreach($productsInWard as $product) {
            \Log::info('Product in ward: ' . $product->title . ' - Price: ' . $product->price);
        }
        
        // Debug: Check if there are products in ward_id=1 AND price range 5-10 billion
        $productsInWardAndRange = Product::where('status', 1)
            ->where('ward_id', 1)
            ->whereBetween('price', [5000000000, 10000000000])
            ->get();
        \Log::info('Products in ward_id=1 AND 5-10 billion range: ' . $productsInWardAndRange->count());
        foreach($productsInWardAndRange as $product) {
            \Log::info('Product in ward and range: ' . $product->title . ' - Price: ' . $product->price);
        }
        
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
