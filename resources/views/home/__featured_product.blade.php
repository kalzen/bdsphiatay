
    <!-- Special Deals Items -->
    <div class="specials-wrap">
        <div class="cont specials">
            <h2>Sản phẩm nổi bật</h2>
            <p class="specials-count">{{number_format($featured_products->total(),0)}} sản phẩm</p>
            <div class="specials-list">
                @foreach($featured_products as $product)
                <div class="special">
                    <a href="{{$product->url}}" class="special-link">
                        <p class="special-img">
                            <img src="{{$product->images->first()->url??''}}" alt="{{$product->title}}">
                        </p>
                        <h3>
                            <span>{{$product->title}}</span>
                        </h3>
                    </a>
                    <p class="special-info">
                        <a href="{{$product->catalogues->first()->url??''}}" class="special-categ">{{$product->catalogues->first()->name??''}}</a>
                        <span class="special-price">{{$product->price}}</span>
                    </p>
                </div>
                @endforeach
            </div>
            <p class="special-more">
                <a href="{{route('product.list')}}">Xem thêm</a>
            </p>
            <span class="special-line1"></span>
            <span class="special-line2"></span>
        </div>
    </div>