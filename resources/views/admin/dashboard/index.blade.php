@extends('layouts.admin')

@section('content')

    <!-- Page header -->
    <div class="page-header page-header-light">
        <div class="page-header-content header-elements-md-inline">
            <div class="page-title d-flex">
                <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Home</span> - Dashboard</h4>
                <a href="javascript:;" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
            </div>
        </div>

        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="{{route('admin.index')}}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
                    <span class="breadcrumb-item active">Dashboard</span>
                </div>

                <a href="javascript:;" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
            </div>
        </div>
    </div>
    <!-- /page header -->


    <!-- Content area -->
    <div class="content">

        <!-- Dashboard content -->
        <div class="row">
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-body pb-0">
                        <div class="row">
                            @foreach($latest_posts as $post)
                            <div class="col-xl-6">
                                <div class="media flex-column flex-sm-row mt-0 mb-3">
                                    <div class="mr-sm-3 mb-2 mb-sm-0">
                                        <div class="card-img-actions">
                                            <a href="javascript:;">
                                                <img src="{{$post->images()->first()->url??''}}" class="img-fluid img-preview rounded" alt="">
                                                <span class="card-img-actions-overlay card-img"><i class="icon-play3 icon-2x"></i></span>
                                            </a>
                                        </div>
                                    </div>
    
                                    <div class="media-body">
                                        <h6 class="media-title"><a href="javascript:;">{{$post->title}}</a></h6>
                                        <ul class="list-inline list-inline-dotted text-muted mb-2">
                                            <li class="list-inline-item"><i class="icon-book-play mr-2"></i> {{$post->categories()->first()->name??''}}</li>
                                        </ul>
                                        {{substr(strip_tags($post->description),0,100)}}
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-xl-4">
                <!-- My messages -->
                <div class="card">
                    <div class="card-header header-elements-inline">
                        <h6 class="card-title">Tin nhắn</h6>
                        <div class="header-elements">
                            <span><i class="icon-history text-warning mr-2"></i> {{date('d/m/Y H:i:s')}}</span>
                            <span class="badge bg-success align-self-start ml-3">{{auth()->user()->name}}</span>
                        </div>
                    </div>
                    <!-- Tabs -->
                    <ul class="nav nav-tabs nav-tabs-solid nav-justified bg-indigo-400 border-x-0 border-bottom-0 border-top-indigo-300 mb-0">
                        <li class="nav-item">
                            <a href="#messages-tue" class="nav-link font-size-sm text-uppercase active" data-toggle="tab">
                                Liên hệ
                            </a>
                        </li>

                    </ul>
                    <!-- /tabs -->


                    <!-- Tabs content -->
                    <div class="tab-content card-body">
                        <div class="tab-pane active fade show" id="messages-tue">
                            <ul class="media-list">
                                @foreach($messages as $message)
                                <li class="media">
                                    <div class="mr-3">
                                        <img src="/global_assets/images/placeholders/placeholder.jpg" class="rounded-circle" width="36" height="36" alt="">
                                    </div>

                                    <div class="media-body">
                                        <div class="d-flex justify-content-between">
                                            <a href="javascript:;">
                                                @if($message->name)
                                                    {{$message->name}}
                                                @endif
                                                @if($message->mobile)
                                                    {{$message->mobile}}
                                                @endif
                                            </a>
                                            <span class="font-size-sm text-muted">{{date('d/m/Y H:i',strtotime($message->created_at))}}</span>
                                        </div>

                                        {{$message->content}}
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <!-- /tabs content -->

                </div>
                <!-- /my messages -->


                <!-- Daily financials -->
                <div class="card">
                    <div class="card-header header-elements-inline">
                        <h6 class="card-title">Sản phẩm xem nhiều nhất</h6>
                    </div>

                    <div class="card-body">

                        <ul class="media-list">
                            @foreach($most_viewed_products as $product)
                            <li class="media">
                                <div class="mr-3">
                                    <a href="{{$product->url}}" target="_blank" class="btn bg-transparent border-pink text-pink rounded-round border-2 btn-icon"><i class="icon-statistics"></i></a>
                                </div>
                                
                                <div class="media-body">
                                    Tạo từ {{date('d/m/Y',strtotime($product->created_at))}} <span class="font-weight-semibold">{{number_format($product->viewed,0)}}</span> lượt xem, <span class="font-weight-semibold text-danger">{{$product->price}}</span> 
                                    <div class="text-muted">{{$product->user->name??''}}</div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <!-- /daily financials -->

            </div>
        </div>
        <!-- /dashboard content -->

    </div>
    <!-- /content area -->

@endsection