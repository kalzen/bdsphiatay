@extends('layouts.admin')
@section('content')
@if (isset($record))
<form method="POST" action="{{route('admin.catalogue.update',$record->id)}}">
    @method('PUT')
@else
<form method="POST" action="{{route('admin.catalogue.store')}}">
@endif
    @csrf
    <div class="content">
        <div class="d-flex align-items-start flex-column flex-md-row">
            <div class="w-100 overflow-auto order-2 order-md-1">
				<div class="card">
					<div class="card-body">
                        <div class="form-group">
                            <label class="font-weight-semibold">Tiêu đề <span class="required"></span></label>
                            <input type="text" class="form-control" required id="name" name="name" value="{{ old('name') ?: ($record->name ?? '') }}">
                            @error('name')
                            <label id="name-error" class="validation-invalid-label" for="name">{{$message}}</label>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="font-weight-semibold">Mô tả</label>
                            <textarea class="form-control" name="description">{{ old('description') ?: ($record->description ?? '') }}</textarea>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-semibold">Ảnh </label>
                            <input type="file" class="form-control-file" data-key="image" data-fouc>
                            @if(old('image'))
                            <input type="hidden" name="image" value="{{old('image')}}" id="image">
                            <img class="mt-2" id="image_preview" height="100" src="{{old('image')}}"/>
                            @elseif (isset($record) && $record->image)
                            <input type="hidden" name="image" value="{{$record->image->url}}" id="image">
                            <img class="mt-2" id="image_preview" height="100" src="{{$record->image->url}}"/>
                            @else
                            <input type="hidden" name="image" value="" id="image">
                            <img class="mt-2" id="image_preview" style="display:none;" height="100"/>
                            @endif
                            @error('image')
                            <label id="image-error" class="validation-invalid-label" for="image">{{$message}}</label>
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
                            <label class="font-weight-semibold">Nội dung chi tiết</label>
                            <textarea class="ckeditor form-control" id="content" name="content">{{ old('content') ?: ($record->content ?? '') }}</textarea>
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
                            <label>Chuyên mục cha</label>
                            @include('admin.shared.select-parent-catalogue',['selected' => (isset($record) ? $record->parent_id : null)])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    
</script>
@endsection