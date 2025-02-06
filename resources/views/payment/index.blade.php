@extends('layouts.app')
@section('meta')
<title>{{ 'Thanh toán - '. env('APP_NAME')}}</title>
@endsection
@section('content')
<link rel="stylesheet" href="{{ asset('frontend/css/checkout.css') }}">
<div class="modal fade" id="product-view">
    <div class="modal-dialog">
        <div class="modal-content">
            <button class="modal-close icofont-close" data-bs-dismiss="modal"></button>
            <div class="product-view">
                <div class="row">
                    <div class="col-md-6 col-lg-6">
                        <div class="view-gallery">
                            <div class="view-label-group">
                                <label class="view-label new">new</label>
                                <label class="view-label off">-10%</label>
                            </div>
                            <ul class="preview-slider slider-arrow">
                                <li>
                                    <img src="/frontend/images/product/01.jpg" alt="product">
                                </li>
                                <li>
                                    <img src="/frontend/images/product/01.jpg" alt="product">
                                </li>
                                <li>
                                    <img src="/frontend/images/product/01.jpg" alt="product">
                                </li>
                                <li>
                                    <img src="/frontend/images/product/01.jpg" alt="product">
                                </li>
                                <li>
                                    <img src="/frontend/images/product/01.jpg" alt="product">
                                </li>
                                <li>
                                    <img src="/frontend/images/product/01.jpg" alt="product">
                                </li>
                                <li>
                                    <img src="/frontend/images/product/01.jpg" alt="product">
                                </li>
                            </ul>
                            <ul class="thumb-slider">
                                <li>
                                    <img src="/frontend/images/product/01.jpg" alt="product">
                                </li>
                                <li>
                                    <img src="/frontend/images/product/01.jpg" alt="product">
                                </li>
                                <li>
                                    <img src="/frontend/images/product/01.jpg" alt="product">
                                </li>
                                <li>
                                    <img src="/frontend/images/product/01.jpg" alt="product">
                                </li>
                                <li>
                                    <img src="/frontend/images/product/01.jpg" alt="product">
                                </li>
                                <li>
                                    <img src="/frontend/images/product/01.jpg" alt="product">
                                </li>
                                <li>
                                    <img src="/frontend/images/product/01.jpg" alt="product">
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6">
                        <div class="view-details">
                            <h3 class="view-name">
                                <a href="product-video.html">existing product name</a>
                            </h3>
                            <div class="view-meta">
                                <p>
                                    SKU:<span>1234567</span>
                                </p>
                                <p>
                                    BRAND:<a href="#">radhuni</a>
                                </p>
                            </div>
                            <div class="view-rating">
                                <i class="active icofont-star"></i>
                                <i class="active icofont-star"></i>
                                <i class="active icofont-star"></i>
                                <i class="active icofont-star"></i>
                                <i class="icofont-star"></i>
                                <a href="product-video.html">(3 reviews)</a>
                            </div>
                            <h3 class="view-price">
                                <del>$38.00</del>
                                <span>
                                    $24.00<small>/per kilo</small>
                                </span>
                            </h3>
                            <p class="view-desc">Lorem ipsum dolor sit amet consectetur adipisicing elit non tempora magni repudiandae sint suscipit tempore quis maxime explicabo veniam eos reprehenderit fuga</p>
                            <div class="view-list-group">
                                <label class="view-list-title">tags:</label>
                                <ul class="view-tag-list">
                                    <li>
                                        <a href="#">organic</a>
                                    </li>
                                    <li>
                                        <a href="#">vegetable</a>
                                    </li>
                                    <li>
                                        <a href="#">chilis</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="view-list-group">
                                <label class="view-list-title">Share:</label>
                                <ul class="view-share-list">
                                    <li>
                                        <a href="#" class="icofont-facebook" title="Facebook"></a>
                                    </li>
                                    <li>
                                        <a href="#" class="icofont-twitter" title="Twitter"></a>
                                    </li>
                                    <li>
                                        <a href="#" class="icofont-linkedin" title="Linkedin"></a>
                                    </li>
                                    <li>
                                        <a href="#" class="icofont-instagram" title="Instagram"></a>
                                    </li>
                                </ul>
                            </div>
                            <div class="view-add-group">
                                <button class="product-add" title="Add to Cart">
                                    <i class="fas fa-shopping-basket"></i>
                                    <span>add to cart</span>
                                </button>
                                <div class="product-action">
                                    <button class="action-minus" title="Quantity Minus">
                                        <i class="icofont-minus"></i>
                                    </button>
                                    <input class="action-input" title="Quantity Number" type="text" name="quantity" value="1">
                                    <button class="action-plus" title="Quantity Plus">
                                        <i class="icofont-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="view-action-group">
                                <a class="view-wish wish" href="#" title="Add Your Wishlist">
                                    <i class="icofont-heart"></i>
                                    <span>add to wish</span>
                                </a>
                                <a class="view-compare" href="compare.html" title="Compare This Item">
                                    <i class="fas fa-random"></i>
                                    <span>Compare This</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<section class="inner-section single-banner" style="background: url(/frontend/images/single-banner.jpg) no-repeat center;">
    <div class="container">
        <h2>Thanh toán</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="/">Trang chủ</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{route('product.list')}}">Sản phẩm</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Thanh toán</li>
        </ol>
    </div>
</section>
<section class="inner-section checkout-part">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <form class="js-submit">
                    @csrf
                    <div class="account-card">
                        <div class="account-title">
                            <h4>Giỏ hàng</h4>
                        </div>
                        <div class="account-content">
                            <div class="table-scroll">
                                <table class="table-list">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Sản phẩm</th>
                                            <th scope="col">Tên</th>
                                            <th scope="col">Giá</th>
                                            <th scope="col">SL</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($shared_cart as $key=>$item)
                                        <tr>
                                            <td class="table-serial">
                                                <h6>{{$loop->index+1}}</h6>
                                            </td>
                                            <td class="table-image">
                                                <img src="{{ $item['image'] }}" alt="product">
                                            </td>
                                            <td class="table-name">
                                                <h6>{{ $item['name'] }}</h6>
                                            </td>
                                            <td class="table-price">
                                                <h6>
                                                {{ number_format($item['price']??0,0) }}
                                                </h6>
                                            </td>
                                            <td class="table-quantity">
                                                <h6>{{ number_format($item['quantity']??0,0) }}</h6>
                                            </td>
                                            <td class="table-action">
                                                <a class="trash" href="javascript:;" title="Remove Wishlist">
                                                    <i class="icofont-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="checkout-charge">
                                <ul>
                                    <li>
                                        <span>Tổng giá trị</span>
                                        <span>{{ number_format($item['sub_total']??0,0) }} VNĐ</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" required name="name" placeholder="Họ tên">
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control" required name="email" placeholder="Email">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" required name="address" placeholder="Nơi nhận hàng">
                            </div>
                            <div class="form-group">
                                <input type="tel" class="form-control" required name="mobile" placeholder="Số điện thoại">
                            </div>
                            <div class="checkout-proced">
                                <a href="javascript:;" class="js-btn-submit btn btn-inline">Thanh toán</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection