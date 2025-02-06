<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SubmitProductRequest;
use App\Models\Product;
use App\Models\Tag;
use App\Models\Image;
use App\Models\Catalogue;
use App\Models\Attribute;
use App\Models\Ward;
use App\Models\User;
use App\Models\Plan;
use Illuminate\Support\Facades\Validator;
use Log;
use DB;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::latest();
        
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where('title', 'LIKE', "%{$search}%");
        }
        
        $records = $query->paginate();
        return view('admin.product.index',compact('records'));
    }
    
    public function create()
    {
        $plans = Plan::All();
        $categories = Catalogue::query()->whereNull('parent_id')->orderBy('name','asc')->get();
        $attributes = Attribute::query()->orderBy('name','asc')->get();
        $wards = Ward::query()->orderBy('name','asc')->get();
        $users =  User::All();
        return view('admin.product.form',compact('categories','attributes', 'wards', 'users', 'plans'));
    }
    
    public function category(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'parent_id' => 'nullable|integer'
        ]);
 
        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }
        $created = Catalogue::create($validator->validated());
        return view('admin.shared.select-category',[
            'categories'=>Catalogue::query()->whereNull('parent_id')->orderBy('name','asc')->get()
        ]);
    }

    public function store(SubmitProductRequest $request)
    {
        DB::beginTransaction();
        try {
            $product = Product::create($request->only(['title','description','price','content','status', 'sale_content', 'ward_id', 'user_id']));
            $product->attributes()->sync(collect($request->attribute)->filter(function($item){return $item['value'];}));
            $product->catalogues()->sync($request->category_id);
            $product->plans()->sync($request->plan_id);
            $product->tags()->sync(collect(explode(', ',$request->tags))->map(function($item){return Tag::updateOrCreate(['name'=>$item]);})->pluck('id'));
            $product->images()->sync(collect(explode(',',$request->images))->map(function($item){return Image::updateOrCreate(['url'=>$item]);})->pluck('id'));
            DB::commit();
            return redirect()->route('admin.product.index')->with('message', 'Thêm mới thành công');
        } catch(Exception $ex) {
            DB::rollback();
            return back()->withInput();
        }
    }
    
    public function show($id)
    {
        
    }
    
    public function edit($id)
    {
        $plans = Plan::All();
        $categories = Catalogue::query()->whereNull('parent_id')->orderBy('name','asc')->get();
        $record = Product::find($id);
        $attributes = Attribute::query()->orderBy('name','asc')->get();
        $wards = Ward::query()->orderBy('name','asc')->get();
        $users =  User::All();
        return view('admin.product.form',compact('categories','record','attributes', 'wards', 'users', 'plans'));
    }
    
    public function update(SubmitProductRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $product = Product::find($id);
            $product->update($request->only(['title','description','price','content','status', 'sale_content', 'ward_id', 'user_id']));
            $product->attributes()->sync(collect($request->attribute)->filter(function($item){return $item['value'];}));
            $product->catalogues()->sync($request->category_id);
            $product->plans()->sync($request->plan_id);
            $product->tags()->sync(collect(explode(', ',$request->tags))->map(function($item){return Tag::updateOrCreate(['name'=>$item]);})->pluck('id'));
            $product->images()->sync(collect(explode(',',$request->images))->map(function($item){return Image::updateOrCreate(['url'=>$item]);})->pluck('id'));
            DB::commit();
            return redirect()->route('admin.product.index')->with('message', 'Cập nhật thành công');
        }catch(Exception $ex) {
            DB::rollback();
            return back()->withInput();
        }
    }
    
    public function destroy($id)
    {
        Product::find($id)->delete();
        return response()->json(['success'=>true,'message'=>'Xóa thành công']);
    }
    
}
