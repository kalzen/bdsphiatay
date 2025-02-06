<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Http\Request;
use DB;

class TeamController extends Controller
{
    public function index(Request $request)
    {
        $query = Team::orderBy('id','desc');
        $records = $query->paginate();
        return view('admin.team.index',compact('records'));
    }
    
    public function create()
    {
        return view('admin.team.form');
    }
    
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $team = Team::create($request->only(['name','image','description']));
            DB::commit();
            return redirect()->route('admin.team.index')->with('message', 'Thêm mới thành công');
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
        $record = Team::find($id);
        return view('admin.team.form',compact('record'));
    }
    
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $team = Team::find($id);
            $team->update($request->only(['name','image','description']));
            DB::commit();
            return redirect()->route('admin.team.index')->with('message', 'Cập nhật thành công');
        }catch(Exception $ex) {
            DB::rollback();
            return back()->withInput();
        }
    }
    
    public function destroy($id)
    {
        Team::find($id)->delete();
        return response()->json(['success'=>true,'message'=>'Xóa thành công']);
    }
}
