@extends('layouts.master')
@section('meta')
@if(isset($category))
<title>{{$category->name??'Tin tức'}} - {{env('APP_NAME')}}</title>
<meta name="keywords" content="{{$category->tags->pluck('name')->join(', ')}}" />
<meta name="description" content="{{$category->description}}" />
<meta property="og:image" content="{{$category->image?$category->image->url:''}}">
<meta property="og:type" content="article">
<meta property="og:title" content="{{$category->name??'Tin tức'}}">
<meta property="og:description" content="{{$category->description}}">
@else
<title>Tin tức - {{env('APP_NAME')}}</title>
<meta name="keywords" content="{{env('APP_NAME')}}" />
<meta name="description" content="{{env('APP_NAME')}}" />
<meta property="og:image" content="{{env('APP_LOGO')}}">
<meta property="og:type" content="website">
<meta property="og:title" content="{{env('APP_NAME')}}">
<meta property="og:description" content="{{env('APP_NAME')}}">
@endif
@stop
@section('content')
<section class="flat-title " >
                <div class="container">
                    <div class="row">                      
                        <div class="col-lg-12">
                            <div class="title-inner style">
                                <div class="title-group fs-12"><a class="home fw-6 text-color-3" href="{{route('index')}}">Trang chủ</a><span >{{$category->name??'Tin tức'}}</span></div>
                            </div>
                        </div> 
                    </div>
                </div>
            </section>
            
            <section class="tf-section2 flat-blog-grid flat-blog-list flat-property style4" >
                <div class="container">
                    <div class="row flex">                      
                        <div class="col-lg-8">
                            <div class="post">
                            <div class="category-filter flex  justify-space">
                                <div class="box-1 ">
                                    <div class="heading-listing fs-30 lh-45 fw-7">{{$category->name??'Tin tức'}}</div>
                                </div>
                            </div>
                            <div class="flat-blog">

                                @foreach ($posts as $post)
                                @if($loop->index == 0)
                                <div class="box-heading ">
                                    <div class="image relative ">
                                        <img style="" src="{{$post->images->first()->url}}" alt="{{$post->title}}">
                                        <div class="sub-box flex align-center fs-13 fw-6">
                                            <div class="title-1">{{date('M',strtotime($post->created_at))}}</div>
                                        </div>
                                    </div>
                                    <div class="contents center">
                                        <a href="{{$post->url}}" class="title-heading fs-30 fw-7 lh-45">{{$post->title}}</a>
                                        <h4 class="fw-4">{{substr(strip_tags($post->description),0,300)}}}</h4>
                                    </div>
                                </div>
                                @endif
                                @endforeach
                                
                                
                                <div class="wrap-blog ">
                                @foreach ($posts as $post)
                                @if($loop->index > 0)
                                    <div class="box hover-img flex">
                                        <div class="images img-style relative flex-none">
                                            <img style="width: 250px !important; height: 200px !important" src="{{$post->images->first()->url}}" alt="{{$post->title}}">
                                        </div>
                                        <div class="content">
                                            <h3><a href="{{$post->url}}">{{$post->title}}</a></h3>
                                            <p class="text-color-2">{{substr(strip_tags($post->description),0,300)}}</p>
                                            <div class="meta">
                                                <a href="{{$post->url}}" class="btn-button flex align-center fs-13 fw-6 text-color-3"><span>Xem thêm </span> 
                                                    <svg width="13" height="12" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M0.875 6H12.125M12.125 6L7.0625 0.9375M12.125 6L7.0625 11.0625" stroke="#FFA920" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                    </svg> 
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                     @endif
                                @endforeach
                                    
                                </div>
                            </div>

                            
                            <!--<div class="themesflat-pagination clearfix center">
                                <ul>
                                    <li><a href="#" class="page-numbers style"><i class="far fa-angle-left"></i></a></li>
                                    <li><a href="#" class="page-numbers">1</a></li>
                                    <li><a href="#" class="page-numbers">2</a></li>
                                    <li><a href="#" class="page-numbers current">3</a></li>
                                    <li><a href="#" class="page-numbers">4</a></li>
                                    <li><a href="#" class="page-numbers">...</a></li>
                                    <li><a href="#" class="page-numbers style"><i class="far fa-angle-right"></i></a></li>
                                </ul>
                            </div> -->
                         </div>
                        </div>  
                        <div class="col-lg-4">
                             <aside class="side-bar side-bar-1 side-blog">
                                <div class="inner-side-bar">  
                                    <div class="widget widget-categories style"> 
                                        <h3 class="widget-titles title-categories">
                                            Danh mục bài viết
                                        </h3>                                                                                                                        
                                        <ul>
                                        @foreach($categories as $category)
                                            <li>
                                                <a href="{{ route('post.category', ['alias' => $category->slug]) }}" class="font-2 fw-7">{{ $category->name }}</a>
                                            </li>
                                        @endforeach
                                        </ul>
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
    
                                 <!--   <div class="widget widget-estate">
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
                                    </div> -->
                                    <div class="widget widget-ads">  
                                        <div class="box-ads">
                                            <div class="content relative z-2">
                                                <h3 class="link-style-3"><a href="#">Gorgeous Apartment Building</a> </h3>
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
                                    <div class="widget widget-tags">
                                        <h3 class="widget-title title-tags">
                                            Tags
                                        </h3>     
                                        <div class="tags_cloud_inner">
                                        @foreach ($tags as $tag)
                                        @if ($tag->name != '')
                                            <a href="#">{{$tag->name}}</a>
                                            @endif
                                         @endforeach                                 
                                        </div>                                                                                                       
                                    </div>
                                </div>
                            </aside>
                        </div>
                     
                    </div>
                </div>
            </section>
            
            <section class="flat-contact2 relative" >
                <div class="container">
                    <div class="row">                      
                        <div class="col-lg-12">
                            <div class="heading-section">
                                <h2>Find for your dream home and increase your investment opportunities</h2>
                                <p class="text-color-2 font-2">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce sed tristique metus proin id lorem odio</p>
                                <div class="button-footer">
                                    <a class="sc-button center btn-icon" href="contact.html">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M2.25 6.75C2.25 15.034 8.966 21.75 17.25 21.75H19.5C20.0967 21.75 20.669 21.5129 21.091 21.091C21.5129 20.669 21.75 20.0967 21.75 19.5V18.128C21.75 17.612 21.399 17.162 20.898 17.037L16.475 15.931C16.035 15.821 15.573 15.986 15.302 16.348L14.332 17.641C14.05 18.017 13.563 18.183 13.122 18.021C11.4849 17.4191 9.99815 16.4686 8.76478 15.2352C7.53141 14.0018 6.58087 12.5151 5.979 10.878C5.817 10.437 5.983 9.95 6.359 9.668L7.652 8.698C8.015 8.427 8.179 7.964 8.069 7.525L6.963 3.102C6.90214 2.85869 6.76172 2.6427 6.56405 2.48834C6.36638 2.33397 6.1228 2.25008 5.872 2.25H4.5C3.90326 2.25 3.33097 2.48705 2.90901 2.90901C2.48705 3.33097 2.25 3.90326 2.25 4.5V6.75Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>                               
                                        <span>Contact Seller</span>
                                    </a>
                                </div>
                            </div>
                            <div class="mark-img">
                                <img src="{{asset('phiatay/assets/images/mark/mark-contact2.png')}}" alt="images">
                            </div>
                        </div>
                    </div>
                </div>
            </section>
@endsection
@section('scripts')
<script>
$(function() {
    console.log('Post index ready')
})
</script>
@endsection