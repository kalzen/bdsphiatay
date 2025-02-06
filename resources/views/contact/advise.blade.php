@extends('layouts.master')
@section('meta')
<title>Liên hệ - {{env('APP_NAME')}}</title>
<meta name="keywords" content="{{env('APP_NAME')}}" />
<meta name="description" content="{{env('APP_NAME')}}" />
<meta property="og:image" content="{{env('APP_LOGO')}}">
<meta property="og:type" content="website">
<meta property="og:title" content="{{env('APP_NAME')}}">
<meta property="og:description" content="{{env('APP_NAME')}}">
@stop
@section('content')
<div class="content-wrap ">
    <div class="pt-190 pb-130 bg-contact" style="background-image: url({{ asset('hocvienielts/bg-contact.jpg') }})">
        <!-- Shape-->
        <div class="container">
            <h1 class="m-0 text-center mb-100" data-show="startbox">{{  $shared_config['contact_title']->value }}</h1>

            <div class="row gy-30 d-flex">
                <div class="col-lg-6 d-none d-lg-block h-100">
                    <img src="{{asset('hocvienielts/images/khoa-3.JPG')}}" class="w-100 img-responsive">
                </div>
                <div class="col-lg-6">
                    <form class="bg-primary-dark form-contact form-reg" action="{{ route('contact') }}" method="post">
                        @csrf
                        <div class="row align-items-center gy-3">
                            <div class="col-lg-12">
                                <div class="row g-20">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label visually-hidden" for="form-reg-name">Họ và
                                                tên</label>
                                            <input class="form-control" id="form-reg-name" name="name" type="text"
                                                placeholder="Họ và tên">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label visually-hidden" for="form-reg-phonenumber">Số điện
                                                thoại</label>
                                            <input class="form-control" id="form-reg-phonenumber" name="mobile"
                                                type="text" placeholder="Số điện thoại">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label visually-hidden" for="form-reg-Email">Email</label>
                                            <input class="form-control" id="form-reg-Email" name="email" type="email"
                                                placeholder="Email">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label visually-hidden" for="form-reg-work">Band điểm mục
                                            tiêu?</label>
                                        <select class="form-select form-select-default" id="form-reg-work"
                                            name="target">
                                            <option selected="selected" value="0">Band điểm của bạn</option>
                                            <option value="0 - 4.5">0 - 4.5</option>
                                            <option value="5.0 - 5.5">5.0 - 5.5</option>
                                            <option value="6.0 - 6.5">6.0 - 6.5</option>
                                            <option value="7.0 +">7.0 +</option>
                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label visually-hidden" for="form-reg-address">Nội dung cần tư
                                            vấn?</label>
                                        <select class="form-select form-select-default" id="form-reg-address"
                                            name="content">
                                            <option selected="selected" value="0">Nội dung bạn cần tư vấn</option>
                                            <option value="Test năng lực">Test năng lực</option>
                                            <option value="Tư vấn khóa học IELTS">Tư vấn khóa học IELTS</option>
                                            <option value="Đăng ký thi thử IELTS">Đăng ký thi thử IELTS</option>
                                            <option value="Khác">Khác</option>
                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <button class="btn btn-primary text-uppercase shadow-sm w-100"
                                            type="submit">Nhận tư
                                            vấn</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
$(function() {
    console.log('Contact ready')
})
</script>

@endsection