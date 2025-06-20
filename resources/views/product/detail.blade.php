@extends('layouts.master')
@section('title', $product->title)
@section('meta')
<meta name="keywords" content="{{collect($product->tags)->pluck('name')->join(',')}}"/>
<meta name="description" content="{{substr(strip_tags($product->description),0,300)}}"/>
<meta property="og:image" content="{{$product->images()->first()->url??''}}">
<meta property="og:type" content="product">
<meta property="og:title" content="{{$product->title}}">
<meta property="og:description" content="{{substr(strip_tags($product->description),0,300)}}">
<meta property="og:url" content="{{url()->current()}}">
<meta property="product:price:amount" content="{{$product->price}}">
<meta property="product:price:currency" content="VND">
@stop
@section('schema_markup')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Product",
  "name": "{{$product->title}}",
  "description": "{{substr(strip_tags($product->description ?? ''),0,300)}}",
  "url": "{{url()->current()}}",
  @if($product->images->first())
  "image": [
    @foreach($product->images as $image)
    "{{$image->url}}"@if(!$loop->last),@endif
    @endforeach
  ],
  @endif
  @if($product->price)
  "offers": {
    "@type": "Offer",
    "price": "{{$product->price}}",
    "priceCurrency": "VND",
    "availability": "https://schema.org/InStock",
    "seller": {
      "@type": "Organization",
      "name": "{{env('APP_NAME')}}"
    }
  },
  @endif
  "brand": {
    "@type": "Organization",
    "name": "{{env('APP_NAME')}}"
  },
  "category": "{{$product->catalogues->first()->name ?? 'Bất động sản'}}",
  @if($product->attributes->count() > 0)
  "additionalProperty": [
    @foreach($product->attributes as $attribute)
    {
      "@type": "PropertyValue",
      "name": "{{$attribute->name}}",
      "value": "{{$attribute->pivot->value}}"
    }@if(!$loop->last),@endif
    @endforeach
  ],
  @endif
  "mainEntityOfPage": {
    "@type": "WebPage",
    "@id": "{{url()->current()}}"
  }
}
</script>

