<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Image;
use Log;
use DB;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::latest();
        $records = $query->paginate();
        return view('admin.user.index',compact('records'));
    }
    
    public function create()
    {
        $roles = Role::All();
        return view('admin.user.form', compact('roles'));
    }
    
    public function store(CreateUserRequest $request)
    {
        
        DB::beginTransaction();
        try {
             $request->merge([
                'password' => bcrypt($request->password),
            ]);
            $user = User::create($request->only(['name','email','status', 'role_id', 'phone']));
            $user->images()->create(['url' => $request->image]);
            DB::commit();
            return redirect()->route('admin.user.index')->with('message', 'Thêm mới thành công');
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
        $record = User::find($id);
        $roles = Role::All();
        return view('admin.user.form',compact('record', 'roles'));
    }
    
    public function update(UpdateUserRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $user = User::find($id);
            if ($request->password) {
                $request->merge([
                    'password' => bcrypt($request->password),
                ]);
                $user->update($request->only(['name','password','status', 'role_id', 'phone']));
                
            } else {
                $user->update($request->only(['name','status', 'role_id', 'phone']));
            }
            $user->images()->first()->update(['url' => $request->image]);
            DB::commit();
            return redirect()->route('admin.user.index')->with('message', 'Cập nhật thành công');
        }catch(Exception $ex) {
            DB::rollback();
            return back()->withInput();
        }
    }
    
    public function destroy($id)
    {
        User::find($id)->delete();
        return response()->json(['success'=>true,'message'=>'Xóa thành công']);
    }
    
}
