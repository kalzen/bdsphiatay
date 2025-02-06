<div class="cart-header">
    <div class="cart-total">
        <i class="fas fa-shopping-basket"></i>
        <span>
            @if(isset($shared_cart))
            giỏ hàng (<span class="js-total">{{ collect($shared_cart)->count() }}</span>)
            @else
            rỗng
            @endif
        </span>
    </div>
    <button class="cart-close"><i class="icofont-close"></i></button>
</div>
<ul class="cart-list">
    @foreach($shared_cart as $item)
    <li class="cart-item">
        <div class="cart-media">
            <a href="javascript:;"><img src="{{ $item['image'] }}" alt="product"></a>
            <button class="cart-delete" data-key="{{$item['id']}}"><i class="far fa-trash-alt"></i></button>
        </div>
        <div class="cart-info-group">
            <div class="cart-info">
                <h6><a href="{{ $item['url'] }}">{{ $item['name'] }}</a></h6>
                <p>{{ number_format($item['price']??0,0) }}</p>
            </div>
            <div class="cart-action-group">
                <div class="product-action">
                    <input class="action-input js-quantity-change" title="Số lượng" type="text" name="quantity" value="{{ number_format($item['quantity']??0,0) }}">
                </div>
                <h6>{{ number_format($item['sub_total']??0,0) }} VNĐ</h6>
            </div>
        </div>
    </li>
    @endforeach
</ul>
<div class="cart-footer">
    <a class="cart-checkout-btn" href="/thanh-toan">
        <span class="checkout-label">Thanh toán ngay</span>
        <span class="checkout-price">{{number_format(collect($shared_cart)->pluck('sub_total')->sum(),0)}} VNĐ</span>
    </a>
</div>