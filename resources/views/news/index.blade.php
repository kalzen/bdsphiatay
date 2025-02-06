@extends('layouts.master')
@section('meta')
<title>{{$post->title}}</title>
<meta name="keywords" content="{{collect($post->tags)->pluck('name')->join(',')}}"/>
<meta name="description" content="{{substr(strip_tags($post->description),0,300)}}"/>
<meta property="og:image" content="{{$post->images()->first()->url??''}}">
<meta property="og:type" content="article">
<meta property="og:title" content="{{$post->title}}">
<meta property="og:description" content="{{substr(strip_tags($post->description),0,300)}}">
@endsection
@section('content')
    <section class="inner-section single-banner" style="background: url(/frontend/images/single-banner.jpg) no-repeat center;">
        <div class="container">
            <h2>{{$category->name??'Tin tức'}}</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="/">Trang chủ</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{$category->name??'Tin tức'}}</li>
            </ol>
        </div>
    </section>
    <section class="inner-section blog-standard">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-lg-12">
                            @foreach($news as $record)
                            <div class="blog-card">
                                <div class="blog-media">
                                    <a class="blog-img" href="/{{$record->slug}}">
                                        <img src="{{$record->images()->first()->url??'/frontend/images/blog/01.jpg'}}" alt="{{$record->images()->first()->title??$record->title}}">
                                    </a>
                                </div>
                                <div class="blog-content">
                                    <ul class="blog-meta">
                                        <li>
                                            <i class="icofont-ui-calendar"></i>
                                            <span>{{date('d/m/Y',strtotime($record->created_at))}}</span>
                                        </li>
                                        <li>
                                            <i class="icofont-user-alt-3"></i>
                                            <span>{{$record->user->name}}</span>
                                        </li>
                                        <li>
                                            <i class="icofont-speech-comments"></i>
                                            <span>{{$record->comments()->count()}} bình luận</span>
                                        </li>
                                    </ul>
                                    <h4 class="blog-title">
                                        <a href="/{{$record->slug}}">{{$record->title}}</a>
                                    </h4>
                                    <p class="blog-desc">{{$record->description}}</p>
                                    <a class="blog-btn" href="/{{$record->slug}}">
                                        <span>Xem thêm</span>
                                        <i class="icofont-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @if($news->hasMorePages())
                        <div class="col-lg-12">
                            <a class="blog-btn" href="{{$news->nextPageUrl()}}"><span>Trang tiếp</span><i class="icofont-arrow-right"></i></a>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="col-sm-10 col-md-7 col-lg-4">
                    <div class="blog-widget">
                        <h3 class="blog-widget-title">Tin nổi bật</h3>
                        <ul class="blog-widget-feed">
                            @foreach($related as $item)
                            <li>
                                <a class="blog-widget-media" href="/{{$item->slug}}">
                                    <img src="{{$record->images()->first()->url??'/frontend/images/blog/01.jpg'}}" alt="{{$record->images()->first()->title??$record->title}}">
                                </a>
                                <h6 class="blog-widget-text">
                                    <a href="{{$item->url}}">{{$item->title}}</a>
                                    <span>{{date('d/m/Y',strtotime($item->created_at))}}</span>
                                </h6>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection