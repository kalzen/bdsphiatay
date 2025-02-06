
    <!-- Frontpage Slider -->
    <div class="slide-home">
        @foreach($slides as $slide)
        @if($slide->url)
        <a href="{{$slide->url}}" target="_blank"><img src="{{$slide->image??'/frontend/img/banner/01.jpg'}}" data-position="" data-in="fade" data-delay="0" data-out="fade" alt="{{$slide->name}}"></a>
        @else
        <img src="{{$slide->image??'/frontend/img/banner/01.jpg'}}" data-position="" data-in="fade" data-delay="0" data-out="fade" alt="{{$slide->name}}">
        @endif
        @endforeach
    </div>