<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Catalogue;
use App\Models\Tag;
use Illuminate\Support\Facades\Validator;

class CatalogueController extends Controller
{
    public function index(Request $request)
    {
        $records = Catalogue::query()->whereNull('parent_id')->orderBy('name','asc')->paginate();
        return view('admin.catalogue.index',compact('records'));
    }
    
    public function create()
    {
        $catalogues = Catalogue::query()->whereNull('parent_id')->orderBy('name','asc')->paginate();
        return view('admin.catalogue.form',compact('catalogues'));
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
        $catalogue = Catalogue::create($request->only(['name','description','content','parent_id']));
        $catalogue->tags()->createMany(collect(explode(', ',$request->tags))->map(function($item){return ['name'=>$item];}));
        if ($request->image) {
            $catalogue->image()->create(['url' => $request->image]);
        }
        return redirect()->route('admin.catalogue.index')->with('message', 'Thêm mới thành công');
    }
    
    public function show($id)
    {
        
    }
    
    public function edit($id)
    {
        $record = Catalogue::find($id);
        $catalogues = Catalogue::query()->whereNull('parent_id')->orderBy('name','asc')->paginate();
        return view('admin.catalogue.form',compact('catalogues','record'));
    }
    
    public function update(Request $request, $id)
    {
        $catalogue = Catalogue::find($id);
        $catalogue->update($request->only(['name','description','content','parent_id']));
        $ids = collect(explode(', ',$request->tags))->map(function($item){return Tag::updateOrCreate(['name'=>$item]);})->pluck('id');
        $catalogue->tags()->sync($ids);
        if ($request->image) {
            $catalogue->image()->updateOrCreate(['url' => $request->image]);
        }
        return redirect()->route('admin.catalogue.index')->with('message', 'Cập nhật thành công');
    }
    
    public function destroy($id)
    {
        Catalogue::find($id)->delete();
        return response()->json(['success'=>true,'message'=>'Xóa thành công']);
    }
}
