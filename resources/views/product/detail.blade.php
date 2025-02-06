@extends('layouts.master')
@section('meta')
<title>{{$product->title}}</title>
<meta name="keywords" content="{{collect($product->tags)->pluck('name')->join(',')}}"/>
<meta name="description" content="{{substr(strip_tags($product->description),0,300)}}"/>
<meta property="og:image" content="{{$product->images()->first()->url??''}}">
<meta property="og:type" content="product">
<meta property="og:title" content="{{$product->title}}">
<meta property="og:description" content="{{substr(strip_tags($product->description),0,300)}}">
@stop
@section('styles')

@endsection
@section('content')
<section class="flat-title " >
                <div class="container">
                    <div class="row">                      
                        <div class="col-lg-12">
                            <div class="title-inner style-detail">
                                <div class="title-group fs-12"><a class="home fw-6 text-color-3" href="{{route('index')}}">Trang chủ</a><span >{{$product->title}}</span></div>
                            </div>
                        </div> 
                    </div>
                </div>
            </section>

            <section class="flat-slider01 style" >
                <div class="container">
                    <div class="row">                      
                        <div class="col-lg-12">
                            <div class="swiper-container thumbs-swiper-row">
                                <div class="swiper-wrapper">
                                @foreach($product->images as $image)
                                    <div class="swiper-slide">
                                        <div class="image-detail">
                                            <img src="{{$image->url}}" alt="{{$product->title}}">
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div thumbsSlider="" class="swiper-container thumbs-swiper-row1">
                                <div class="swiper-wrapper">
                                @foreach($product->images as $image)
                                    <!--<div class="swiper-slide">
                                        <div class="image-detail">
                                            <img src="{{$image->url}}" alt="{{$product->title}}">
                                        </div>
                                    </div> -->
                                @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
           
            <section class="flat-property-detail property-detail2 style2" >
                <div class="container">
                    <div class="row">                      
                        <div class="col-lg-8">
                            <div class="post">
                                <div class="wrap-text wrap-style">
                                    <div class="titles"><h3>Nội dung dự án</h3></div>
                                    {!! $product->content !!}
                                </div>
                                <div class="wrap-property wrap-style">
                                    <div class="titles"><h3>Chi tiết dự án</h3></div>
                                    <div class="box flex">
                                        <ul>
                                        @foreach($product->attributes as $attribute_item)
                                            <li class="flex"><span class="one fw-6">{{ $attribute_item->name }}</span><span class="two">{{$attribute_item->pivot->value}}</span></li>
                                          
                                            @if($loop->iteration == floor(count($product->attributes)/2))
                                            </ul><ul>
                                            @endif
                                        @endforeach
                                        </ul>
                                    </div>                              
                                </div>
                               <!-- <div class="wrap-featured wrap-style tf-amenities">
                                    <div class="titles"><h3>Featured</h3></div>
                                    <div class="box-featured flex">
                                        <div class="inner-1">
                                            <div class="subtitle title-1 fw-6">Outdoor features</div>
                                            <label class="flex"><input name="newsletter" type="checkbox" checked /> 
                                                <span class="btn-checkbox"></span><span class="fs-13">Swimming pool</span> 
                                            </label>
                                            <label class="flex"><input name="newsletter" type="checkbox" checked /> 
                                                <span class="btn-checkbox"></span><span class="fs-13">Balcony</span> 
                                            </label>
                                            <label class="flex"><input name="newsletter" type="checkbox" checked /> 
                                                <span class="btn-checkbox"></span><span class="fs-13">Undercover parking</span> 
                                            </label>
                                        </div>
                                        <div class="inner-2">
                                            <label class="flex"><input name="newsletter" type="checkbox" checked /> 
                                                <span class="btn-checkbox"></span><span class="fs-13">Tennis court</span> 
                                            </label>
                                            <label class="flex"><input name="newsletter" type="checkbox" checked /> 
                                                <span class="btn-checkbox"></span><span class="fs-13">Garage</span> 
                                            </label>
                                            <label class="flex"><input name="newsletter" type="checkbox" checked /> 
                                                <span class="btn-checkbox"></span><span class="fs-13">Outdoor area</span> 
                                            </label>
                                        </div>
                                        <div class="inner-3">
                                            <div class="subtitle title-1 fw-6">Indoor features</div>
                                            <label class="flex"><input name="newsletter" type="checkbox" checked /> 
                                                <span class="btn-checkbox"></span><span class="fs-13">Ensuite</span> 
                                            </label>
                                            <label class="flex"><input name="newsletter" type="checkbox" checked /> 
                                                <span class="btn-checkbox"></span><span class="fs-13">Study</span> 
                                            </label>
                                            <label class="flex"><input name="newsletter" type="checkbox" checked /> 
                                                <span class="btn-checkbox"></span><span class="fs-13">Alarm system</span> 
                                            </label>
                                        </div>
                                        <div class="inner-4">
                                            <label class="flex"><input name="newsletter" type="checkbox" checked /> 
                                                <span class="btn-checkbox"></span><span class="fs-13">Dishwasher</span> 
                                            </label>
                                            <label class="flex"><input name="newsletter" type="checkbox" checked /> 
                                                <span class="btn-checkbox"></span><span class="fs-13">Built in robes</span> 
                                            </label>
                                            <label class="flex"><input name="newsletter" type="checkbox" checked /> 
                                                <span class="btn-checkbox"></span><span class="fs-13">Broadband</span> 
                                            </label>
                                        </div>
                                    </div>
                                </div> -->
                                <!--
                                <div class="wrap-map wrap-property wrap-style">
                                    <div class="titles"><h3>Map location</h3></div>
                                    <iframe class="map-content" src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d7302.453092836291!2d90.47477022812872!3d23.77494577893369!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1svi!2s!4v1627293157601!5m2!1svi!2s" allowfullscreen="" loading="lazy"></iframe>                            
                                </div> -->
                                <!--<div class="wrap-video wrap-style">
                                    <div class="titles"><h3>Video</h3></div>
                                    <div class="video-box center ">
                                        <div class="post-video flex align-center justify-center relative">      
                                            <img class="img-2" src="{{asset('phiatay/assets/images/img-box/property-video2.jpg')}}" alt="images">                       
                                            <a href="https://youtu.be/MLpWrANjFbI" class="lightbox-image">                              
                                                <svg width="11" height="14" viewBox="0 0 11 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M11 7L3.41715e-07 14L9.53674e-07 -4.80825e-07L11 7Z" fill="#FFA920"/>
                                                </svg>
                                                <i class="ripple"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div> -->
                                @if(Auth::guest())
                                @else
                                <div class="wrap-map wrap-property wrap-style">
                                    <div class="titles"><h3>Thông tin sale</h3></div>
                                    {!! $product->sale_content !!}
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <aside class="side-bar side-bar-1">
                                <div class="inner-side-bar">  
                                    <div class="widget-rent style">
                                        <h3 class="widget-title title-contact">
                                            Nhân viên sale
                                        </h3>
                                        <div class="author-box flex align-center">
                                            <div class="image-author flex-none">
                                                <img src="{{$product->user->images->first()->url??''}}" alt="images">
                                            </div>
                                            <div class="content">
                                                <p class="text-color-2">{{$product->user->name}}</p>
                                                <h5 class="link-style-1"><a href="tel:{{$product->user->phone}}">{{$product->user->phone}}</a></h5>
                                                <a class="fs-12 lh-18" href="mailto:{{$product->user->email}}">{{$product->user->email}}</a>
                                            </div>
                                        </div>
                                        <div class="comments">
                                            <div class="comment-form">
                                                <form method="post">
                                                    <div class="wd-find-select ">
                                                        
                                                        <div class="button-box sc-btn-top center flex justify-space">
                                                            <a href="mailto:{{$product->user->email}}" class="sc-button btn-svg">
                                                                <span>Email</span>
                                                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M1.125 6.5025V12.9375C1.125 13.5342 1.36205 14.1065 1.78401 14.5285C2.20597 14.9504 2.77826 15.1875 3.375 15.1875H14.625C15.2217 15.1875 15.794 14.9504 16.216 14.5285C16.6379 14.1065 16.875 13.5342 16.875 12.9375V6.5025L10.179 10.6223C9.82443 10.8404 9.4163 10.9559 9 10.9559C8.5837 10.9559 8.17557 10.8404 7.821 10.6223L1.125 6.5025Z" fill="white"></path>
                                                                    <path d="M16.875 5.181V5.0625C16.875 4.46576 16.6379 3.89347 16.216 3.47151C15.794 3.04955 15.2217 2.8125 14.625 2.8125H3.375C2.77826 2.8125 2.20597 3.04955 1.78401 3.47151C1.36205 3.89347 1.125 4.46576 1.125 5.0625V5.181L8.4105 9.6645C8.58778 9.77357 8.79185 9.83132 9 9.83132C9.20815 9.83132 9.41222 9.77357 9.5895 9.6645L16.875 5.181Z" fill="white"></path>
                                                                </svg>
                                                            </a>
                                                            <a class="sc-button btn-1 btn-svg" href="tel:{{$product->user->phone}}">
                                                                <span>Gọi điện</span>
                                                                <svg width="19" height="18" viewBox="0 0 19 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M15.125 7.31249C15.125 7.46168 15.0657 7.60475 14.9602 7.71024C14.8548 7.81573 14.7117 7.87499 14.5625 7.87499H11.1875C11.0383 7.87499 10.8952 7.81573 10.7898 7.71024C10.6843 7.60475 10.625 7.46168 10.625 7.31249V3.93749C10.625 3.78831 10.6843 3.64523 10.7898 3.53975C10.8952 3.43426 11.0383 3.37499 11.1875 3.37499C11.3367 3.37499 11.4798 3.43426 11.5852 3.53975C11.6907 3.64523 11.75 3.78831 11.75 3.93749V5.95499L15.29 2.41499C15.3415 2.35973 15.4036 2.3154 15.4726 2.28466C15.5416 2.25391 15.6161 2.23738 15.6916 2.23605C15.7671 2.23472 15.8422 2.24861 15.9122 2.2769C15.9822 2.30519 16.0459 2.3473 16.0993 2.40071C16.1527 2.45413 16.1948 2.51775 16.2231 2.5878C16.2514 2.65784 16.2653 2.73286 16.2639 2.80839C16.2626 2.88391 16.2461 2.9584 16.2153 3.0274C16.1846 3.0964 16.1403 3.1585 16.085 3.20999L12.545 6.74999H14.5625C14.7117 6.74999 14.8548 6.80926 14.9602 6.91475C15.0657 7.02024 15.125 7.16331 15.125 7.31249Z" fill="#1C1C1E"></path>
                                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M1.625 3.375C1.625 2.77826 1.86205 2.20597 2.28401 1.78401C2.70597 1.36205 3.27826 1.125 3.875 1.125H4.904C5.549 1.125 6.1115 1.5645 6.26825 2.19L7.097 5.50725C7.16416 5.77575 7.15059 6.05809 7.058 6.31892C6.96542 6.57974 6.79792 6.80744 6.5765 6.9735L5.60675 7.701C5.5055 7.77675 5.48375 7.88775 5.51225 7.965C5.93553 9.11614 6.60395 10.1615 7.47121 11.0288C8.33847 11.8961 9.38386 12.5645 10.535 12.9877C10.6123 13.0162 10.7225 12.9945 10.799 12.8932L11.5265 11.9235C11.6926 11.7021 11.9203 11.5346 12.1811 11.442C12.4419 11.3494 12.7243 11.3358 12.9928 11.403L16.31 12.2318C16.9355 12.3885 17.375 12.951 17.375 13.5968V14.625C17.375 15.2217 17.1379 15.794 16.716 16.216C16.294 16.6379 15.7217 16.875 15.125 16.875H13.4375C6.914 16.875 1.625 11.586 1.625 5.0625V3.375Z" fill="#1C1C1E"></path>
                                                                </svg>
                                                            </a>
                                                        </div> 
                                                    </div>
                                                </form>
                                            </div> 
                                        </div>
                                    </div>
                                    <div class="widget widget-listings style"> 
                                        <h3 class="widget-title title-list">
                                            Dự án nổi bật
                                        </h3>                  
                                        @foreach ($products as $product)                                                                                                      
                                        <div class="box-listings flex hover-img3">
                                            <div class="img-listings img-style3">
                                                <img style="width: 120px;" src="{{ asset($product->images->first()->url ?? '')}}" alt="{{$product->title}}">
                                            </div>
                                            <div class="content link-style-1">
                                                <a class="fs-16 lh-24" href="{{ route('product.detail',['alias' => $product->slug]) }}">{{$product->title}}</a>
                                                <h4>{{number_format($product->price,0)}} VNĐ</h4>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    <div class="widget widget-estate">
                                        <h3 class="widget-title title-news">
                                            Real estate near you
                                        </h3>                       
                                        <ul class="group-estate flex">
                                            <li class="box-estate hover-img2">
                                                <div class="thumb img-style2 ">
                                                    <img class="img2" src="{{asset('phiatay/assets/images/img-box/sidebar-estate-1.jpg')}}" alt="images">
                                                </div>
                                                <div class="content">    
                                                    <div class="title link-style-3 fw-6 lh-18"><a href="#">Moncton</a> </div>                              
                                                    <p class="fs-12 lh-16 text-color-1">1570 listing</p>
                                                </div>
                                            </li>
                                            <li class="box-estate hover-img2">
                                                <div class="thumb img-style2 ">
                                                    <img class="img2" src="{{asset('phiatay/assets/images/img-box/sidebar-estate-2.jpg')}}" alt="images">
                                                </div>
                                                <div class="content">    
                                                    <div class="title link-style-3 fw-6 lh-18"><a href="#">Mississauga</a> </div>                              
                                                    <p class="fs-12 lh-16 text-color-1">1570 listing</p>
                                                </div>
                                            </li>
                                            <li class="box-estate hover-img2">
                                                <div class="thumb img-style2 ">
                                                    <img class="img2" src="{{asset('phiatay/assets/images/img-box/sidebar-estate-3.jpg')}}" alt="images">
                                                </div>
                                                <div class="content">    
                                                    <div class="title link-style-3 fw-6 lh-18"><a href="#">Halifax</a> </div>                              
                                                    <p class="fs-12 lh-16 text-color-1">1570 listing</p>
                                                </div>
                                            </li>
                                            <li class="box-estate hover-img2">
                                                <div class="thumb img-style2 ">
                                                    <img class="img2" src="{{asset('phiatay/assets/images/img-box/sidebar-estate-4.jpg')}}" alt="images">
                                                </div>
                                                <div class="content">    
                                                    <div class="title link-style-3 fw-6 lh-18"><a href="#">Ottawa</a> </div>                              
                                                    <p class="fs-12 lh-16 text-color-1">1570 listing</p>
                                                </div>
                                            </li>
                                            <li class="box-estate hover-img2">
                                                <div class="thumb img-style2 ">
                                                    <img class="img2" src="{{asset('phiatay/assets/images/img-box/sidebar-estate-5.jpg')}}" alt="images">
                                                </div>
                                                <div class="content">    
                                                    <div class="title link-style-3 fw-6 lh-18"><a href="#">Iqaluit</a> </div>                              
                                                    <p class="fs-12 lh-16 text-color-1">1570 listing</p>
                                                </div>
                                            </li>
                                            <li class="box-estate hover-img2">
                                                <div class="thumb img-style2 ">
                                                    <img class="img2" src="{{asset('phiatay/assets/images/img-box/sidebar-estate-6.jpg')}}" alt="images">
                                                </div>
                                                <div class="content">    
                                                    <div class="title link-style-3 fw-6 lh-18"><a href="#">Toronto</a> </div>                              
                                                    <p class="fs-12 lh-16 text-color-1">1570 listing</p>
                                                </div>
                                            </li>
                                        </ul>
                                    </div> 
                                    <div class="widget widget-ads">  
                                        <div class="box-ads">
                                            <div class="content relative z-2">
                                                <h3 class="link-style-3"><a href="property-detail-v1.html">Gorgeous Apartment Building</a> </h3>
                                                <div class="text-addres "><p class="p-12 text-color-1 icon-p">58 Hullbrook Road, Billesley, B13 0LA</p></div>
                                                <div class="star flex">
                                                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve"><g>	<g>		<polygon points="512,197.816 325.961,185.585 255.898,9.569 185.835,185.585 0,197.816 142.534,318.842 95.762,502.431 			255.898,401.21 416.035,502.431 369.263,318.842 		"></polygon>	</g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
                                                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve"><g>	<g>		<polygon points="512,197.816 325.961,185.585 255.898,9.569 185.835,185.585 0,197.816 142.534,318.842 95.762,502.431 			255.898,401.21 416.035,502.431 369.263,318.842 		"></polygon>	</g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
                                                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve"><g>	<g>		<polygon points="512,197.816 325.961,185.585 255.898,9.569 185.835,185.585 0,197.816 142.534,318.842 95.762,502.431 			255.898,401.21 416.035,502.431 369.263,318.842 		"></polygon>	</g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
                                                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve"><g>	<g>		<polygon points="512,197.816 325.961,185.585 255.898,9.569 185.835,185.585 0,197.816 142.534,318.842 95.762,502.431 			255.898,401.21 416.035,502.431 369.263,318.842 		"></polygon>	</g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
                                                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve"><g>	<g>		<polygon points="512,197.816 325.961,185.585 255.898,9.569 185.835,185.585 0,197.816 142.534,318.842 95.762,502.431 			255.898,401.21 416.035,502.431 369.263,318.842 		"></polygon>	</g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>                                               
                                                </div>
                                            </div> 
                                        </div>
                                    </div>
                                </div>
                            </aside>
                        </div>
                    </div>
                </div>
            </section>
@endsection
@section('scripts')
<script>
    $(function(){
        console.log('Product detail ready')
    })
</script>
@endsection