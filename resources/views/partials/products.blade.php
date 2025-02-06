
@foreach($products as $product)
<div class="col">
    <div class="product-card">
        <div class="product-media">
            <a class="product-image" href="{{ route('product.detail',['product' => $product->slug]) }}"><img src="{{ asset($product->images->first()->url ?? '')}}" alt="{{$product->title}}"></a>
        </div>
        <div class="product-content">
           <h6 class="product-name"><a href="{{ route('product.detail',['product' => $product->slug]) }}">{{$product->title}}</a></h6>
            <h6 class="product-price">
                @if($product->regular_price != $product->price)
                <del>{{number_format($product->regular_price,0)}}</del>
                @endif
                <span>{{number_format($product->price,0)}}<small>VNĐ</small></span>
            </h6>
            <button class="js-add-to-cart cart-add" data-key="{{$product->id}}" title="Thêm vào giỏ"><i class="fas fa-shopping-basket"></i><span>Mua</span></button>
        </div>
    </div>
</div>
@endforeach