<!-- FAQ Schema Markup -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    {
      "@type": "Question",
      "name": "Dự án đất nền này có pháp lý đầy đủ không?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Dự án {{$product->title}} được phát triển với pháp lý hoàn toàn minh bạch và đầy đủ. Chúng tôi cam kết cung cấp đầy đủ các giấy tờ pháp lý theo quy định: Giấy chứng nhận quyền sử dụng đất, Giấy phép xây dựng, Quyết định phê duyệt quy hoạch chi tiết và các văn bản pháp lý liên quan khác."
      }
    },
    {
      "@type": "Question",
      "name": "Diện tích thực tế của từng lô đất như thế nào?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Dự án có nhiều loại diện tích đa dạng từ 80m² đến 500m² tùy theo vị trí và loại đất. Mỗi lô đất đều được đo đạc chính xác, có sổ đỏ riêng biệt và thông tin chi tiết về diện tích, kích thước mặt tiền, chiều sâu. Khách hàng có thể tham khảo sơ đồ phân lô chi tiết và chọn lô phù hợp."
      }
    },
    {
      "@type": "Question",
      "name": "Hạ tầng kỹ thuật đã hoàn thiện chưa?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Dự án đã hoàn thiện 100% hạ tầng kỹ thuật bao gồm: Hệ thống đường bê tông rộng 6-12m, điện ngầm 3 pha, nước máy từ nhà máy nước sạch, hệ thống thoát nước mưa và nước thải, viễn thông internet cáp quang. Khách hàng có thể xây dựng ngay sau khi nhận đất."
      }
    },
    {
      "@type": "Question",
      "name": "Thời gian bàn giao sổ đỏ là khi nào?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Sau khi khách hàng hoàn tất thủ tục mua bán và thanh toán đầy đủ, thời gian bàn giao sổ đỏ trong vòng 30-60 ngày. Đối với các lô đất đã có sổ đỏ riêng, có thể bàn giao ngay. Chúng tôi hỗ trợ khách hàng hoàn tất mọi thủ tục sang tên đổi chủ một cách nhanh chóng."
      }
    },
    {
      "@type": "Question",
      "name": "Có chính sách hỗ trợ vay vốn mua đất không?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Có, chúng tôi hỗ trợ khách hàng vay vốn ngân hàng với lãi suất ưu đãi từ các ngân hàng đối tác như Vietcombank, BIDV, Techcombank. Hỗ trợ vay lên đến 70% giá trị đất với thời hạn vay 15-20 năm. Đội ngũ tư vấn sẽ hỗ trợ khách hàng chuẩn bị hồ sơ và thủ tục vay một cách thuận tiện nhất."
      }
    },
    {
      "@type": "Question",
      "name": "Có hạn chế gì về việc xây dựng trên đất không?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Đất nền trong dự án được phép xây dựng nhà ở theo quy hoạch được duyệt. Khách hàng có thể xây dựng nhà ở từ 1-4 tầng tùy theo quy định từng khu vực. Cần tuân thủ các quy định về lùi đường, mật độ xây dựng và kiến trúc cảnh quan. Chúng tôi sẽ cung cấp bản vẽ quy hoạch chi tiết và hỗ trợ tư vấn thiết kế."
      }
    }
  ]
}
</script>
@endsection
@section('styles')
<style>
    /* Ensure header is visible */
    header.main-header {
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
    }
    
    /* FAQ Accordion Styles */
    .faq-accordion {
        margin-top: 20px;
    }
    
    .faq-item {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        margin-bottom: 10px;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    
    .faq-item:hover {
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .faq-header {
        padding: 20px;
        background: #f8f9fa;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: background-color 0.3s ease;
    }
    
    .faq-header:hover {
        background: #e9ecef;
    }
    
    .faq-header h4 {
        margin: 0;
        font-size: 16px;
        font-weight: 600;
        color: #333;
        flex: 1;
    }
    
    .faq-icon {
        font-size: 20px;
        font-weight: bold;
        color: #FFA920;
        transition: transform 0.3s ease;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: rgba(255, 169, 32, 0.1);
    }
    
    .faq-icon.active {
        transform: rotate(45deg);
    }
    
    .faq-content {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease, padding 0.3s ease;
        background: #fff;
    }
    
    .faq-content.active {
        max-height: 500px;
        padding: 20px;
    }
    
    .faq-content p {
        margin: 0;
        line-height: 1.6;
        color: #555;
    }
    
    @media (max-width: 768px) {
        .faq-header {
            padding: 15px;
        }
        
        .faq-header h4 {
            font-size: 14px;
        }
        
        .faq-content.active {
            padding: 15px;
        }
    }
</style>
@endsection
@section('content')
<section class="flat-title " >
                <div class="container">
                    <div class="row">                      
                        <div class="col-lg-12">
                            <div class="title-inner style-detail">
                                <div class="title-group fs-12"><a class="home fw-6 text-color-3" href="{{route('index')}}">Trang chủ</a><span >{{$product->title}}</span></div>
                            </div>
                        </div> 
                    </div>
                </div>
            </section>

            <section class="flat-slider01 style" >
                <div class="container">
                    <div class="row">                      
                        <div class="col-lg-12">
                            <div class="swiper-container thumbs-swiper-row">
                                <div class="swiper-wrapper">
                                @foreach($product->images as $image)
                                    <div class="swiper-slide">
                                        <div class="image-detail">
                                            <img src="{{$image->url}}" alt="{{$product->title}}">
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div thumbsSlider="" class="swiper-container thumbs-swiper-row1">
                                <div class="swiper-wrapper">
                                @foreach($product->images as $image)
                                    <!--<div class="swiper-slide">
                                        <div class="image-detail">
                                            <img src="{{$image->url}}" alt="{{$product->title}}">
                                        </div>
                                    </div> -->
                                @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
           
            <section class="flat-property-detail property-detail2 style2" >
                <div class="container">
                    <div class="row">                      
                        <div class="col-lg-8">
                            <div class="post">
                                <!-- Product Title and Price Section -->
                                <div class="wrap-text wrap-style">
                                    <div class="product-header">
                                        <h1 class="product-title fs-30 fw-7 lh-45">{{$product->title}}</h1>
                                        @if($product->price)
                                        <div class="product-price-section" style="margin: 20px 0; padding: 20px; background: #f8f9fa; border-radius: 8px; border-left: 4px solid #FFA920;">
                                            <div class="price-label" style="font-size: 14px; color: #666; margin-bottom: 5px;">Giá dự án:</div>
                                            <div class="price-value" style="font-size: 24px; font-weight: bold; color: #FFA920;">
                                                {{number_format($product->price, 0, ',', '.')}} VNĐ
                                            </div>
                                            @if($product->price_per_m2)
                                            <div class="price-per-m2" style="font-size: 14px; color: #666; margin-top: 5px;">
                                                ({{number_format($product->price_per_m2, 0, ',', '.')}} VNĐ/m²)
                                            </div>
                                            @endif
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="wrap-text wrap-style">
                                    <div class="titles"><h3>Nội dung dự án</h3></div>
                                    {!! $product->content !!}
                                </div>
                                <div class="wrap-property wrap-style">
                                    <div class="titles"><h3>Chi tiết dự án</h3></div>
                                    <div class="box flex">
                                        <ul>
                                        @foreach($product->attributes as $attribute_item)
                                            <li class="flex"><span class="one fw-6">{{ $attribute_item->name }}</span><span class="two">{{$attribute_item->pivot->value}}</span></li>
                                          
                                            @if($loop->iteration == floor(count($product->attributes)/2))
                                            </ul><ul>
                                            @endif
                                        @endforeach
                                        </ul>
                                    </div>                              
                                </div>
                                @if(Auth::guest())
                                @else
                                <div class="wrap-map wrap-property wrap-style">
                                    <div class="titles"><h3>Thông tin sale</h3></div>
                                    {!! $product->sale_content !!}
                                </div>
                                @endif
                                
                                <!-- FAQ Section -->
                                <div class="wrap-faq wrap-property wrap-style">
                                    <div class="titles"><h3>Câu hỏi thường gặp</h3></div>
                                    <div class="faq-accordion" id="faqAccordion">
                                        <div class="faq-item">
                                            <div class="faq-header" onclick="toggleFaq(1)">
                                                <h4>Dự án đất nền này có pháp lý đầy đủ không?</h4>
                                                <span class="faq-icon" id="faq-icon-1">+</span>
                                            </div>
                                            <div class="faq-content" id="faq-content-1">
                                                <p>Dự án {{$product->title}} được phát triển với pháp lý hoàn toàn minh bạch và đầy đủ. Chúng tôi cam kết cung cấp đầy đủ các giấy tờ pháp lý theo quy định: Giấy chứng nhận quyền sử dụng đất, Giấy phép xây dựng, Quyết định phê duyệt quy hoạch chi tiết và các văn bản pháp lý liên quan khác.</p>
                                            </div>
                                        </div>
                                        
                                        <div class="faq-item">
                                            <div class="faq-header" onclick="toggleFaq(2)">
                                                <h4>Diện tích thực tế của từng lô đất như thế nào?</h4>
                                                <span class="faq-icon" id="faq-icon-2">+</span>
                                            </div>
                                            <div class="faq-content" id="faq-content-2">
                                                <p>Dự án có nhiều loại diện tích đa dạng từ 80m² đến 500m² tùy theo vị trí và loại đất. Mỗi lô đất đều được đo đạc chính xác, có sổ đỏ riêng biệt và thông tin chi tiết về diện tích, kích thước mặt tiền, chiều sâu. Khách hàng có thể tham khảo sơ đồ phân lô chi tiết và chọn lô phù hợp.</p>
                                            </div>
                                        </div>
                                        
                                        <div class="faq-item">
                                            <div class="faq-header" onclick="toggleFaq(3)">
                                                <h4>Hạ tầng kỹ thuật đã hoàn thiện chưa?</h4>
                                                <span class="faq-icon" id="faq-icon-3">+</span>
                                            </div>
                                            <div class="faq-content" id="faq-content-3">
                                                <p>Dự án đã hoàn thiện 100% hạ tầng kỹ thuật bao gồm: Hệ thống đường bê tông rộng 6-12m, điện ngầm 3 pha, nước máy từ nhà máy nước sạch, hệ thống thoát nước mưa và nước thải, viễn thông internet cáp quang. Khách hàng có thể xây dựng ngay sau khi nhận đất.</p>
                                            </div>
                                        </div>
                                        
                                        <div class="faq-item">
                                            <div class="faq-header" onclick="toggleFaq(4)">
                                                <h4>Thời gian bàn giao sổ đỏ là khi nào?</h4>
                                                <span class="faq-icon" id="faq-icon-4">+</span>
                                            </div>
                                            <div class="faq-content" id="faq-content-4">
                                                <p>Sau khi khách hàng hoàn tất thủ tục mua bán và thanh toán đầy đủ, thời gian bàn giao sổ đỏ trong vòng 30-60 ngày. Đối với các lô đất đã có sổ đỏ riêng, có thể bàn giao ngay. Chúng tôi hỗ trợ khách hàng hoàn tất mọi thủ tục sang tên đổi chủ một cách nhanh chóng.</p>
                                            </div>
                                        </div>
                                        
                                        <div class="faq-item">
                                            <div class="faq-header" onclick="toggleFaq(5)">
                                                <h4>Có chính sách hỗ trợ vay vốn mua đất không?</h4>
                                                <span class="faq-icon" id="faq-icon-5">+</span>
                                            </div>
                                            <div class="faq-content" id="faq-content-5">
                                                <p>Có, chúng tôi hỗ trợ khách hàng vay vốn ngân hàng với lãi suất ưu đãi từ các ngân hàng đối tác như Vietcombank, BIDV, Techcombank. Hỗ trợ vay lên đến 70% giá trị đất với thời hạn vay 15-20 năm. Đội ngũ tư vấn sẽ hỗ trợ khách hàng chuẩn bị hồ sơ và thủ tục vay một cách thuận tiện nhất.</p>
                                            </div>
                                        </div>
                                        
                                        <div class="faq-item">
                                            <div class="faq-header" onclick="toggleFaq(6)">
                                                <h4>Có hạn chế gì về việc xây dựng trên đất không?</h4>
                                                <span class="faq-icon" id="faq-icon-6">+</span>
                                            </div>
                                            <div class="faq-content" id="faq-content-6">
                                                <p>Đất nền trong dự án được phép xây dựng nhà ở theo quy hoạch được duyệt. Khách hàng có thể xây dựng nhà ở từ 1-4 tầng tùy theo quy định từng khu vực. Cần tuân thủ các quy định về lùi đường, mật độ xây dựng và kiến trúc cảnh quan. Chúng tôi sẽ cung cấp bản vẽ quy hoạch chi tiết và hỗ trợ tư vấn thiết kế.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <aside class="side-bar side-bar-1">
                                <div class="inner-side-bar">  
                                    <!-- Price Widget -->
                                    @if($product->price)
                                    <div class="widget-rent style" style="margin-bottom: 20px;">
                                        <h3 class="widget-title title-contact">
                                            Thông tin giá
                                        </h3>
                                        <div class="price-info-widget" style="padding: 15px; background: #fff; border: 1px solid #e0e0e0; border-radius: 8px;">
                                            <div class="main-price" style="font-size: 22px; font-weight: bold; color: #FFA920; margin-bottom: 10px;">
                                                {{number_format($product->price, 0, ',', '.')}} VNĐ
                                            </div>
                                            @if($product->price_per_m2)
                                            <div class="price-per-unit" style="font-size: 14px; color: #666;">
                                                {{number_format($product->price_per_m2, 0, ',', '.')}} VNĐ/m²
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    @endif
                                    <div class="widget-rent style">
                                        <h3 class="widget-title title-contact">
                                            Nhân viên sale
                                        </h3>
                                        <div class="author-box flex align-center">
                                            <div class="image-author flex-none">
                                                <img src="{{$product->user->images->first()->url??''}}" alt="images">
                                            </div>
                                            <div class="content">
                                                <p class="text-color-2">{{$product->user->name}}</p>
                                                <h5 class="link-style-1"><a href="tel:{{$product->user->phone}}">{{$product->user->phone}}</a></h5>
                                                <a class="fs-12 lh-18" href="mailto:{{$product->user->email}}">{{$product->user->email}}</a>
                                            </div>
                                        </div>
                                        <div class="comments">
                                            <div class="comment-form">
                                                <form method="post">
                                                    <div class="wd-find-select ">
                                                        
                                                        <div class="button-box sc-btn-top center flex justify-space">
                                                            <a href="mailto:{{$product->user->email}}" class="sc-button btn-svg">
                                                                <span>Email</span>
                                                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M1.125 6.5025V12.9375C1.125 13.5342 1.36205 14.1065 1.78401 14.5285C2.20597 14.9504 2.77826 15.1875 3.375 15.1875H14.625C15.2217 15.1875 15.794 14.9504 16.216 14.5285C16.6379 14.1065 16.875 13.5342 16.875 12.9375V6.5025L10.179 10.6223C9.82443 10.8404 9.4163 10.9559 9 10.9559C8.5837 10.9559 8.17557 10.8404 7.821 10.6223L1.125 6.5025Z" fill="white"></path>
                                                                    <path d="M16.875 5.181V5.0625C16.875 4.46576 16.6379 3.89347 16.216 3.47151C15.794 3.04955 15.2217 2.8125 14.625 2.8125H3.375C2.77826 2.8125 2.20597 3.04955 1.78401 3.47151C1.36205 3.89347 1.125 4.46576 1.125 5.0625V5.181L8.4105 9.6645C8.58778 9.77357 8.79185 9.83132 9 9.83132C9.20815 9.83132 9.41222 9.77357 9.5895 9.6645L16.875 5.181Z" fill="white"></path>
                                                                </svg>
                                                            </a>
                                                            <a class="sc-button btn-1 btn-svg" href="tel:{{$product->user->phone}}">
                                                                <span>Gọi điện</span>
                                                                <svg width="19" height="18" viewBox="0 0 19 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M15.125 7.31249C15.125 7.46168 15.0657 7.60475 14.9602 7.71024C14.8548 7.81573 14.7117 7.87499 14.5625 7.87499H11.1875C11.0383 7.87499 10.8952 7.81573 10.7898 7.71024C10.6843 7.60475 10.625 7.46168 10.625 7.31249V3.93749C10.625 3.78831 10.6843 3.64523 10.7898 3.53975C10.8952 3.43426 11.0383 3.37499 11.1875 3.37499C11.3367 3.37499 11.4798 3.43426 11.5852 3.53975C11.6907 3.64523 11.75 3.78831 11.75 3.93749V5.95499L15.29 2.41499C15.3415 2.35973 15.4036 2.3154 15.4726 2.28466C15.5416 2.25391 15.6161 2.23738 15.6916 2.23605C15.7671 2.23472 15.8422 2.24861 15.9122 2.2769C15.9822 2.30519 16.0459 2.3473 16.0993 2.40071C16.1527 2.45413 16.1948 2.51775 16.2231 2.5878C16.2514 2.65784 16.2653 2.73286 16.2639 2.80839C16.2626 2.88391 16.2461 2.9584 16.2153 3.0274C16.1846 3.0964 16.1403 3.1585 16.085 3.20999L12.545 6.74999H14.5625C14.7117 6.74999 14.8548 6.80926 14.9602 6.91475C15.0657 7.02024 15.125 7.16331 15.125 7.31249Z" fill="#1C1C1E"></path>
                                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M1.625 3.375C1.625 2.77826 1.86205 2.20597 2.28401 1.78401C2.70597 1.36205 3.27826 1.125 3.875 1.125H4.904C5.549 1.125 6.1115 1.5645 6.26825 2.19L7.097 5.50725C7.16416 5.77575 7.15059 6.05809 7.058 6.31892C6.96542 6.57974 6.79792 6.80744 6.5765 6.9735L5.60675 7.701C5.5055 7.77675 5.48375 7.88775 5.51225 7.965C5.93553 9.11614 6.60395 10.1615 7.47121 11.0288C8.33847 11.8961 9.38386 12.5645 10.535 12.9877C10.6123 13.0162 10.7225 12.9945 10.799 12.8932L11.5265 11.9235C11.6926 11.7021 11.9203 11.5346 12.1811 11.442C12.4419 11.3494 12.7243 11.3358 12.9928 11.403L16.31 12.2318C16.9355 12.3885 17.375 12.951 17.375 13.5968V14.625C17.375 15.2217 17.1379 15.794 16.716 16.216C16.294 16.6379 15.7217 16.875 15.125 16.875H13.4375C6.914 16.875 1.625 11.586 1.625 5.0625V3.375Z" fill="#1C1C1E"></path>
                                                                </svg>
                                                            </a>
                                                        </div> 
                                                    </div>
                                                </form>
                                            </div> 
                                        </div>
                                    </div>
                                    <div class="widget widget-listings style"> 
                                        <h3 class="widget-title title-list">
                                            Dự án nổi bật
                                        </h3>                  
                                        @foreach ($products as $p)                                                                                                      
                                        <div class="box-listings flex hover-img3">
                                            <div class="img-listings img-style3">
                                                <img style="width: 120px;" src="{{ asset($p->images->first()->url ?? '')}}" alt="{{$p->title}}">
                                            </div>
                                            <div class="content link-style-1">
                                                <a class="fs-16 lh-24" href="{{ route('product.detail',['alias' => $p->slug]) }}">{{$p->title}}</a>
                                                <h4>{{number_format($p->price,0)}} VNĐ</h4>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    
                                    <!-- Khu vực lân cận with updated HTML structure -->
                                    <div class="widget widget-estate">
                                        <h3 class="widget-title title-news">
                                            Khu vực lân cận
                                        </h3>                       
                                        <ul class="group-estate flex">
                                            @foreach($wards as $ward)
                                                @php
                                                    // Only use the #2c3e50 color for all items as requested
                                                    $darkColor = '#2c3e50';
                                                    // Generate slug if not available
                                                    $wardSlug = $ward->slug ?? \Illuminate\Support\Str::slug($ward->name);
                                                    
                                                @endphp
                                                <li class="box-estate hover-img2">
                                                    <div class="thumb img-style2" style="background-color: {{ $darkColor }}; height: 80px; display: flex; align-items: center; justify-content: center;">
                                                        
                                                    </div>
                                                    <div class="content">    
                                                        <div class="title link-style-3 fw-6 lh-18"><a href="{{ route('product.ward', ['slug' => $wardSlug]) }}">{{ $ward->name }}</a></div>                              
                                                        <p class="fs-12 lh-16 text-color-1">{{ $ward->products_count }} dự án</p>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    
                                   
                                </div>
                            </aside>
                        </div>
                    </div>
                </div>
            </section>
@endsection
@section('scripts')
<script>
    // FAQ Accordion functionality
    function toggleFaq(index) {
        const content = document.getElementById('faq-content-' + index);
        const icon = document.getElementById('faq-icon-' + index);
        
        // Close all other FAQ items
        const allContents = document.querySelectorAll('.faq-content');
        const allIcons = document.querySelectorAll('.faq-icon');
        
        allContents.forEach((item, i) => {
            if (i !== index - 1) {
                item.classList.remove('active');
                allIcons[i].classList.remove('active');
                allIcons[i].textContent = '+';
            }
        });
        
        // Toggle current FAQ item
        if (content.classList.contains('active')) {
            content.classList.remove('active');
            icon.classList.remove('active');
            icon.textContent = '+';
        } else {
            content.classList.add('active');
            icon.classList.add('active');
            icon.textContent = '−';
        }
    }

    $(function(){
        console.log('Product detail ready');
        
        // Make sure header is visible
        $('header.main-header').css({
            'display': 'block',
            'visibility': 'visible',
            'opacity': '1'
        });
    })
</script>
@endsection