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
        $products = Product::active()->latest()->paginate(20);
        return view('product.index',compact('catalogues','products'));
    }
    public function catalogue($alias)
    {
        $catalogues = Catalogue::orderBy('id','asc')->get();
        $catalogue = Catalogue::where('slug',$alias)->firstOrFail();
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
        return view('product.index',compact('catalogue','products','catalogues'));
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
        
        $wards = Ward::All();
        $plans = Plan::All();
        $catalogues = Catalogue::orderBy('id','asc')->get();
        $query = Product::with(['images', 'attributes'])->active();

        // Use saved parameters for filtering
        if (isset($params['keyword'])) {
            $query->where('title','like','%'.$params['keyword'].'%');
        }
        if (isset($params['price_range_min']) && $params['price_range_max'] > 0)
        {
            $query->where('price','>=',$params['price_range_min']*1000000);
        }
        if (isset($params['price_range_max']) && $params['price_range_max'] > 0)
        {
            $query->where('price','<=',$params['price_range_max']*1000000);
        }
        if(isset ($params['price_range']))
        {
            if ($params['price_range'] == 1) {
                $query->where('price','=<',500000000);
              }
            elseif ($params['price_range'] == 2) {
                $query->whereBetween('price',[500000000, 1000000000]);
              }
            elseif ($params['price_range'] == 3) {
                $query->whereBetween('price',[1000000000, 2000000000]);
              }
            elseif ($params['price_range'] == 4) {
                $query->whereBetween('price',[2000000000, 3000000000]);
              }
            elseif ($params['price_range'] == 5) {
                $query->whereBetween('price',[3000000000, 5000000000]);
              }
            elseif ($params['price_range'] == 6) {
                $query->whereBetween('price',[5000000000, 10000000000]);
              }
            elseif ($params['price_range'] == 7) {
                $query->whereBetween('price',[10000000000, 20000000000]);
              }
            elseif ($params['price_range'] == 8) {
                $query->whereBetween('price',[20000000000, 30000000000]);
              }
             elseif ($params['price_range'] == 9) {
                $query->where('price','>=',30000000000);
              }      
                  
        }
        
        if (isset($params['direction']) && $params['direction'] !='')
        {
            $direction = $params['direction'];
            $query->whereHas('attributes',function ($query) use($direction)
                    {
                        foreach ($direction as $key => $value)
                        {
                            if ($value)
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
        if (isset($params['front']))
        {
            $front = $params['front'];
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
        if (isset($params['area']))
        {
            $area = $params['area'];
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
        if (isset($params['road']))
        {
            $road = $params['road'];
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
        if (isset($params['ward_id']))
        {
            $query->where('ward_id',$params['ward_id']);
        }
        if (isset($params['type']))
        {
            $type = $params['type'];
            $query->whereHas('attributes',function ($query) use($type)
            {
                $query->where('attribute_id', '=', 8);
                $query->where('value','like','%'.$type.'%');
            });
        }
        if (isset($params['function']))
        {
            $function = $params['function'];
            $query->whereHas('attributes',function ($query) use($function)
            {
                $query->where('attribute_id', '=', 10);
                $query->where('value','like','%'.$function.'%');
            });
        }
        if (isset($params['khuvuc']))
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
        $products = $query->orderBy('price', 'asc')->get();
        
        return view('product.index',compact('products', 'wards', 'catalogues', 'plans'));
    }
    public function detail($alias)
    {
        $product = Product::active()->where('slug',$alias)->firstOrFail();
        DB::table('products')->where('id',$product->id)->increment('viewed');
        $products = Product::latest()->withCount(['images'])->having('images_count','>',0)->active()->take(4)->get();
        return view('product.detail',compact('product', 'products'));
    }
}
