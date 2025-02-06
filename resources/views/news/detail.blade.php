@extends('layouts.app')
@section('meta')
<title>{{ ($post->title) . ' - '. env('APP_NAME')}}</title>
@endsection
@section('content')
<link rel="stylesheet" href="{{asset ('frontend/css/blog-details.css') }}">
<section class="inner-section single-banner">
        <div class="container">
            <h1 class="text-white">{{ $post->title }}</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="{{$post->categories()->first()->url}}">{{$post->categories()->first()->title??''}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$post->title}}</li>
            </ol>
        </div>
    </section>
    <section class="inner-section blog-details-part">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12 col-xl-10">
                    <article class="blog-details">
                        <a class="blog-details-thumb" href="javascript:;"><img src="{{$post->images()->first()->url??'/frontend/images/blog/01.jpg'}}"
                                alt="blog"></a>
                        <div class="blog-details-content">
                            <ul class="blog-details-meta">
                                <li><i class="icofont-ui-calendar"></i><span>{{date('d/m/Y',strtotime($post->updated_at))}}</span></li>
                                <li><i class="icofont-user-alt-3"></i><span>{{$post->user->name??''}}</span></li>
                            </ul>
                            <h2 class="blog-details-title">{{ $post->title }}</h2>
                            <p class="blog-details-desc">{{ $post->description }}</p>
                            
                            <div class="row blog-details-grid">
                                <div class="col-md-12 col-lg-12"><img class="img-fluid" src="{{$post->images->first()->url??''}}"
                                        alt="{{ $post->title }}"></div>
                            </div>
                            <div class="blog-details-subtitle">
                                {!! $post->content !!}
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </section>
@endsection