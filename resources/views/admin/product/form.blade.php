@extends('layouts.admin')
@section('content')
@if (isset($record))
<form method="POST" action="{{route('admin.product.update',$record->id)}}">
    @method('PUT')
@else
<form method="POST" action="{{route('admin.product.store')}}">
@endif
    @csrf
    <div class="content">
        <div class="d-flex align-items-start flex-column flex-md-row">
            <div class="w-100 overflow-auto order-2 order-md-1">
				<div class="card">
					<div class="card-body">
                        <div class="form-group">
                            <label class="font-weight-semibold">Tên dự án <span class="required"></span></label>
                            <input type="text" class="form-control maxlength" maxlength="255" required id="title" name="title" value="{{ old('title') ?: ($record->title ?? '') }}">
                            <span class="text-muted">Most optimal 10 - 70 characters.</span>
                            @error('title')
                            <label id="title-error" class="validation-invalid-label" for="title">{{$message}}</label>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="font-weight-semibold">Mô tả</label>
                            <textarea class="form-control maxlength" maxlength="1500" name="description">{{ old('description') ?: ($record->description ?? '') }}</textarea>
                            <span class="text-muted">Most optimal 160 - 300 characters.</span>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-semibold">Files<span class="required"></span></label>
                            <input type="file" class="form-control-file" multiple data-key="images" data-fouc>
                            @if(old('images'))
                            <input class="form-control" type="hidden" name="images" value="{{old('images')}}" id="images">
                            @elseif (isset($record) && $record->images->first()->url)
                            <input class="form-control" type="hidden" name="images" value="{{ $record->images->first()->url}}" id="images">
                            @else
                            <input class="form-control" type="hidden" name="images" value="" id="images">
                            @endif
                            @error('images')
                            <label id="image-error" class="validation-invalid-label" for="images">{{$message}}</label>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="font-weight-semibold">Từ khóa</label>
                            @if(old('tags'))
                            <input type="text" class="form-control tokenfield" value="{{old('tags')}}" name="tags" data-fouc>
                            @elseif(isset($record) && $record->tags)
                            <input type="text" class="form-control tokenfield" value="{{$record->tags->pluck('name')->join(', ')}}" name="tags" data-fouc>
                            @else
                            <input type="text" class="form-control tokenfield" value="" name="tags" data-fouc>
                            @endif
                        </div>

                        <div class="form-group">
                            <label class="font-weight-semibold">Nội dung bài viết <span class="required"></span></label>
                            <textarea class="ckeditor form-control" id="content" name="content" required>{{ old('content') ?: ($record->content ?? '') }}</textarea>
                            @error('content')
                            <label id="content-error" class="validation-invalid-label" for="content">{{$message}}</label>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="font-weight-semibold">Nội dung sale <span class="required"></span></label>
                            <textarea class="ckeditor form-control" id="sale_content" name="sale_content" required>{{ old('sale_content') ?: ($record->sale_content ?? '') }}</textarea>
                            @error('sale_content')
                            <label id="content-error" class="validation-invalid-label" for="sale_content">{{$message}}</label>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="font-weight-semibold">Thuộc tính </label>
                            <div>
                                @include('admin.shared.select-attribute',['record'=>isset($record)?$record:null,'selected' => (isset($record) ? $record->attributes->pluck('id')->all() : null)])
                            </div>
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
                                    Đăng
                                </label>
                            </div>

                            <div class="form-check form-check-inline disabled">
                                <label class="form-check-label">
                                    <input type="radio" class="form-input-styled" {{isset($record) && $record->status == 0 ? 'checked' : ''}} name="status" value="0" data-fouc>
                                    Ẩn
                                </label>
                            </div>	
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label class="font-weight-semibold">Giá</label>
                                @if(old('price'))
                                <input type="text" class="form-control" value="{{old('price')}}" name="price">
                                @elseif(isset($record) && $record->price)
                                <input type="text" class="form-control" value="{{$record->price}}" name="price">
                                @else
                                <input type="text" class="form-control" value="" name="price">
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label class="font-weight-semibold">Chức năng</label> </br>
                                @foreach ($plans as $plan)
                                @if (isset($record->plans))
                                    @foreach ($record->plans as $plan_product)
                                        <input type="checkbox" value="{{$plan->id}}" @if($plan_product->id == $plan->id) checked @endif name="plan_id[]"> {{$plan->name}} </br>
                                    @endforeach
                                @else
                                <input type="checkbox" value="{{$plan->id}}" name="plan_id[]"> {{$plan->name}} </br>
                                @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body" id="select_ward">
                        <div class="form-group">
                        <label class="font-weight-semibold">Phường/Xã</label>
                        <select class="form-select select" name="ward_id">
                            <option value="0">--Chọn Phường/Xã--</option>
                            
                        @foreach ($wards as $ward)
                            <option @if(isset($record)&& $record->ward_id == $ward->id) selected @endif value="{{$ward->id}}">{{$ward->name}}</option>
                        @endforeach
                        </select>
                        
                        </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body" id="select_user">
                        <div class="form-group">
                        <label class="font-weight-semibold">Người phụ trách</label>
                        <select class="form-select select" name="user_id">
                            
                        @foreach ($users as $user)
                            <option @if(isset($record)&& $record->user_id == $user->id) selected @endif value="{{$user->id}}">{{$user->name}}</option>
                        @endforeach
                        </select>
                        
                        </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body" id="select_category">
                            @include('admin.shared.select-category',['selected' => (isset($record) ? $record->catalogues->pluck('id')->all() : null)])
                            <button class="add-category btn btn-sm mt-2 btn-success" type="button">
                                <i class="icon-plus-circle2"></i>
                                Tạo danh mục
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection