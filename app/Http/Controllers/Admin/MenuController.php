<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SubmitMenuRequest;
use App\Models\Menu;
use App\Models\Tag;
use Illuminate\Support\Facades\Validator;
use Log;
use DB;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $query = Menu::latest();
        $records = $query->paginate();
        return view('admin.menu.index',compact('records'));
    }
    
    public function create()
    {
        return view('admin.menu.form');
    }
    
    public function store(SubmitMenuRequest $request)
    {
        DB::beginTransaction();
        try {
            $menu = Menu::create($request->only(['name','url','image','ordering']));
            DB::commit();
            return redirect()->route('admin.menu.index')->with('message', 'Thêm mới thành công');
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
        $record = Menu::find($id);
        return view('admin.menu.form',compact('record'));
    }
    
    public function update(SubmitMenuRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $menu = Menu::find($id);
            $menu->update($request->only(['name','url','image','ordering']));
            DB::commit();
            return redirect()->route('admin.menu.index')->with('message', 'Cập nhật thành công');
        }catch(Exception $ex) {
            DB::rollback();
            return back()->withInput();
        }
    }
    
    public function destroy($id)
    {
        Menu::find($id)->delete();
        return response()->json(['success'=>true,'message'=>'Xóa thành công']);
    }
    
}
