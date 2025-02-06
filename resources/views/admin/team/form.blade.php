@extends('layouts.admin')
@section('content')
@if (isset($record))
<form method="POST" action="{{route('admin.team.update',$record->id)}}">
    @method('PUT')
@else
<form method="POST" action="{{route('admin.team.store')}}">
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
                            <label id="name-error" class="validation-invalid-label" for="name">{{$message}}</label>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="font-weight-semibold">Ảnh </label>
                            <input type="file" class="form-control-file" data-key="image" data-fouc>
                            @if(old('image'))
                            <input type="hidden" name="image" value="{{old('image')}}" id="image">
                            <img class="mt-2" id="image_preview" height="100" src="{{old('image')}}"/>
                            @elseif (isset($record) && $record->image)
                            <input type="hidden" name="image" value="{{$record->image??''}}" id="image">
                            <img class="mt-2" id="image_preview" height="100" src="{{$record->image??''}}"/>
                            @else
                            <input type="hidden" name="image" value="" id="image">
                            <img class="mt-2" id="image_preview" style="display:none;" height="100"/>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="font-weight-semibold">Mô tả <span class="required"></span></label>
                            <textarea class=" form-control" id="description" name="description" required>{{ old('description') ?: ($record->description ?? '') }}</textarea>
                            @error('description')
                            <label id="description-error" class="validation-invalid-label" for="description">{{$message}}</label>
                            @enderror
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Lưu <i class="icon-paperplane ml-2"></i></button>
                        </div>
                    </div>
				</div>
            </div>
        </div>
    </div>
</form>
@endsection