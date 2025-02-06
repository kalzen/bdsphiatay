<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SubmitFeedbackRequest;
use App\Models\Feedback;
use Illuminate\Support\Facades\Validator;
use Log;
use DB;

class FeedbackController extends Controller
{
    public function index(Request $request)
    {
        $query = Feedback::latest();
        $records = $query->paginate();
        return view('admin.feedback.index',compact('records'));
    }
    
    public function create()
    {
        return view('admin.feedback.form');
    }
    
    public function store(SubmitFeedbackRequest $request)
    {
        DB::beginTransaction();
        try {
            $feedback = Feedback::create($request->only(['author_name','author_avatar','content','star_rating']));
            DB::commit();
            return redirect()->route('admin.feedback.index')->with('message', 'Thêm mới thành công');
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
        $record = Feedback::find($id);
        return view('admin.feedback.form',compact('record'));
    }
    
    public function update(SubmitFeedbackRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $feedback = Feedback::find($id);
            $feedback->update($request->only(['author_name','author_avatar','content','star_rating']));
            DB::commit();
            return redirect()->route('admin.feedback.index')->with('message', 'Cập nhật thành công');
        }catch(Exception $ex) {
            DB::rollback();
            return back()->withInput();
        }
    }
    
    public function destroy($id)
    {
        Feedback::find($id)->delete();
        return response()->json(['success'=>true,'message'=>'Xóa thành công']);
    }
    
}
