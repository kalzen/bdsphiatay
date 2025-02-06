@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-body">
            @include('admin.partials.message')
            @if(count($records))
            <div class="card card-table table-responsive shadow-0 mb-0">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Ảnh sản phẩm</th>
                            <th>Tên sản phẩm</th>
                            <th>Mã đơn hàng</th>
                            <th>Tên</th>
                            <th>SĐT</th>
                            <th>Địa chỉ</th>
                            <th>Ghi chú</th>
                            <th>Ngày</th>
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
                                @if($record->details&&$record->details()->first())
                                <img src="{{$record->details()->first()->product->images()->first()->url??''}}" height="50">
                                @endif
                            </td>
                            <td>
                                @if($record->details&&$record->details()->first())
                                <a target="_blank" href="{{$record->details()->first()->product->url??''}}">{{$record->details()->first()->product->title??''}}</span>
                                @endif
                            </td>
                            <td>
                                <code>{{$record->code}}</code>
                            </td>
                            <td>
                            {{$record->name}}
                            </td>
                            <td>
                            {{$record->phone}}
                            </td>
                            <td>
                            {{$record->address}}
                            </td>
                            <td>
                                {{$record->note}}
                            </td>
                            <td class="text-center">
                                {{date('d/m/Y',strtotime($record->created_at))}}
                                @if($record->updated_at)
                                <br>({{date('d/m/Y',strtotime($record->updated_at))}})
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
                <p class="h4 mt-2 font-weight-semibold">Chưa có đơn hàng nào</p>
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
                    url: '{{route('admin.order.destroy','idx')}}'.replace(/idx/, id),
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