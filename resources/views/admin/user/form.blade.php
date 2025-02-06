@extends('layouts.admin')
@section('content')
@if (isset($record))
<form method="POST" action="{{route('admin.user.update',$record->id)}}">
    @method('PUT')
@else
<form method="POST" action="{{route('admin.user.store')}}">
@endif
    @csrf
    <div class="content">
        <div class="d-flex align-items-start flex-column flex-md-row">
            <div class="w-100 overflow-auto order-2 order-md-1">
				<div class="card">
					<div class="card-body">
                        <div class="form-group">
                            <label class="font-weight-semibold">Tên <span class="required"></span></label>
                            <input type="text" class="form-control" required id="name" name="name" value="{{ old('name') ?: ($record->name ?? '') }}">
                            @error('name')
                            <label id="title-error" class="validation-invalid-label" for="name">{{$message}}</label>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="font-weight-semibold">Email <span class="required"></span></label>
                            @if(isset($record))
                            <input type="email" class="form-control" disabled readonly value="{{ old('email') ?: ($record->email ?? '') }}">
                            @else
                            <input type="email" class="form-control" required id="email" name="email" value="{{ old('email') ?: ($record->email ?? '') }}">
                            @error('email')
                            <label id="email-error" class="validation-invalid-label" for="email">{{$message}}</label>
                            @endif
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="font-weight-semibold">Phone <span class="required"></span></label>
                            <input type="text" class="form-control" required id="phone" name="phone" value="{{ old('phone') ?: ($record->phone ?? '') }}">
                            @error('phone')
                            <label id="title-error" class="validation-invalid-label" for="phone">{{$message}}</label>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="font-weight-semibold">Ảnh người dùng </label>
                            <input type="file" class="form-control-file" data-key="image" data-fouc>
                            @if(old('image'))
                            <input type="hidden" name="image" value="{{old('image')}}" id="image">
                            <img class="mt-2" id="image_preview" height="100" src="{{old('image')}}"/>
                            @elseif (isset($record) && $record->images)
                            <input type="hidden" name="image" value="{{$record->images->first()->url??''}}" id="image">
                            <img class="mt-2" id="image_preview" height="100" src="{{$record->images->first()->url??''}}"/>
                            @else
                            <input type="hidden" name="image" value="{{asset('phiatay/images/no-image.jpg')}}" id="image">
                            <img class="mt-2" id="image_preview" style="display:none;" height="100"/>
                            @endif
                            @error('image')
                            <label id="image-error" class="validation-invalid-label" for="image">{{$message}}</label>
                            @enderror
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Lưu <i class="icon-paperplane ml-2"></i></button>
                        </div>
                    </div>
				</div>
            </div>
            <div class="sidebar sidebar-light bg-transparent sidebar-component sidebar-component-right wmin-300 border-0 shadow-0 order-1 order-md-2 sidebar-expand-md">
                <div class="sidebar-content">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="form-check form-check-inline disabled">
                                <label class="form-check-label">
                                    <input type="radio" class="form-input-styled" {{isset($record) && $record->status == 1 ? 'checked' : ''}} name="status" value="1" checked data-fouc>
                                    Hoạt động
                                </label>
                            </div>

                            <div class="form-check form-check-inline disabled">
                                <label class="form-check-label">
                                    <input type="radio" class="form-input-styled" {{isset($record) && $record->status == 0 ? 'checked' : ''}} name="status" value="0" data-fouc>
                                    Khóa
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body text-center">
                        	
                              <label class="font-weight-semibold">Quyền</label>
                                <select class="form-select select" name="role_id">
                                    <option value="3">--Chọn Quyền--</option>
                                    
                                @foreach ($roles as $role)
                                    <option @if(isset($record)&& $record->role->id == $role->id) selected @endif value="{{$role->id}}">{{$role->name}}</option>
                                @endforeach
                                </select>
                    </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label class="font-weight-semibold">Mật khẩu</label>
                                <input type="password" class="form-control" name="password">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection