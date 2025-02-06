<section class="flat-sale wg-dream tf-section" >
                    <div class="container">
                        <div class="row">                      
                            <div class="col-lg-12">
                                <div class="heading-section d-flex justify-content-between">
                                    <h3>Bộ sưu tập tuyển chọn</h3>
                                    <a>Xem thêm 
                                    <svg width="13" height="12" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M0.875 6H12.125M12.125 6L7.0625 0.9375M12.125 6L7.0625 11.0625" stroke="#000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg> 
                                                </a>
                                </div>
                                <div class="swiper-container2" >    
                                    <div class="one-carousel owl-carousel owl-theme">
                                         @foreach($products as $product)
                                        <div class="slide-item">
                                            
                                                <div class="box box-dream hv-one">
                                                    <div class="image-group relative ">
                                                        <span class="featured fs-12 fw-6">Nổi bật</span>   
                                                        <span class="featured style fs-12 fw-6">Mới nhất</span>   
                                                        <div class="swiper-container noo carousel-2 img-style"  >    
                                                            <a href="{{ route('product.detail',['alias' => $product->slug]) }}" class="icon-plus"><img src="{{asset('phiatay/assets/images/icon/plus.svg')}}" alt="images"></a>
                                                            <div class="swiper-wrapper ">
                                                                <div class="swiper-slide"><img src="{{ asset($product->images->first()->url ?? '')}}" alt="images"></div>
                                                            </div>                                 
                                                        </div>
                                                    </div>
                                                    <div class="content">
                                                        <h3 class="link-style-1"><a href="{{ route('product.detail',['alias' => $product->slug]) }}">{{$product->title}}</a> </h3>
                                                        @foreach($product->attributes as $attribute_item)
                                                            @if ($attribute_item->pivot->attribute_id == 11)
                                                                <div class="text-address"><p class="p-12">{{$attribute_item->pivot->value??''}} - Tp. Cao Bằng</p></div>
                                                                @endif
                                                    @endforeach
                                                        
                                                        <div class="money fs-18 fw-6 text-color-3"><a href="{{ route('product.detail',['alias' => $product->slug]) }}">{{$product->price_convert()}}</a></div>  
                                                        <div class="icon-box flex">
                                                        @foreach($product->attributes as $attribute_item)
                                                            @if ($attribute_item->pivot->attribute_id == 3)
                                                                <div class="icons icon-3 flex"><span></span><span class="fw-6">{{$attribute_item->pivot->value??''}} m2</span></div>
                                                                @endif
                                                            @if ($attribute_item->pivot->attribute_id == 1)
                                                                <div class=" flex"><svg style="margin-top:3px; margin-right: 3px" xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none">
<rect width="24" height="24" fill="white"/>
<path d="M14.1214 14.1213L16.5165 8.13347C16.6798 7.72532 16.2747 7.32028 15.8666 7.48354L9.87872 9.87868M14.1214 14.1213L8.13351 16.5165C7.72536 16.6797 7.32032 16.2747 7.48358 15.8665L9.87872 9.87868M14.1214 14.1213L9.87872 9.87868" stroke="#000000" stroke-linecap="round" stroke-linejoin="round"/>
<circle cx="12" cy="12" r="9" stroke="#000000" stroke-linecap="round" stroke-linejoin="round"/>
</svg><span></span><span class="fw-6">{{$attribute_item->pivot->value??''}}</span></div>
                                                                @endif
                                                    @endforeach
                                                        </div>                                          
                                                    </div>
                                                </div> 
                                                
                                        </div>
 @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>