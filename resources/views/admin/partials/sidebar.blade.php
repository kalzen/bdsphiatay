<!-- Main sidebar -->
<div class="sidebar sidebar-dark sidebar-main sidebar-expand-md">

    <!-- Sidebar mobile toggler -->
    <div class="sidebar-mobile-toggler text-center">
        <a href="#" class="sidebar-mobile-main-toggle">
            <i class="icon-arrow-left8"></i>
        </a>
        Navigation
        <a href="#" class="sidebar-mobile-expand">
            <i class="icon-screen-full"></i>
            <i class="icon-screen-normal"></i>
        </a>
    </div>
    <!-- /sidebar mobile toggler -->
    <!-- Sidebar content -->
    <div class="sidebar-content">

        <!-- User menu -->
        <div class="sidebar-user-material">
            <div class="sidebar-user-material-body">
                <div class="card-body text-center">
                    <a href="{{route('admin.profile')}}">
                        <img src="/global_assets/images/placeholders/placeholder.jpg" class="img-fluid rounded-circle shadow-1 mb-3" width="80" height="80" alt="">
                    </a>
                    <h6 class="mb-0 text-white text-shadow-dark">{{auth()->user()->name}}</h6>
                    <span class="font-size-sm text-white text-shadow-dark">{{auth()->user()->email}}</span>
                </div>
                <div class="sidebar-user-material-footer">
                    <a href="#user-nav" class="d-flex justify-content-between align-items-center text-shadow-dark dropdown-toggle" data-toggle="collapse"><span>Tài khoản</span></a>
                </div>
            </div>

            <div class="collapse" id="user-nav">
                <ul class="nav nav-sidebar">
                    <li class="nav-item">
                        <a href="{{route('admin.profile')}}" class="nav-link">
                            <i class="icon-user-plus"></i>
                            <span>Sửa thông tin</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('admin.logout')}}" class="nav-link">
                            <i class="icon-switch2"></i>
                            <span>Thoát</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- /user menu -->
        <!-- Main navigation -->
        <div class="card card-sidebar-mobile">
            <ul class="nav nav-sidebar" data-nav-type="accordion">

                <!-- Main -->
                <li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">Main</div> <i class="icon-menu" title="Main"></i></li>
                <li class="nav-item">
                    <a href="{{route('admin.index')}}" class="nav-link">
                        <i class="icon-home4"></i>
                        <span>
                            Dashboard
                        </span>
                    </a>
                </li>
                <li class="nav-item nav-item-submenu">
                    <a href="javascript:;" class="nav-link"><i class="icon-color-sampler"></i> <span>Giao diện</span></a>

                    <ul class="nav nav-group-sub" data-submenu-title="Giao diện">
                        <li class="nav-item"><a href="javascript:;" class="nav-link active">Trang chủ</a></li>
                        <li class="nav-item"><a href="{{route('admin.slide.index')}}" class="nav-link">Slide</a></li>
                        <li class="nav-item"><a href="{{route('admin.menu.index')}}" class="nav-link">Menu</a></li>
                    </ul>
                </li>
                <li class="nav-item nav-item-submenu">
                    <a href="javascript:;" class="nav-link"><i class="icon-pushpin"></i> <span>Bài viết</span></a>

                    <ul class="nav nav-group-sub" data-submenu-title="Bài viết">
                        <li class="nav-item"><a href="{{route('admin.post.index')}}" class="nav-link">Tất cả bài viết</a></li>
                        <li class="nav-item"><a href="{{route('admin.post.create')}}" class="nav-link">Viết bài mới</a></li>
                        <li class="nav-item"><a href="{{route('admin.category.index')}}" class="nav-link">Chuyên mục</a></li>
                    </ul>
                </li>
                <li class="nav-item nav-item-submenu">
                    <a href="javascript:;" class="nav-link"><i class="icon-map"></i> <span>Phường/xã</span></a>

                    <ul class="nav nav-group-sub" data-submenu-title="Phường/xã">
                        <li class="nav-item"><a href="{{route('admin.ward.index')}}" class="nav-link">Tất cả Phường/xã</a></li>
                        <li class="nav-item"><a href="{{route('admin.ward.create')}}" class="nav-link">Thêm mới</a></li>
                    </ul>
                </li>
                <li class="nav-item nav-item-submenu">
                    <a href="javascript:;" class="nav-link"><i class="icon-bag"></i> <span>Dự án</span></a>

                    <ul class="nav nav-group-sub" data-submenu-title="Dự án">
                        <li class="nav-item"><a href="{{route('admin.product.index')}}" class="nav-link">Tất cả dự án</a></li>
                        <li class="nav-item"><a href="{{route('admin.product.create')}}" class="nav-link">Thêm mới</a></li>
                        <li class="nav-item"><a href="{{route('admin.attribute.index')}}" class="nav-link">Thuộc tính</a></li>
                       <!-- <li class="nav-item"><a href="{{route('admin.order.index')}}" class="nav-link">Đơn hàng ({{$shared_orders_count}})</a></li> -->
                        <li class="nav-item"><a href="{{route('admin.catalogue.index')}}" class="nav-link">Danh mục</a></li>
                    </ul>
                </li> 
                <li class="nav-item nav-item-submenu">
                    <a href="javascript:;" class="nav-link"><i class="icon-users"></i> <span>Thành viên</span></a>

                    <ul class="nav nav-group-sub" data-submenu-title="Thành viên">
                        <li class="nav-item"><a href="{{route('admin.user.index')}}" class="nav-link">Tất cả người dùng</a></li>
                        <li class="nav-item"><a href="{{route('admin.user.create')}}" class="nav-link">Thêm mới</a></li>
                        <li class="nav-item"><a href="{{route('admin.profile')}}" class="nav-link">Hồ sơ</a></li>
                    </ul>
                </li>
                <li class="nav-item nav-item-submenu">
                    <a href="javascript:;" class="nav-link"><i class="icon-cog5"></i> <span>Cài đặt</span></a>

                    <ul class="nav nav-group-sub" data-submenu-title="Cài đặt">
                        <li class="nav-item"><a href="{{route('admin.setting.index')}}" class="nav-link">Tổng quan</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{route('admin.plan.index')}}" class="nav-link">
                        <i class="icon-lasso2"></i>
                        <span>
                            Quản lý chức năng
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('admin.team.index')}}" class="nav-link">
                        <i class="icon-users2"></i>
                        <span>
                            Đội ngũ
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('admin.message.index')}}" class="nav-link">
                        <i class="icon-mailbox"></i>
                        <span>
                            Quản lý liên hệ
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('admin.testimonial.index')}}" class="nav-link">
                        <i class="icon-lasso2"></i>
                        <span>
                            Quản lý phản hồi
                        </span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- /main navigation -->

    </div>
    <!-- /sidebar content -->
</div>
<!-- /main sidebar -->