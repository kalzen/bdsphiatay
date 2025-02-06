@extends('layouts.admin')
@php
use App\Models\User;
@endphp
@section('content')
    <div class="card">
        <div class="card-body">
            @include('admin.partials.message')
            <a class="btn mb-2 btn-success" href="{{route('admin.user.create')}}"><i class="icon-plus-circle2"></i> Thêm mới</a>
            @if(count($records))
            <div class="card card-table table-responsive shadow-0 mb-0">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Avatar</th>
                            <th>Email</th>
                            <th>Tên</th>
                            <th>Quyền</th>
                            <th>Ngày tạo</th>
                            <th>Bài viết</th>
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
                            <img class="mt-2" id="image_preview" height="100" src="{{$record->images->first()->url??''}}"/>
                            </td>
                            <td>
                                <a href="{{route('admin.user.edit', $record->id)}}">{{$record->email}}</a>
                            </td>
                            <td>
                                <a href="{{route('admin.user.edit', $record->id)}}">{{$record->name}}</a>
                            </td>
                            <td>
                                {{$record->role->name}}
                            </td>
                            <td class="text-center">
                                {{date('d/m/Y',strtotime($record->created_at))}}
                            </td>
                            <td class="text-center">
                                {{$record->posts()->count()}}
                            </td>
                            <td class="text-center">
                                @if($record->status)
                                <span class="badge bg-success">Hoạt động</span>
                                @else
                                <span class="badge bg-secondary">Khóa</span>
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
                <p class="h4 mt-2 font-weight-semibold">Chưa có thành viên nào</p>
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
                    url: '{{route('admin.user.destroy','idx')}}'.replace(/idx/, id),
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