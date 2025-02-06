
    <div class="cont maincont" style="padding-top: 30px;">
        <h1><span>Tin tức mới nhất</span></h1>
        <span class="maincont-line1 maincont-line12"></span>
        <span class="maincont-line2 maincont-line22 blog-line"></span>

        <!-- Blog Sections -->
        <ul class="cont-sections">
            <li class="active">
                <a href="{{route('post.list')}}">Tất cả</a>
            </li>
            @foreach($shared_categories as $category_item)
            <li>
                <a href="{{$category_item->url}}">{{$category_item->name}}</a>
            </li>
            @endforeach
        </ul>

        <div class="blog blog-full">

            <!-- Blog Posts List - start -->
            <div class="blog-cont">
                <div id="blog-grid">
                    @foreach($latest_news as $post)
                    <div class="blog-grid-i" >
                        <div class="blog-i">
                            <a href="{{$post->url}}" class="blog-img">
                                <img src="{{$post->images()->first()->url??''}}" alt="{{$post->title}}">
                            </a>
                            <p class="blog-info">
                                <a href="{{$post->categories()->first()->url??''}}">{{$post->categories()->first()->name??''}}</a>
                                <time datetime="{{date('Y-m-d H:i',strtotime($post->created_at))}}">{{date('d.m.Y',strtotime($post->created_at))}}</time>
                            </p>
                            <h3><a href="{{$post->url}}">{{$post->title}}</a></h3>
                            <p>{{substr(strip_tags($post->description),0,100)}} <a href="{{$post->url}}">Chi tiết</a></p>
                        </div>
                    </div>
                    @endforeach
                </div>

            </div>
            <!-- Blog Posts List - end -->

        </div>
    </div>
    <!-- Lastest News -->
    <section class="flat-blog tf-section home" >
                    <div class="container">
                        <div class="row">                      
                            <div class="col-lg-12">
                                <div class="heading-section center">
                                    <h2>Tin tức mới nhất</h2>
                                    <p class="text-color-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce sed tristique metus proin id lorem odio</p>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <div class="box hover-img">
                                    <div class="images img-style relative ">
                                        <a href="blog-detail.html"><img src="{{asset('phiatay/assets/images/img-box/blog-1.jpg')}}" alt="images"></a>
                                        <div class="sub-box flex align-center fs-13 fw-6">
                                            <div class="title-1">April</div><a class="title-2 text-color-3" href="#">Housing</a>
                                        </div>
                                    </div>
                                    <div class="content center">
                                        <h3 class="link-style-1"><a href="blog-detail.html">Building gains into housing stocks and how to trade the sector</a></h3>
                                        <div class="meta">
                                            <a href="blog-detail.html" class="btn-button flex align-center justify-center fs-13 fw-6 text-color-3"><span>Read more </span> 
                                                <svg width="13" height="12" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg')}}">
                                                    <path d="M0.875 6H12.125M12.125 6L7.0625 0.9375M12.125 6L7.0625 11.0625" stroke="#FFA920" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg> 
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <div class="box hover-img">
                                    <div class="images img-style relative ">
                                        <a href="blog-detail.html"><img src="{{asset('phiatay/assets/images/img-box/blog-2.jpg')}}" alt="images"></a>
                                        <div class="sub-box flex align-center fs-13 fw-6">
                                            <div class="title-1">April</div><a class="title-2 text-color-3" href="#">Housing</a>
                                        </div>
                                    </div>
                                    <div class="content center">
                                        <h3 class="link-style-1"><a href="blog-detail.html">92% of millennial homebuyers say inflation has impacted their plans</a></h3>
                                        <div class="meta">
                                            <a href="blog-detail.html" class="btn-button flex align-center justify-center fs-13 fw-6 text-color-3"><span>Read more </span> 
                                                <svg width="13" height="12" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg')}}">
                                                    <path d="M0.875 6H12.125M12.125 6L7.0625 0.9375M12.125 6L7.0625 11.0625" stroke="#FFA920" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg> 
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <div class="box hover-img">
                                    <div class="images img-style relative ">
                                        <a href="blog-detail.html"><img src="{{asset('phiatay/assets/images/img-box/blog-3.jpg')}}" alt="images"></a>
                                        <div class="sub-box flex align-center fs-13 fw-6">
                                            <div class="title-1">April</div><a class="title-2 text-color-3" href="#">Housing</a>
                                        </div>
                                    </div>
                                    <div class="content center">
                                        <h3 class="link-style-1"><a href="blog-detail.html">We are hiring ‘moderately,’ says Compass CEO</a></h3>
                                        <div class="meta">
                                            <a href="blog-detail.html" class="btn-button flex align-center justify-center fs-13 fw-6 text-color-3"><span>Read more </span> 
                                                <svg width="13" height="12" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg')}}">
                                                    <path d="M0.875 6H12.125M12.125 6L7.0625 0.9375M12.125 6L7.0625 11.0625" stroke="#FFA920" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg> 
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
