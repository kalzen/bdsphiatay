@extends('layouts.master')
@section('meta')
<title>{{$post->title}}</title>
<meta name="keywords" content="{{collect($post->tags)->pluck('name')->join(',')}}"/>
<meta name="description" content="{{substr(strip_tags($post->description),0,300)}}"/>
<meta property="og:image" content="{{$post->images()->first()->url??''}}">
<meta property="og:type" content="article">
<meta property="og:title" content="{{$post->title}}">
<meta property="og:description" content="{{substr(strip_tags($post->description),0,300)}}">
@stop
@section('content')
    <section class="flat-title " >
                <div class="container">
                    <div class="row">                      
                        <div class="col-lg-12">
                            <div class="title-inner style">
                                <div class="title-group fs-12"><a class="home fw-6 text-color-3" href="{{route('index')}}">Trang chủ</a><span >{{$post->title}}</span></div>
                            </div>
                        </div> 
                    </div>
                </div>
            </section>
            
            <section class="flat-blog-detail flat-property-detail" >
                <div class="container">
                    <div class="row flex">                      
                        <div class="col-lg-8">
                            <div class="post">
                                <div class="title-heading fs-30 fw-7 lh-45">{{$post->title}}</div>
                                <div class="icon-boxs flex">
                                    <div class="icon flex align-center">
                                        <svg width="11" height="14" viewBox="0 0 11 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M7.99933 3C7.99933 3.66304 7.73594 4.29893 7.2671 4.76777C6.79826 5.23661 6.16237 5.5 5.49933 5.5C4.83629 5.5 4.20041 5.23661 3.73157 4.76777C3.26273 4.29893 2.99933 3.66304 2.99933 3C2.99933 2.33696 3.26273 1.70107 3.73157 1.23223C4.20041 0.763392 4.83629 0.5 5.49933 0.5C6.16237 0.5 6.79826 0.763392 7.2671 1.23223C7.73594 1.70107 7.99933 2.33696 7.99933 3ZM0.5 12.412C0.521423 11.1002 1.05756 9.84944 1.99278 8.92936C2.92801 8.00929 4.18739 7.49365 5.49933 7.49365C6.81127 7.49365 8.07066 8.00929 9.00588 8.92936C9.94111 9.84944 10.4772 11.1002 10.4987 12.412C8.93026 13.1312 7.22477 13.5023 5.49933 13.5C3.71533 13.5 2.022 13.1107 0.5 12.412Z" stroke="#8E8E93" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <span class="fw-6 text-color-3 fs-13">Bất động sản Phía Tây</span>
                                    </div>
                                    <div class="icon flex align-center">
                                        <svg width="15" height="12" viewBox="0 0 15 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 6.5V6C1 5.60218 1.15804 5.22064 1.43934 4.93934C1.72064 4.65804 2.10218 4.5 2.5 4.5H12.5C12.8978 4.5 13.2794 4.65804 13.5607 4.93934C13.842 5.22064 14 5.60218 14 6V6.5M8.20667 2.20667L6.79333 0.793333C6.70048 0.700368 6.59022 0.626612 6.46886 0.57628C6.34749 0.525949 6.21739 0.500028 6.086 0.5H2.5C2.10218 0.5 1.72064 0.658035 1.43934 0.93934C1.15804 1.22064 1 1.60218 1 2V10C1 10.3978 1.15804 10.7794 1.43934 11.0607C1.72064 11.342 2.10218 11.5 2.5 11.5H12.5C12.8978 11.5 13.2794 11.342 13.5607 11.0607C13.842 10.7794 14 10.3978 14 10V4C14 3.60218 13.842 3.22064 13.5607 2.93934C13.2794 2.65804 12.8978 2.5 12.5 2.5H8.914C8.64887 2.49977 8.39402 2.39426 8.20667 2.20667Z" stroke="#8E8E93" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <span class="fw-6 text-color-3 fs-13">{{$post->categories->first()->name??''}}</span>
                                    </div>
                                    <div class="icon flex align-center">
                                        <svg width="13" height="14" viewBox="0 0 13 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M3 1V2.5M10 1V2.5M0.5 11.5V4C0.5 3.60218 0.658035 3.22064 0.93934 2.93934C1.22064 2.65804 1.60218 2.5 2 2.5H11C11.3978 2.5 11.7794 2.65804 12.0607 2.93934C12.342 3.22064 12.5 3.60218 12.5 4V11.5M0.5 11.5C0.5 11.8978 0.658035 12.2794 0.93934 12.5607C1.22064 12.842 1.60218 13 2 13H11C11.3978 13 11.7794 12.842 12.0607 12.5607C12.342 12.2794 12.5 11.8978 12.5 11.5M0.5 11.5V6.5C0.5 6.10218 0.658035 5.72064 0.93934 5.43934C1.22064 5.15804 1.60218 5 2 5H11C11.3978 5 11.7794 5.15804 12.0607 5.43934C12.342 5.72064 12.5 6.10218 12.5 6.5V11.5" stroke="#8E8E93" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <span class=" fs-13">{{date('M, d Y',strtotime($post->created_at))}}</span>
                                    </div>
                                </div>
                                <div class="texts-1 fs-16 fw-8 font-2 lh-29">{{$post->description}}</div>
                                <div class="image"><img src="{{$post->images()->first()->url??''}}" alt="{{$post->title}}"></div>
                                <div class="content-img">
                                    <div class="sub-title fs-12 fw-6">{{$post->title}}</div>
                                </div>
                                {!! $post->content !!}
                                <div class="tag-wrap flex justify-space align-center">
                                    <div class="tags-box">
                                        <div class="tags flex-three ">
                                            <p>Tags:</p>
                                            <div class="flex fs-13 fw-6 link-style-1">
                                           @foreach ($post->tags as $tag)
                                                <a href="#">{{$tag->name}}</a>
                                           @endforeach
                                            </div>                                         
                                        </div> 
                                    </div>
                                    <div class="share-box flex-three">
                                        <p>Chia sẻ bài viết:</p>                              
                                        <div class="icon-social">
                                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                                            <a href="#"><i class="fab fa-twitter"></i></a>
                                            <a href="#"><i class="fab fa-linkedin-in"></i></a>  
                                            <a href="#"><i class="fab fa-instagram"></i></a>                   
                                        </div>
                                    </div>
                                </div>
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

            <section class="flat-blog page-detail" >
                <div class="container">
                    <div class="row">                      
                        <div class="col-lg-12">
                            <div class="heading-sections ">
                                <div class="title-heading fs-30 lh-45 fw-7">Related posts</div>
                            </div>
                        </div>
                        @foreach ($related as $relate)
                        <div class="col-lg-4 col-md-4">
                            <div class="box hover-img">
                                <div class="images img-style relative ">
                                    <img style="height: 250px;" src="{{$relate->images->first()->url}}" alt="{{$relate->title}}">
                                    
                                </div>
                                <div class="content center">
                                    <h3 class="link-style-1"><a href="{{$relate->url}}">{{$relate->title}}</a></h3>
                                    <div class="meta">
                                        <a href="{{$relate->url}}" class="btn-button flex align-center justify-center fs-13 fw-6 text-color-3"><span>Xem thêm </span> 
                                            <svg width="13" height="12" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M0.875 6H12.125M12.125 6L7.0625 0.9375M12.125 6L7.0625 11.0625" stroke="#FFA920" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg> 
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
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
                                    <a class="sc-button center btn-icon" href="{{route('contact')}}">
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