    <div class="backdrop"></div>
    <a class="backtop fas fa-arrow-up" href="#"></a>
    <div class="header-top">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-5">
                    <div class="header-top-welcome">
                        <p>Chăm sóc khách hàng: {{ $config['hotline']->value }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <header class="header-part">
        <div class="container">
            <div class="header-content">
                <div class="header-media-group">
                    <button class="header-user"><img src="/frontend/images/user.png" alt="user"></button>
                    <a href="{{ route('home') }}"><img src="{{ $config['logo']->value }}" alt="logo"></a>
                    <button class="header-src"><i class="fas fa-search"></i></button>
                </div>
                <a href="{{ route('home') }}" class="header-logo">
                    <img src="{{ asset($config['logo']->value) }}" alt="logo">
                </a>
                <form action="{{route('product.list')}}" class="header-form"><input type="text" name="keyword" placeholder="Nhập từ khóa tìm kiếm..."><button><i class="fas fa-search"></i></button></form>
                <div class="header-widget-group">
                    <button class="header-widget header-cart" title="Giỏ hàng">
                        <i class="fas fa-shopping-basket"></i>
                        @if(isset($shared_cart))
                        <sup>{{ number_format(collect($shared_cart)->count(),0)}}+</sup>
                        <span>đơn hàng<small>{{ number_format(collect($shared_cart)->sum('sub_total'),0) }} VNĐ</small></span>
                        @endif
                    </button>
                </div>
            </div>
        </div>
    </header>
    <nav class="navbar-part">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="navbar-content">
                        <ul class="navbar-list">
                            <li class="navbar-item"><a class="navbar-link" href="{{ route('home') }}">Trang chủ</a></li>
                            <li class="navbar-item dropdown">
                                <a class="navbar-link dropdown-arrow" href="{{route('product.list')}}">Sản phẩm</a>
                                <ul class="dropdown-position-list">
                                    @foreach($catalogue_menu as $item)
                                    <li><a href="{{$item->url}}">{{$item->name}}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                            <li class="navbar-item dropdown">
                                <a class="navbar-link dropdown-arrow" href="{{route('news')}}">Tin tức</a>
                                <ul class="dropdown-position-list">
                                    @foreach($news_menu as $item)
                                    <li><a href="{{$item->url}}">{{$item->name}}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                            <li class="navbar-item">
                                <a class="navbar-link" href="{{route('news.detail',['post'=>$shared_post])}}">Liên hệ</a>
                            </li>
                        </ul>
                        <div class="navbar-info-group">
                            <div class="navbar-info"><i class="icofont-ui-touch-phone"></i>
                                <p><small>Hotline</small><span>{{ $config['hotline']->value }}</span></p>
                            </div>
                            <div class="navbar-info"><i class="icofont-ui-email"></i>
                                <p><small>Email</small><span>{{  $config['email']->value }}</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <aside class="category-sidebar">
        <div class="category-header">
            <h4 class="category-title"><i class="fas fa-align-left"></i><span>categories</span></h4><button
                class="category-close"><i class="icofont-close"></i></button>
        </div>
        <ul class="category-list">
            <li class="category-item"><a class="category-link dropdown-link" href="#"><i
                        class="flaticon-vegetable"></i><span>vegetables</span></a>
                <ul class="dropdown-list">
                    <li><a href="#">asparagus</a></li>
                    <li><a href="#">broccoli</a></li>
                    <li><a href="#">carrot</a></li>
                </ul>
            </li>
        </ul>
        <div class="category-footer">
            <p>All Rights Reserved by <a href="#">Mironcoder</a></p>
        </div>
    </aside>
    <aside class="cart-sidebar">
        @include('partials.cart')
    </aside>
    <aside class="nav-sidebar">
        <div class="nav-header"><a href="/"><img src="/wp-content/images/logo%20sowa2.jpg" alt="logo"></a><button class="nav-close"><i class="icofont-close"></i></button></div>
        <div class="nav-content">
            <ul class="nav-list">
                <li><a class="nav-link" href="/"><i class="icofont-home"></i>Trang chủ</a>
                </li>
                <li><a class="nav-link dropdown-link" href="{{route('product.list')}}"><i class="icofont-food-cart"></i>Sản phẩm</a>
                    <ul class="dropdown-list">
                        @foreach($catalogue_menu as $item)
                        <li><a href="{{$item->url}}">{{$item->name}}</a></li>
                        @endforeach
                    </ul>
                </li>
                <li><a class="nav-link dropdown-link" href="{{route('news')}}"><i class="icofont-food-cart"></i>Tin tức</a>
                    <ul class="dropdown-list">
                        @foreach($news_menu as $item)
                        <li><a href="{{$item->url}}">{{$item->name}}</a></li>
                        @endforeach
                    </ul>
                </li>
            </ul>
            <div class="nav-info-group">
                <div class="nav-info"><i class="icofont-ui-touch-phone"></i>
                    <p><small>hotline</small><span>{{ $config['hotline']->value }}</span></p>
                </div>
                <div class="nav-info"><i class="icofont-ui-email"></i>
                    <p><small>email</small><span>{{  $config['email']->value }}</span></p>
                </div>
            </div>
            <div class="nav-footer">
                <p>All Rights Reserved by <a href="/">Suwa</a></p>
            </div>
        </div>
    </aside>
    <div class="mobile-menu">
        <a href="/" title="Trang chủ">
            <i class="fas fa-home"></i><span>Trang chủ</span>
        </a>
        <button class="cart-btn" title="Giỏ hàng">
            <i class="fas fa-shopping-basket"></i><span>giỏ</span><sup>{{ collect($shared_cart)->count() }}+</sup>
        </button>
    </div>