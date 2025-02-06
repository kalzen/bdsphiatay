<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $records = Category::query()->orderBy('name','asc')->paginate();
        return view('admin.category.index',compact('records'));
    }
    
    public function create()
    {
        $categories = Category::query()->whereNull('parent_id')->orderBy('name','asc')->paginate();
        return view('admin.category.form',compact('categories'));
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'parent_id' => 'nullable|integer'
        ]);
 
        if ($validator->fails()) {
            return back()->withInput();
        }
        $category = Category::create($request->only(['name','description','content','parent_id']));
        $category->tags()->createMany(collect(explode(', ',$request->tags))->map(function($item){return ['name'=>$item];}));
        if ($request->image) {
            $category->image()->updateOrCreate(['url' => $request->image]);
        }
        return redirect()->route('admin.category.index')->with('message', 'Thêm mới thành công');
    }
    
    public function show($id)
    {
        
    }
    
    public function edit($id)
    {
        $record = Category::find($id);
        $categories = Category::query()->whereNull('parent_id')->orderBy('name','asc')->paginate();
        return view('admin.category.form',compact('categories','record'));
    }
    
    public function update(Request $request, $id)
    {
        $category = Category::find($id);
        $category->update($request->only(['name','description','content','parent_id']));
        $ids = collect(explode(', ',$request->tags))->map(function($item){return Tag::updateOrCreate(['name'=>$item]);})->pluck('id');
        $category->tags()->sync($ids);
        if ($request->image) {
            $category->image()->updateOrCreate(['url' => $request->image]);
        }
        return redirect()->route('admin.category.index')->with('message', 'Cập nhật thành công');
    }
    
    public function destroy($id)
    {
        Category::find($id)->delete();
        return response()->json(['success'=>true,'message'=>'Xóa thành công']);
    }
}
