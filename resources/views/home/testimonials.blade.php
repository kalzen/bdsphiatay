
    <section class="section testimonial-part">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-heading">
                        <h2>phản hồi khách hàng</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="testimonial-slider slider-arrow">
                        @foreach($feedbacks as $item)
                        <div class="testimonial-card">
                            <i class="fas fa-quote-left"></i>
                            <p>{!!$item->content!!}</p>
                            <h5>{{$item->author_name}}</h5>
                            <ul>
                            {!!str_repeat('<li class="fas fa-star"></li>',$item->star_rating)!!}
                            </ul>
                            <img src="{{$item->author_avatar?:'/frontend/images/avatar/01.jpg'}}" alt="{{$item->author_name}}">
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>