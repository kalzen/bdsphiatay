<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Attribute;
use Illuminate\Support\Facades\Validator;

class AttributeController extends Controller
{
    public function index(Request $request)
    {
        $records = Attribute::query()->orderBy('name','asc')->paginate();
        return view('admin.attribute.index',compact('records'));
    }
    
    public function create()
    {
        return view('admin.attribute.form');
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
        ]);
 
        if ($validator->fails()) {
            return back()->withInput();
        }
        $attribute = Attribute::create($request->only(['name','status']));

        return redirect()->route('admin.attribute.index')->with('message', 'Thêm mới thành công');
    }
    
    public function show($id)
    {
        
    }
    
    public function edit($id)
    {
        $record = Attribute::find($id);
        return view('admin.attribute.form',compact('record'));
    }
    
    public function update(Request $request, $id)
    {
        $attribute = Attribute::find($id);
        $attribute->update($request->only(['name','status']));
        return redirect()->route('admin.attribute.index')->with('message', 'Cập nhật thành công');
    }
    
    public function destroy($id)
    {
        Attribute::find($id)->delete();
        return response()->json(['success'=>true,'message'=>'Xóa thành công']);
    }
}
