@extends('layouts.admin')
@section('content')
@if (isset($record))
<form method="POST" action="{{route('admin.post.update',$record->id)}}">
    @method('PUT')
@else
<form method="POST" action="{{route('admin.post.store')}}">
@endif
    @csrf
    <div class="content">
        <div class="d-flex align-items-start flex-column flex-md-row">
            <div class="w-100 overflow-auto order-2 order-md-1">
				<div class="card">
					<div class="card-body">
                        <div class="form-group">
                            <label class="font-weight-semibold">Tiêu đề <span class="required"></span></label>
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
                            <label class="font-weight-semibold">Ảnh bài viết </label>
                            <input type="file" class="form-control-file" data-key="image" data-fouc>
                            @if(old('image'))
                            <input type="hidden" name="image" value="{{old('image')}}" id="image">
                            <img class="mt-2" id="image_preview" height="100" src="{{old('image')}}"/>
                            @elseif (isset($record) && $record->images)
                            <input type="hidden" name="image" value="{{$record->images->first()->url??''}}" id="image">
                            <img class="mt-2" id="image_preview" height="100" src="{{$record->images->first()->url??''}}"/>
                            @else
                            <input type="hidden" name="image" value="{{asset('hocvienielts/images/no-image.jpg')}}" id="image">
                            <img class="mt-2" id="image_preview" style="display:none;" height="100"/>
                            @endif
                            @error('image')
                            <label id="image-error" class="validation-invalid-label" for="image">{{$message}}</label>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="font-weight-semibold">Từ khoá chính <span class="required"></span></label>
                            <input type="text" class="form-control maxlength" maxlength="255" required id="keyword" name="keyword" value="{{ old('keyword') ?: ($record->keyword ?? '') }}">
                        </div>

                        <div class="form-group">
                            <label class="font-weight-semibold">Thẻ</label>
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
                            <div id="SEO"> <b>PHÂN TÍCH SEO:</b>
                    <div id="issue_seo"> Các vấn đề cần khác phục:
                    <ul>
                        <li class="issue_title"><b>Tiêu đề chứa từ khoá:</b> Cần sửa tiêu đề có chứa từ khoá</li>
                        <li class="issue_description"><b>Mô tả chứa từ khoá:</b> Cần sửa mô tả ngắn có chứa từ khoá</li>
                        {!! $issue ?? '' !!}
                      <!--  <li class="issue_internallinks"><b>Các đường dẫn nội bộ:</b> Cần thêm link nội bộ tới chính trang của bạn!</li>
                        <li class="issue_outlinks"><b>Các đường dẫn ra ngoài trang:</b> Cần thêm link dẫn tới trang ngoài!</li>
                        <li class="issue_images"><b>Thuộc tính alt của các ảnh:</b> Ảnh chưa có thuộc tính alt!</li>
                        <li class="issue_words"><b>Độ dài của văn bản:</b> </li>
                        <li class="issue_heading"><b>Độ rộng của tiêu đề SEO:</b> </li> -->
                    </ul>
                    </div>
                    <div id="success_seo">
                    Kết quả tốt:
                        <li class="success_title"><b>Tiêu đề chứa từ khoá:</b> Rất tốt!</li>
                        <li class="success_description"><b>Mô tả chứa từ khoá:</b> Rất tốt!</li>
                        <li class=""><b>Độ dài mô tả meta:</b> Rất tốt!</li>
                        {!! $success ?? '' !!}
                      <!--  <li class="success_internallinks"><b>Các đường dẫn nội bộ:</b> Bạn đã có đủ các đường dẫn nội bộ. Rất tốt!</li>
                        <li class="success_outlinks"><b>Các đường dẫn ra ngoài trang:</b> Rất tốt!</li>
                        <li class="success_images"><b>Thuộc tính alt của các ảnh:</b> Rất tốt!</li>
                        <li class="success_words"><b>Độ dài của văn bản:</b> </li>
                        <li class="success_heading"><b>Độ rộng của tiêu đề SEO:</b> Rất tốt</li> -->
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
                        <div class="card-body text-center">
                            <div class="form-check form-check-inline disabled">
                                <label class="form-check-label">
                                    <input type="radio" class="form-input-styled" {{isset($record) && $record->is_promotion == 1 ? 'checked' : ''}} name="is_promotion" value="1" checked data-fouc>
                                    Tin khuyến mại
                                </label>
                            </div>

                            <div class="form-check form-check-inline disabled">
                                <label class="form-check-label">
                                    <input type="radio" class="form-input-styled" {{isset($record) && $record->is_promotion == 0 ? 'checked' : ''}} name="is_promotion" value="0" data-fouc>
                                    Tin tức
                                </label>
                            </div>	
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body" id="select_category">
                            @include('admin.shared.select-category',['selected' => (isset($record) ? $record->categories->pluck('id')->all() : null)])
                            @error('category_id')
                            <label id="category_id-error" class="validation-invalid-label" for="category_id">{{$message}}</label>
                            @enderror
                            <button class="add-category btn btn-sm mt-2 btn-success" type="button">
                                <i class="icon-plus-circle2"></i>
                                Tạo chuyên mục
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<div id="modal_add_category" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="form_add_category">
                @csrf
                <div class="modal-body">
                    <h3>Tạo mới chuyên mục</h3>
                    <div class="form-group">
                        <input type="text" name="name" placeholder="Tiêu đề" class="form-control" required maxlength="255">
                    </div>

                    <div class="form-group">
                        @if(count($categories))
                        <select name="parent_id" data-placeholder="Chuyên mục cha" class="form-control select" data-allow-clear="true">
                            <option value="">Chuyên mục cha</option>
                            @foreach($categories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                        @endif
                    </div>
                    
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn bg-primary">Lưu</button>
                </div>
            </form>
        </div>
    </div>
</div>
<style>
#issue_seo 
{
    color: red;
}
#success_seo
{
    color: green;
}
</style>
<script>
    var intervalId = window.setInterval(function(){
        let title = $('#title').val();
        let description = $('#title').val();
        let content = $("#content").html();
        var isoutlinks = 0;
        var isinlinks = 0;
       // check title 
        if (title.includes($('#keyword').val()))
        {
            $('.success_title').show();
            $('.issue_title').hide();
        }
        else
        {
           $('.issue_title').show();
           $('.success_title').hide();
        }
        // check description 
        if (description.includes($('#keyword').val()))
        {
            $('.success_description').show();
            $('.issue_description').hide();
        }
        else
        {
           $('.issue_description').show();
           $('.success_description').hide();
        }
        //if(!$('iframe a').length > 0)
//        {
//            $('.issue_internallinks').show();
//            $('.issue_outlinks').show();
//            $('.success_outlinks').hide();
//            $('.success_internallinks').hide();
//            console.log($('iframe a').length);
//        }
//        else
//        {
//            $('iframe a').each(function(links)
//            {
//                console.log($(this).attr('href'));
//                if ($(this).attr('href').includes('hocvienielts.edu.vn'))
//                {
//                    isinlinks = 1;
//                    $('.success_internallinks').show();
//                $('.issue_internallinks').hide();
//                }
//                if (!$(this).attr('href').includes('hocvienielts.edu.vn'))
//                {
//                    isoutlinks = 1;
//                    $('.success_outlinks').show();
//                $('.issue_outlinks').hide();
//                }
//            });
 //           if (isinlinks)
//            {
//                $('.success_internallinks').show();
//                $('.issue_internallinks').hide();
//            }
//            if (isoutlinks)
//            {
//                 $('.success_outlinks').show();
//                $('.issue_outlinks').hide();
//            }
       // }
    },1000);
    $('#modal_add_category form').on('submit', function(e) {
        e.preventDefault()
        let selected = $('[name^=category_id]:checked').map(function(){return this.value;}).get()
        $.ajax({
            url:'{{route('admin.post.category')}}',
            method:'POST',data: new FormData(this),
            contentType:false,processData:false,
            success:function(resp) {
                $('#modal_add_category').modal('hide')
                $('#select_category').html(resp)
                $('#select_category [name^=category_id]').each(function(){
                    $(this).prop('checked', selected.includes(this.value))
                })
                $('#select_category .form-input-styled').uniform()
                $.uniform.update()
            }
        })
    })
    $('body').on('click','.add-category', function() {
        $('#modal_add_category').modal('show')
    });
</script>
@endsection