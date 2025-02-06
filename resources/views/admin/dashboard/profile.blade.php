@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-body">
            @include('admin.partials.message')
            <form action="{{route('admin.profile')}}" method="POST">
                @csrf

                <div class="form-group">
                    <label class="font-weight-semibold">Tên <span class="required"></span></label>
                    <input type="text" class="form-control" required id="name" name="name" value="{{ old('name') ?: auth()->user()->name }}">
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-primary">Lưu <i class="icon-paperplane ml-2"></i></button>
                </div>
            </form>
        </div>
    </div>
<script>
    
</script>
@endsection