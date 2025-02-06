
    <!-- Lastest News -->
    <section class="flat-blog tf-section home" >
                    <div class="container">
                        <div class="row">                      
                            <div class="col-lg-12">
                                <div class="heading-section center">
                                    <h2>Tin tức mới nhất</h2>
                                    <p class="text-color-4">Cập nhật tin tức mới nhất từ Công ty TNHH Bất động sản Phía tây</p>
                                </div>
                            </div>
                            @foreach($posts as $post)
                            <div class="col-lg-4 col-md-4">
                                <div class="box hover-img">
                                    <div class="images img-style relative ">
                                        <a class="w-100" href="{{ route('post.detail',['alias' => $post->slug])}}"><img style="height: 250px" src="{{$post->images->first()->url??''}}" alt="images"></a>
                                        
                                    </div>
                                    <div class="content center">
                                        <h3 class="link-style-1"><a href="{{ route('post.detail',['alias' => $post->slug])}}">{{$post->title}}</a></h3>
                                        <div class="meta">
                                            <a href="{{ route('post.detail',['alias' => $post->slug])}}" class="btn-button flex align-center justify-center fs-13 fw-6 text-color-3"><span>Đọc thêm </span> 
                                                <svg width="13" height="12" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg')}}">
                                                    <path d="M0.875 6H12.125M12.125 6L7.0625 0.9375M12.125 6L7.0625 11.0625" stroke="#FFA920" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg> 
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            <div class="col-lg-12 center">
                            <a href="{{route('post.list')}}" class="sc-button pt-4"> Xem tất cả tin tức</a>
                            </div>
                        </div>
                    </div>
                </section>