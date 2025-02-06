@extends('admin.master')
@section('content')
<div class="col-12">
    <div data-label="Example" class="df-example demo-forms">
    <form method="POST" action="{{route('admin.warranty.store')}}">
            @csrf
            <div class="form-group">
                <label class="d-block">Tên khách hàng</label>
                <input type="text" name="name" class="form-control" placeholder="Nhập tên khách hàng">
            </div>
            <div class="form-group">
                <label class="d-block">Số điện thoại</label>
                <input type="text" name="phone" class="form-control" placeholder="Nhập số điện thoại khách hàng">
            </div>
            <div class="form-group">
                <label class="d-block">Sản phẩm</label>
                <input type="text" name="product" class="form-control" placeholder="Nhập tên sản phẩm">
            </div>
            <div class="form-group">
                <label class="d-block">Địa chỉ chi nhánh</label>
                <input type="text" name="branch" class="form-control" placeholder="">
            </div>
            <div class="form-group">
                <label class="d-block">Thời gian tạo đơn hàng</label>
                <input type="datetime-local" format="d/m/y hh:mm:ss" name="start" class="form-control" placeholder="">
            </div>
            <button class="btn btn-primary" type="submit">Thêm mới</button>
        </form>
    </div>
</div>
@endsection