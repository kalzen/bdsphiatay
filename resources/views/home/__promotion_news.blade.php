    @if($promotion_news->total())
    <!-- Popular Items -->
    <div class="populars-wrap">
        <div class="cont populars">
            <h2>Tin khuyến mãi</h2>
            <p class="populars-count">{{number_format($promotion_news->total(),0)}} tin</p>
            <div class="populars-list">
                @foreach($promotion_news as $post)
                <div class="popular">
                    <a href="{{$post->url}}" class="popular-link">
                        <p class="popular-img">
                            <img src="{{$post->images()->first()->url??''}}" alt="{{$post->title}}">
                        </p>
                        <h3>
                            <span>{{$post->title}}</span>
                        </h3>
                    </a>
                    <p class="popular-info">
                        <a href="{{$post->categories->first()->url??''}}" class="popular-categ">{{$post->categories->first()->name??''}}</a>
                        <span class="popular-price">{{number_format($post->viewed,0)}}</span>
                    </p>
                </div>
                @endforeach
            </div>
            <p class="popular-more">
                <a href="{{route('post.list')}}">Xem thêm</a>
            </p>
            <span class="popular-line1"></span>
            <span class="popular-line2"></span>
        </div>
    </div>
    @endif