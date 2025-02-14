@extends('layouts.master')
@section('meta')
    @if(isset($catalogue))
    <title>{{$catalogue->name}} - {{env('APP_NAME')}}</title>
    <meta name="keywords" content="{{$catalogue->tags->pluck('name')->join(', ')}}"/>
    <meta name="description" content="{{$catalogue->description}}"/>
    <meta property="og:image" content="{{$catalogue->image->url??''}}">
    <meta property="og:type" content="product">
    <meta property="og:title" content="{{$catalogue->name}}">
    <meta property="og:description" content="{{$catalogue->description}}">
    @else
    <title>Dự án - {{env('APP_NAME')}}</title>
    <meta name="keywords" content="{{env('APP_NAME')}}"/>
    <meta name="description" content="{{env('APP_NAME')}}"/>
    <meta property="og:image" content="{{env('APP_LOGO')}}">
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{env('APP_NAME')}}">
    <meta property="og:description" content="{{env('APP_NAME')}}">
    @endif
@stop
@section('styles')

@endsection
@section('content')
<section class="tf-map">
                <div class="container-fuild">
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <iframe class="map-content"
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3681.532794990684!2d106.2581194!3d22.671201699999997!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x36ca65d0d4c82b79%3A0x6178b081d8a77a79!2zQ8O0bmcgdHkgVE5ISCBC4bqldCDEkOG7mW5nIFPhuqNuIFBow61hIFTDonk!5e0!3m2!1svi!2s!4v1717672125806!5m2!1svi!2s" allowfullscreen="" loading="lazy"></iframe>
                        </div>
                    </div>
                </div>
            </section>
            <div class="top-filters style style2">
                <div class="container6">
                    <div class="row">                      
                        <div class="col-lg-12">
                            <div class="flat-tabs style2 flex">
                               <!-- <div class="box-tab center">
                                    <ul class="menu-tab tab-title flex">
                                        <li class="item-title active flex align-center">
                                            <i class="far fa-check-circle"></i> <h4 class="inner" style="text-wrap: nowrap;">Bất động sản bán</h4>
                                        </li>
                                        <li class="item-title style">
                                            <h4 class="inner" style="text-wrap: nowrap;"> Bất động sản cho thuê </h4>
                                        </li>
                                    </ul>
                                </div> -->
                                <div class="content-tab">
                                    <div class="content-inner tab-content">
                                        <div class="form-sl">
                                            <form method="get" action="{{route('product.search')}}">
                                                        @csrf
                                                <div class="wd-find-select flex">
                                                    <div class="form-group-1 search-form form-style relative">
                                                        <i class="far fa-search"></i>
                                                        <input type="search" class="search-field" placeholder="Tìm kiếm từ khóa" value="" name="keyword" title="Search for" >
                                                    </div>                                                  
                                                    <div class="form-group-2 form-style">
                                                                        <div class="group-select">
                                                                                <select name="price_range" class="select_js">    
                                                                                    <option value="0" class="option selected">Khoảng giá</option>
                                                                                    <option value="1" class="option">Dưới 500 triệu</option>
                                                                                    <option value="2" class="option">500 - 1 tỷ</option>
                                                                                    <option value="3" class="option">1 - 2 tỷ</option>
                                                                                    <option value="4" class="option">2 - 3 tỷ</option>                                                      
                                                                                    <option value="5" class="option">3 - 5 tỷ</option>
                                                                                    <option value="6" class="option">5 - 10 tỷ</option>
                                                                                    <option value="7" class="option">10 - 20 tỷ</option>                                                      
                                                                                    <option value="8" class="option">20 - 30 tỷ</option>
                                                                                    <option value="9" class="option">Trên 30 tỷ</option>
                                                                                </select>
                                                                        </div>
                                                                    </div>
                                                    <div class="form-group-3 form-style">
                                                                        <div class="group-select">
                                                                                <select class="select_js" name="ward_id">  
                                                                                    <option value class="option selected">Phường/Xã</li>   
                                                                                    @foreach ($wards as $ward)
                                                                                    <option value="{{$ward->id}}" class="option">{{$ward->name}}</option>
                                                                                    @endforeach                                  
                                                                                </select>
                                                                        </div>                                                    
                                                                    </div>
                                                    <div class="form-group-3 form-style">
                                                        <div class="group-select">
                                                            <select class="select_js" name="direction[]">  
                                                                                    <option value=" " class="option selected">Hướng</li>   
                                                                                    <option value="Đông" class="option">Đông</option>
                                                                                    <option value="Tây" class="option">Tây</option>
                                                                                    <option value="Nam" class="option">Nam</option>
                                                                                    <option value="Bắc" class="option">Bắc</option>
                                                                                    <option value="Đông Nam" class="option">Đông Nam</option>                                                      
                                                                                    <option value="Đông Bắc" class="option">Đông Bắc</option>
                                                                                    <option value="Tây Nam" class="option">Tây Nam</option>
                                                                                    <option value="Tây Bắc" class="option">Tây Bắc</option>                          
                                                                                </select>
                                                        </div>                                                    
                                                    </div>
                                                    <div class="form-group-3 form-style">
                                                        <div class="group-select">
                                                            <select class="select_js" name="area[]">  
                                                                                    <option value="0" class="option selected">Diện tích</li>   
                                                                                    <option value="1" class="option">< 100m</option>
                                                                                    <option value="2" class="option">100 - 300m2</option>
                                                                                    <option value="3" class="option">300 - 500m2</option>
                                                                                    <option value="4" class="option">500 - 1000m2</option>
                                                                                    <option value="5" class="option">1000 - 5000m2</option>                                                      
                                                                                    <option value="6" class="option">1ha - 5ha</option>
                                                                                    <option value="7" class="option">> 5ha</option>                     
                                                                                </select>
                                                        </div>                                                    
                                                    </div>
                                                    <div class="form-group-4 form-style" @if(Auth::guest()) style="display:none" @endif>
                                                        <a class="icon-filter button-top pull-right" href="#">
                                                            <span>Nâng cao</span>
                                                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M3 10.5V0.75M3 10.5C3.39782 10.5 3.77936 10.658 4.06066 10.9393C4.34196 11.2206 4.5 11.6022 4.5 12C4.5 12.3978 4.34196 12.7794 4.06066 13.0607C3.77936 13.342 3.39782 13.5 3 13.5M3 10.5C2.60218 10.5 2.22064 10.658 1.93934 10.9393C1.65804 11.2206 1.5 11.6022 1.5 12C1.5 12.3978 1.65804 12.7794 1.93934 13.0607C2.22064 13.342 2.60218 13.5 3 13.5M3 17.25V13.5M15 10.5V0.75M15 10.5C15.3978 10.5 15.7794 10.658 16.0607 10.9393C16.342 11.2206 16.5 11.6022 16.5 12C16.5 12.3978 16.342 12.7794 16.0607 13.0607C15.7794 13.342 15.3978 13.5 15 13.5M15 10.5C14.6022 10.5 14.2206 10.658 13.9393 10.9393C13.658 11.2206 13.5 11.6022 13.5 12C13.5 12.3978 13.658 12.7794 13.9393 13.0607C14.2206 13.342 14.6022 13.5 15 13.5M15 17.25V13.5M9 4.5V0.75M9 4.5C9.39782 4.5 9.77936 4.65804 10.0607 4.93934C10.342 5.22064 10.5 5.60218 10.5 6C10.5 6.39782 10.342 6.77936 10.0607 7.06066C9.77936 7.34196 9.39782 7.5 9 7.5M9 4.5C8.60218 4.5 8.22064 4.65804 7.93934 4.93934C7.65804 5.22064 7.5 5.60218 7.5 6C7.5 6.39782 7.65804 6.77936 7.93934 7.06066C8.22064 7.34196 8.60218 7.5 9 7.5M9 17.25V7.5" stroke="#000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                            </svg>                                                                           
                                                        </a>
                                                    </div>
                                                    <div class="button-search sc-btn-top">
                                                        <button style="border: none;" class="sc-button" type="submit" >
                                                                        <span>Tìm kiếm</span>
                                                                        <i class="far fa-search text-color-1"></i>
                                                                    </button>
                                                    </div> 
                                                </div>
                                                <div class="wd-find-select wd-search-form ">
                                                                <div class="form-group wg-box3">
                                                                    <h6 style="margin-bottom: 20px;">Chức năng</h6>
                                                                        <div class="tf-amenities bg-white">
                                                                        @foreach ($plans as $plan)
                                                                            <label class="flex"><input name="plan_id[]" type="checkbox" value="{{$plan->id}}" /> 
                                                                                <span class="btn-checkbox"></span><span class="fs-13">{{$plan->name}}</span> 
                                                                            </label>              
                                                                         @endforeach                       
                                                                        </div>                                                  
                                                                    </div> 
                                                                <div class="form-group wg-box3">
                                                                    <h6 style="margin-bottom: 20px;">Khoảng giá (đơn vị triệu)</h6>
                                                                        <div class="tf-amenities bg-white">
                                                                             Min: <input name="price_range_min" type="number" value="" />  
                                                                             Max: <input name="price_range_max" type="number" value="" />  
                                                                        </div>                                                  
                                                                    </div> 
                                                                <div class="boder-wg"></div>
                                                                <div class="box2 flex flex-wrap form-wg">
                                                                
                                                                    <div class="form-group wg-box3">
                                                                    <h6 style="margin-bottom: 20px;">Diện tích</h6>
                                                                        <div class="tf-amenities bg-white">
                                                                            <label class="flex"><input name="area[]" type="checkbox"  value="1"/> 
                                                                                <span class="btn-checkbox"></span><span class="fs-13">< 100m2</span> 
                                                                            </label>
                                                                            <label class="flex"><input name="area[]" type="checkbox" value="2"/> 
                                                                                <span class="btn-checkbox"></span><span class="fs-13">100 - 300m2</span> 
                                                                            </label>
                                                                            <label class="flex"><input name="area[]" type="checkbox"  value="3"/> 
                                                                                <span class="btn-checkbox"></span><span class="fs-13">300 - 500m2</span> 
                                                                            </label> 
                                                                            <label class="flex"><input name="area[]" type="checkbox"  value="4"/> 
                                                                                <span class="btn-checkbox"></span><span class="fs-13">500 - 1000m2</span> 
                                                                            </label> 
                                                                            <label class="flex"><input name="area[]" type="checkbox"  value="5"/> 
                                                                                <span class="btn-checkbox"></span><span class="fs-13">1000 - 5000m2</span> 
                                                                            </label> 
                                                                            <label class="flex"><input name="area[]" type="checkbox"  value="6"/> 
                                                                                <span class="btn-checkbox"></span><span class="fs-13">1ha - 5ha</span> 
                                                                            </label> 
                                                                            <label class="flex"><input name="area[]" type="checkbox"  value="7"/> 
                                                                                <span class="btn-checkbox"></span><span class="fs-13">> 5ha</span> 
                                                                            </label> 
                                                                        </div>                                                  
                                                                    </div> 
                                                                    <div class="form-group wg-box3">
                                                                    <h6 style="margin-bottom: 20px;">Đường</h6>
                                                                        <div class="tf-amenities bg-white">
                                                                            <label class="flex"><input name="road[]" type="checkbox" value="1" /> 
                                                                                <span class="btn-checkbox"></span><span class="fs-13">< 2m</span> 
                                                                            </label>
                                                                            <label class="flex"><input name="road[]" type="checkbox"  value="2"/> 
                                                                                <span class="btn-checkbox"></span><span class="fs-13">2 - 3m</span> 
                                                                            </label>
                                                                            <label class="flex"><input name="road[]" type="checkbox" value="3"/> 
                                                                                <span class="btn-checkbox"></span><span class="fs-13">3 - 5m</span> 
                                                                            </label>
                                                                            <label class="flex"><input name="road[]" type="checkbox"  value="4"/> 
                                                                                <span class="btn-checkbox"></span><span class="fs-13">5 - 10m</span> 
                                                                            </label>
                                                                            <label class="flex"><input name="road[]" type="checkbox" value="5"/> 
                                                                                <span class="btn-checkbox"></span><span class="fs-13">QL</span> 
                                                                            </label>                                       
                                                                        </div>                                                  
                                                                    </div> 
                                                                    <div class="form-group wg-box3">
                                                                    <h6 style="margin-bottom: 20px;">Mặt tiền</h6>
                                                                        <div class="tf-amenities bg-white">
                                                                            <label class="flex"><input name="front[]" type="checkbox"  value="1" /> 
                                                                                <span class="btn-checkbox"></span><span class="fs-13">< 5m</span> 
                                                                            </label>
                                                                            <label class="flex"><input name="front[]" type="checkbox" value="2"  /> 
                                                                                <span class="btn-checkbox"></span><span class="fs-13">5 - 8m</span> 
                                                                            </label>
                                                                            <label class="flex"><input name="front[]" type="checkbox" value="3"  /> 
                                                                                <span class="btn-checkbox"></span><span class="fs-13 ">8 - 12m</span> 
                                                                            </label> 
                                                                            <label class="flex"><input name="front[]" type="checkbox" value="4"  /> 
                                                                                <span class="btn-checkbox"></span><span class="fs-13 ">> 12m</span> 
                                                                            </label> 
                                                                        </div>                                                  
                                                                    </div>  
                                                                    <div class="form-group wg-box3">
                                                                    <h6 style="margin-bottom: 20px;">Hướng</h6>
                                                                        <div class="tf-amenities bg-white">
                                                                            <label class="flex"><input name="direction[]" type="checkbox" value="đông" /> 
                                                                                <span class="btn-checkbox"></span><span class="fs-13">Đông</span> 
                                                                            </label>
                                                                            <label class="flex"><input name="direction[]" type="checkbox" value="tây" /> 
                                                                                <span class="btn-checkbox"></span><span class="fs-13">Tây</span> 
                                                                            </label>
                                                                            <label class="flex"><input name="direction[]" type="checkbox" value="nam" /> 
                                                                                <span class="btn-checkbox"></span><span class="fs-13">Nam</span> 
                                                                            </label>
                                                                            <label class="flex"><input name="direction[]" type="checkbox" value="bắc" /> 
                                                                                <span class="btn-checkbox"></span><span class="fs-13">Bắc</span> 
                                                                            </label>
                                                                            <label class="flex"><input name="direction[]" type="checkbox" value="đông bắc" /> 
                                                                                <span class="btn-checkbox"></span><span class="fs-13">Đông Bắc</span> 
                                                                            </label>
                                                                            <label class="flex"><input name="direction[]" type="checkbox" value="đông nam" /> 
                                                                                <span class="btn-checkbox"></span><span class="fs-13">Đông Nam</span> 
                                                                            </label>
                                                                            <label class="flex"><input name="direction[]" type="checkbox" value="tây bắc" /> 
                                                                                <span class="btn-checkbox"></span><span class="fs-13">Tây Bắc</span> 
                                                                            </label>
                                                                            <label class="flex"><input name="direction[]" type="checkbox" value="tây nam" /> 
                                                                                <span class="btn-checkbox"></span><span class="fs-13">Tây Nam</span> 
                                                                            </label>
                                                                        </div>                                                  
                                                                    </div> 
                                                                </div>
                                                            </div>
                                            </form>
                                            <!-- End Job  Search Form-->
                                        </div> 
                                    </div>
 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <section class="flat-title" >
                <div class="container6">
                    <div class="row">                      
                        <div class="col-lg-12">
                            <div class="title-inner style">
                                <div class="title-group fs-12"><a class="home fw-6 text-color-3" href="index.html">Home</a><span >Property Listing</span></div>
                            </div>
                        </div> 
                    </div>
                </div>
            </section>
           

            <section class="flat-featured flat-property flat-property-grid-1 tf-section2 wg-dream style5" >
                <div class="container6">
                    <div class="row flex">                      
                        <div class="post">
                            <div class="category-filter flex justify-space align-center">
                                <div class="box-1 flex align-center">
                                    <div class="heading-listing fs-30 lh-45 fw-7">Danh sách dự án</div><div class="">Hiển thị {{count($products)}} dự án </div> 
                                </div>
                                <div class="box-2 flex">
                                    <a href="#" class="btn-view grid active">
                                        <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M5.04883 6.40508C5.04883 5.6222 5.67272 5 6.41981 5C7.16686 5 7.7908 5.62221 7.7908 6.40508C7.7908 7.18801 7.16722 7.8101 6.41981 7.8101C5.67241 7.8101 5.04883 7.18801 5.04883 6.40508Z" stroke="#8E8E93"/>
                                            <path d="M11.1045 6.40508C11.1045 5.62221 11.7284 5 12.4755 5C13.2229 5 13.8466 5.6222 13.8466 6.40508C13.8466 7.18789 13.2227 7.8101 12.4755 7.8101C11.7284 7.8101 11.1045 7.18794 11.1045 6.40508Z" stroke="#8E8E93"/>
                                            <path d="M19.9998 6.40514C19.9998 7.18797 19.3757 7.81016 18.6288 7.81016C17.8818 7.81016 17.2578 7.18794 17.2578 6.40508C17.2578 5.62211 17.8813 5 18.6288 5C19.3763 5 19.9998 5.62215 19.9998 6.40514Z" stroke="#8E8E93"/>
                                            <path d="M7.74249 12.5097C7.74249 13.2926 7.11849 13.9147 6.37133 13.9147C5.62411 13.9147 5 13.2926 5 12.5097C5 11.7267 5.62419 11.1044 6.37133 11.1044C7.11842 11.1044 7.74249 11.7266 7.74249 12.5097Z" stroke="#8E8E93"/>
                                            <path d="M13.7976 12.5097C13.7976 13.2927 13.1736 13.9147 12.4266 13.9147C11.6795 13.9147 11.0557 13.2927 11.0557 12.5097C11.0557 11.7265 11.6793 11.1044 12.4266 11.1044C13.1741 11.1044 13.7976 11.7265 13.7976 12.5097Z" stroke="#8E8E93"/>
                                            <path d="M19.9516 12.5097C19.9516 13.2927 19.328 13.9147 18.5807 13.9147C17.8329 13.9147 17.209 13.2925 17.209 12.5097C17.209 11.7268 17.8332 11.1044 18.5807 11.1044C19.3279 11.1044 19.9516 11.7265 19.9516 12.5097Z" stroke="#8E8E93"/>
                                            <path d="M5.04297 18.5947C5.04297 17.8118 5.66709 17.1896 6.4143 17.1896C7.16137 17.1896 7.78523 17.8116 7.78523 18.5947C7.78523 19.3778 7.16139 19.9997 6.4143 19.9997C5.66714 19.9997 5.04297 19.3773 5.04297 18.5947Z" stroke="#8E8E93"/>
                                            <path d="M11.0986 18.5947C11.0986 17.8118 11.7227 17.1896 12.47 17.1896C13.2169 17.1896 13.8409 17.8117 13.8409 18.5947C13.8409 19.3778 13.2169 19.9997 12.47 19.9997C11.7225 19.9997 11.0986 19.3774 11.0986 18.5947Z" stroke="#8E8E93"/>
                                            <path d="M17.252 18.5947C17.252 17.8117 17.876 17.1896 18.6229 17.1896C19.3699 17.1896 19.9939 17.8117 19.9939 18.5947C19.9939 19.3778 19.3702 19.9997 18.6229 19.9997C17.876 19.9997 17.252 19.3774 17.252 18.5947Z" stroke="#8E8E93"/>
                                        </svg>
                                    </a>
                                    <a href="#" class="btn-view list">
                                        <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M19.7016 18.3317H9.00246C8.5615 18.3317 8.2041 17.9743 8.2041 17.5333C8.2041 17.0923 8.5615 16.7349 9.00246 16.7349H19.7013C20.1423 16.7349 20.4997 17.0923 20.4997 17.5333C20.4997 17.9743 20.1426 18.3317 19.7016 18.3317Z" fill="#8E8E93"/>
                                            <path d="M19.7016 13.3203H9.00246C8.5615 13.3203 8.2041 12.9629 8.2041 12.5219C8.2041 12.081 8.5615 11.7236 9.00246 11.7236H19.7013C20.1423 11.7236 20.4997 12.081 20.4997 12.5219C20.5 12.9629 20.1426 13.3203 19.7016 13.3203Z" fill="#8E8E93"/>
                                            <path d="M19.7016 8.30919H9.00246C8.5615 8.30919 8.2041 7.95179 8.2041 7.51083C8.2041 7.06986 8.5615 6.71246 9.00246 6.71246H19.7013C20.1423 6.71246 20.4997 7.06986 20.4997 7.51083C20.4997 7.95179 20.1426 8.30919 19.7016 8.30919Z" fill="#8E8E93"/>
                                            <path d="M5.5722 8.64465C6.16436 8.64465 6.6444 8.16461 6.6444 7.57245C6.6444 6.98029 6.16436 6.50024 5.5722 6.50024C4.98004 6.50024 4.5 6.98029 4.5 7.57245C4.5 8.16461 4.98004 8.64465 5.5722 8.64465Z" fill="#8E8E93"/>
                                            <path d="M5.5722 13.5942C6.16436 13.5942 6.6444 13.1141 6.6444 12.522C6.6444 11.9298 6.16436 11.4498 5.5722 11.4498C4.98004 11.4498 4.5 11.9298 4.5 12.522C4.5 13.1141 4.98004 13.5942 5.5722 13.5942Z" fill="#8E8E93"/>
                                            <path d="M5.5722 18.5438C6.16436 18.5438 6.6444 18.0637 6.6444 17.4716C6.6444 16.8794 6.16436 16.3994 5.5722 16.3994C4.98004 16.3994 4.5 16.8794 4.5 17.4716C4.5 18.0637 4.98004 18.5438 5.5722 18.5438Z" fill="#8E8E93"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                            <div class="wrap-item flex ">
                            @foreach($products as $product)
                                                <div class="box box-dream hv-one">
                                                    <div class="image-group relative ">
                                                        <span class="featured fs-12 fw-6">Nổi bật</span>   
                                                        <span class="featured style fs-12 fw-6">Mới nhất</span>   
                                                        <div class="swiper-container noo carousel-2 img-style"  >    
                                                            <a href="{{ route('product.detail',['alias' => $product->slug]) }}" class="icon-plus"><img src="{{asset('phiatay/assets/images/icon/plus.svg')}}" alt="images"></a>
                                                            <div class="swiper-wrapper ">
                                                                <div class="swiper-slide"><img src="{{ asset($product->images->first()->url ?? '')}}" alt="{{$product->title}}"></div>
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
                                                @endforeach
                            </div>
                        </div>  
                    </div>
                </div>
            </section>


            <section class="flat-contact2 relative" >
                <div class="container">
                    <div class="row">                      
                        <div class="col-lg-12">
                            <div class="heading-section">
                                <h2>Find for your dream home and increase your investment opportunities</h2>
                                <p class="text-color-2 font-2">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce sed tristique metus proin id lorem odio</p>
                                <div class="button-footer">
                                    <a class="sc-button center btn-icon" href="contact.html">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M2.25 6.75C2.25 15.034 8.966 21.75 17.25 21.75H19.5C20.0967 21.75 20.669 21.5129 21.091 21.091C21.5129 20.669 21.75 20.0967 21.75 19.5V18.128C21.75 17.612 21.399 17.162 20.898 17.037L16.475 15.931C16.035 15.821 15.573 15.986 15.302 16.348L14.332 17.641C14.05 18.017 13.563 18.183 13.122 18.021C11.4849 17.4191 9.99815 16.4686 8.76478 15.2352C7.53141 14.0018 6.58087 12.5151 5.979 10.878C5.817 10.437 5.983 9.95 6.359 9.668L7.652 8.698C8.015 8.427 8.179 7.964 8.069 7.525L6.963 3.102C6.90214 2.85869 6.76172 2.6427 6.56405 2.48834C6.36638 2.33397 6.1228 2.25008 5.872 2.25H4.5C3.90326 2.25 3.33097 2.48705 2.90901 2.90901C2.48705 3.33097 2.25 3.90326 2.25 4.5V6.75Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>                               
                                        <span>Contact Seller</span>
                                    </a>
                                </div>
                            </div>
                            <div class="mark-img">
                                <img src="assets/images/mark/mark-contact2.png" alt="images">
                            </div>
                        </div>
                    </div>
                </div>
            </section>
   
@endsection
@section('scripts')
<script>
    function sort(order) {
        $('#header-search').find('[name=sort]').remove()
        $('#header-search').append(`<input name="sort" type="hidden" value="${order}"/>`)
        $('#header-search').trigger('submit')
    }
    $(function(){
        console.log('Product list ready')
    })
</script>
<script>
    "use strict";
    $(document).ready(function() {
        var $range_cost = $("#range_cost");
        $range_cost.ionRangeSlider({
            type: "double",
            grid: true,
            min: 0,
            max: 20000,
            from: 100,
            to: 10000,
            prefix: "$",
        });
        $range_cost.on("change", function() {
            var $this = $(this)
                , value = $this.prop("value").split(";");

            $('#range_cost_ttl').html("$" + value[0] + " - $" + value[1]);
        });
    });
</script>
@endsection