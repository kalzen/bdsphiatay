@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-body">
            @include('admin.partials.message')
            <div class="row mb-3">
                <div class="col-md-8">
                    <a class="btn btn-success" href="{{route('admin.product.create')}}"><i class="icon-plus-circle2"></i> Thêm mới</a>
                </div>
                <div class="col-md-4">
                    <form action="{{route('admin.product.index')}}" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Tìm kiếm theo tên...">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @if(count($records))
            <div class="card card-table table-responsive shadow-0 mb-0">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Ảnh</th>
                            <th>Tên dự án</th>
                            <th>Từ khóa</th>
                            <th>Giá</th>
                            <th>Thời gian</th>
                            <th>Lượt xem</th>
                            <th>Trạng thái</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($records as $record)
                        <tr>
                            <td>
                                <input type="checkbox" name="ids[]" value="{{$record->id}}" class="form-input-styled">
                            </td>
                            <td>
                                @if($record->images->count())
                                <img src="{{$record->images->first()->url}}" height="50">
                                @endif
                            </td>
                            <td>
                                <a href="{{route('admin.product.edit', $record->id)}}">{{$record->title}}</a>
                            </td>
                            <td>
                                {{$record->tags->pluck('name')->join(', ')}}
                            </td>
                            <td>
                                <span>{{$record->price}}</span>
                            </td>
                            <td class="text-center">
                                {{date('d/m/Y',strtotime($record->created_at))}}
                                @if($record->updated_at)
                                <br>({{date('d/m/Y',strtotime($record->updated_at))}})
                                @endif
                            </td>
                            <td class="text-center">
                                {{number_format($record->viewed,0)}}
                            </td>
                            <td class="text-center">
                                @if($record->status)
                                <span class="badge bg-success">Đăng</span>
                                @else
                                <span class="badge bg-secondary">Ẩn</span>
                                @endif
                            </td>
                            <td>
                                <a href="javascript:;" class="js-delete text-danger" data-key="{{$record->id}}" title="Xóa"><i class="icon-trash"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-2">
                {{$records->links()}}
            </div>
            @else
            <div class="text-center p-5">
                <img src="/assets/img/no-data.png" alt="" srcset="">
                <p class="h4 mt-2 font-weight-semibold">Chưa có bài viết nào</p>
            </div>
            @endif
        </div>
    </div>
    <!-- /bordered card body table -->
<script>
    
    $('.js-delete').on('click', function() {
        let id = $(this).data('key')
        swal({
            title: 'Bạn chắc chắn muốn xóa?',
            text: "Thao tác sẽ không thể hoàn tác!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Xác nhận xóa!',
            cancelButtonText: 'Hủy',
            confirmButtonClass: 'btn btn-danger',
            cancelButtonClass: 'btn btn-default',
            buttonsStyling: false
        }).then(function (res) {
            if (res.value) {
                $.ajax({
                    url: '{{route('admin.product.destroy','idx')}}'.replace(/idx/, id),
                    method:'DELETE',data:{_token:'{{csrf_token()}}'},dataType:'json',
                    success:function(resp) {
                        toastr[resp.success ? 'success' : 'danger'](resp.message)
                        location.reload()
                    }
                })
            }
        }, function (dismiss) {});
    });
</script>
@endsection