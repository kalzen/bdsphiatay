<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ward;
use Illuminate\Http\Request;
use DB;

class WardController extends Controller
{
    public function index(Request $request)
    {
        $query = Ward::orderBy('id','desc');
        $records = $query->paginate();
        return view('admin.ward.index',compact('records'));
    }
    
    public function create()
    {
        return view('admin.ward.form');
    }
    
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $ward = Ward::create($request->only(['name', 'image']));
            DB::commit();
            return redirect()->route('admin.ward.index')->with('message', 'Thêm mới thành công');
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
        $record = Ward::find($id);
        return view('admin.ward.form',compact('record'));
    }
    
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $ward = Ward::find($id);
            $ward->update($request->only(['name', 'image']));
            DB::commit();
            return redirect()->route('admin.ward.index')->with('message', 'Cập nhật thành công');
        }catch(Exception $ex) {
            DB::rollback();
            return back()->withInput();
        }
    }
    
    public function destroy($id)
    {
        Ward::find($id)->delete();
        return response()->json(['success'=>true,'message'=>'Xóa thành công']);
    }
}
