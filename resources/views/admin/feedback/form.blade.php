@extends('layouts.admin')
@section('content')
@if (isset($record))
<form method="POST" action="{{route('admin.feedback.update',$record->id)}}">
    @method('PUT')
@else
<form method="POST" action="{{route('admin.feedback.store')}}">
@endif
    @csrf
    <div class="content">
        <div class="d-flex align-items-start flex-column flex-md-row">
            <div class="w-100 overflow-auto order-2 order-md-1">
				<div class="card">
					<div class="card-body">
                        <div class="form-group">
                            <label class="font-weight-semibold">Nội dung <span class="required"></span></label>
                            <input type="text" class="form-control" required id="content" name="content" value="{{ old('content') ?: ($record->content ?? '') }}">
                            @error('content')
                            <label id="content-error" class="validation-invalid-label" for="content">{{$message}}</label>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="font-weight-semibold">Họ tên</label>
                            <input type="text" class="form-control" id="author_name" name="author_name" value="{{ old('author_name') ?: ($record->author_name ?? '') }}">
                            @error('author_name')
                            <label id="author_name-error" class="validation-invalid-label" for="author_name">{{$message}}</label>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="font-weight-semibold">Ảnh </label>
                            <input type="file" class="form-control-file" data-key="author_avatar" data-fouc>
                            @if(old('author_avatar'))
                            <input type="hidden" name="author_avatar" value="{{old('author_avatar')}}" id="author_avatar">
                            <img class="mt-2" id="author_avatar_preview" height="100" src="{{old('author_avatar')}}"/>
                            @elseif (isset($record) && $record->author_avatar)
                            <input type="hidden" name="author_avatar" value="{{$record->author_avatar??''}}" id="author_avatar">
                            <img class="mt-2" id="author_avatar_preview" height="100" src="{{$record->author_avatar??''}}"/>
                            @else
                            <input type="hidden" name="author_avatar" value="" id="author_avatar">
                            <img class="mt-2" id="author_avatar_preview" style="display:none;" height="100"/>
                            @endif
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
                        <div class="card-body">
                            <div class="form-group">
                                <label class="font-weight-semibold">Điểm đánh giá</label>
                                <input type="text" class="form-control mask-decimal" value="{{old('star_rating')?:($record->star_rating??'')}}" name="star_rating">
                                @error('star_rating')
                                <label id="star_rating-error" class="validation-invalid-label" for="star_rating">{{$message}}</label>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection