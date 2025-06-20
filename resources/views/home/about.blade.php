@extends('layouts.master')

@section('title', 'Về Phía Tây - Công ty Bất động sản hàng đầu')

@section('meta')
<meta name="keywords" content="về phía tây, công ty bất động sản, bất động sản uy tín, mua bán nhà đất, đầu tư bất động sản">
<meta name="description" content="Phía Tây - Công ty bất động sản uy tín hàng đầu, chuyên cung cấp dịch vụ mua bán, cho thuê nhà đất và phát triển dự án bất động sản chất lượng cao.">
<meta property="og:title" content="Về Phía Tây - Công ty Bất động sản hàng đầu">
<meta property="og:description" content="Phía Tây - Công ty bất động sản uy tín hàng đầu, chuyên cung cấp dịch vụ mua bán, cho thuê nhà đất và phát triển dự án bất động sản chất lượng cao.">
<meta property="og:image" content="{{asset('favicon.png')}}">
<meta property="og:url" content="{{route('about')}}">
<meta property="og:type" content="website">
@endsection

@section('schema_markup')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "AboutPage",
  "mainEntity": {
    "@type": "Organization",
    "name": "Bất động sản Phía Tây",
    "url": "{{url('/')}}",
    "logo": "{{$shared_config['logo']['value']}}",
    "contactPoint": {
      "@type": "ContactPoint",
      "telephone": "{{$shared_config['hotline']['value']}}",
      "contactType": "customer service",
      "availableLanguage": "Vietnamese"
    },
    "address": {
      "@type": "PostalAddress",
      "addressCountry": "VN",
      "addressLocality": "Việt Nam"
    },
    "sameAs": [
      "{{$shared_config['facebook']['value'] ?? ''}}"
    ],
    "description": "Phía Tây là công ty bất động sản uy tín hàng đầu, chuyên cung cấp dịch vụ mua bán, cho thuê nhà đất và phát triển dự án bất động sản chất lượng cao.",
    "foundingDate": "2015",
    "numberOfEmployees": "100+",
    "slogan": "Kết nối ước mơ - Kiến tạo tương lai"
  }
}
</script>
@endsection

@section('content')
<div class="page-layout">
    <!-- Page Title -->
    <section class="flat-title">
        <div class="container">
            <div class="row">                      
                <div class="col-lg-12">
                    <div class="title-inner style">
                        <div class="title-group fs-12">
                            <a class="home fw-6 text-color-3" href="{{route('index')}}">Trang chủ</a>
                            <span>Về Phía Tây</span>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="flat-about">
        <div class="container">
            <div class="row">                      
                <div class="col-lg-7 col-md-7">
                    <div class="heading-about">
                        <h2>Kết nối ước mơ - Kiến tạo tương lai</h2>
                        <h4>Phía Tây là công ty bất động sản uy tín hàng đầu với hơn 8 năm kinh nghiệm, chuyên cung cấp các dịch vụ mua bán, cho thuê nhà đất và phát triển dự án bất động sản chất lượng cao.</h4>
                        <p class="text-1 text-color-2">Chúng tôi tự hào là đối tác tin cậy của hàng nghìn khách hàng trong hành trình tìm kiếm và đầu tư bất động sản. Với đội ngũ chuyên viên giàu kinh nghiệm và am hiểu thị trường, Phía Tây cam kết mang đến những giải pháp tối ưu nhất cho mọi nhu cầu của khách hàng.</p>
                        <div class="text-box">
                            <p class="font-2 fw-5 font-italic text-color-2">"Chúng tôi không chỉ bán nhà đất, mà còn kiến tạo những ước mơ và tương lai tươi sáng cho mỗi gia đình Việt Nam"</p>
                        </div>
                        <div class="group-author flex">
                            <div class="box-author flex align-center">
                                <div class="avatar">
                                    <img src="{{asset('phiatay/assets/images/avatar/avt-about.jpg')}}" alt="CEO Phía Tây">
                                </div>
                                <div class="info">
                                    <h4 class="fw-6 font-2">Nguyễn Văn Minh</h4>
                                    <p class="fs-12 font-2">CEO & Founder</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>  
                <div class="col-lg-5 col-md-5">
                    <div class="image-about">
                        <img src="{{asset('phiatay/assets/images/banner/about-banner.jpg')}}" alt="Về Phía Tây">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Vision Mission Goals Section -->
    <section class="flat-iconbox bg-color-7">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="heading-section center">
                        <h2 class="fw-8 font-2 lh-56">Tầm nhìn - Sứ mệnh - Mục tiêu</h2>
                        <p class="">Định hướng phát triển và giá trị cốt lõi của Phía Tây</p>
                    </div>
                </div>
                
                <!-- Vision -->
                <div class="col-lg-4 col-md-4">
                    <div class="box-icon flex align-center">
                        <div class="icon relative flex-none">
                            <svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M40 8L52 32H28L40 8Z" fill="#FFA920"/>
                                <circle cx="40" cy="50" r="22" fill="#FFA920" opacity="0.2"/>
                                <circle cx="40" cy="50" r="12" fill="#FFA920"/>
                            </svg>
                        </div>
                        <div class="content">
                            <h4 class="title fw-6 font-2">Tầm nhìn</h4>
                            <p class="text-color-2">Trở thành công ty bất động sản hàng đầu Việt Nam, tiên phong trong việc ứng dụng công nghệ hiện đại và cung cấp dịch vụ chất lượng cao nhất cho khách hàng.</p>
                        </div>
                    </div>
                </div>

                <!-- Mission -->
                <div class="col-lg-4 col-md-4">
                    <div class="box-icon flex align-center">
                        <div class="icon relative flex-none">
                            <svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect x="20" y="25" width="40" height="30" rx="5" fill="#FFA920" opacity="0.2"/>
                                <path d="M25 35L35 45L55 25" stroke="#FFA920" stroke-width="3" fill="none"/>
                                <circle cx="40" cy="15" r="8" fill="#FFA920"/>
                            </svg>
                        </div>
                        <div class="content">
                            <h4 class="title fw-6 font-2">Sứ mệnh</h4>
                            <p class="text-color-2">Kết nối và hỗ trợ khách hàng tìm kiếm, sở hữu những bất động sản ưng ý với giá trị tốt nhất. Đồng thời phát triển các dự án bất động sản bền vững, góp phần xây dựng đô thị hiện đại.</p>
                        </div>
                    </div>
                </div>

                <!-- Goals -->
                <div class="col-lg-4 col-md-4">
                    <div class="box-icon flex align-center">
                        <div class="icon relative flex-none">
                            <svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M15 40L25 50L40 35L55 50L65 40" stroke="#FFA920" stroke-width="3" fill="none"/>
                                <rect x="12" y="52" width="6" height="15" fill="#FFA920"/>
                                <rect x="22" y="47" width="6" height="20" fill="#FFA920"/>
                                <rect x="37" y="42" width="6" height="25" fill="#FFA920"/>
                                <rect x="52" y="47" width="6" height="20" fill="#FFA920"/>
                                <rect x="62" y="52" width="6" height="15" fill="#FFA920"/>
                            </svg>
                        </div>
                        <div class="content">
                            <h4 class="title fw-6 font-2">Mục tiêu</h4>
                            <p class="text-color-2">Phục vụ hơn 10,000 khách hàng mỗi năm, phát triển 50+ dự án chất lượng cao và mở rộng mạng lưới ra toàn quốc trong 5 năm tới.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Core Values Section -->
    <section class="flat-why-choose-us">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="content-left">
                        <div class="heading-section">
                            <h2 class="fw-8 font-2 lh-56">Giá trị cốt lõi của Phía Tây</h2>
                            <p class="">Những nguyên tắc và giá trị mà chúng tôi luôn theo đuổi</p>
                        </div>
                        <div class="list-number-icon">
                            <div class="number-icon-box flex align-center">
                                <div class="icon-number">01</div>
                                <div class="content">
                                    <h4 class="title">Uy tín & Minh bạch</h4>
                                    <p class="text-color-2">Cam kết cung cấp thông tin chính xác, minh bạch trong mọi giao dịch và luôn đặt lợi ích khách hàng lên hàng đầu.</p>
                                </div>
                            </div>
                            <div class="number-icon-box flex align-center">
                                <div class="icon-number">02</div>
                                <div class="content">
                                    <h4 class="title">Chuyên nghiệp & Tận tâm</h4>
                                    <p class="text-color-2">Đội ngũ nhân viên được đào tạo bài bản, có kinh nghiệm và luôn tận tâm phục vụ khách hàng một cách tốt nhất.</p>
                                </div>
                            </div>
                            <div class="number-icon-box flex align-center">
                                <div class="icon-number">03</div>
                                <div class="content">
                                    <h4 class="title">Đổi mới & Sáng tạo</h4>
                                    <p class="text-color-2">Không ngừng ứng dụng công nghệ mới, cải tiến dịch vụ để mang lại trải nghiệm tốt nhất cho khách hàng.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="image-box">
                        <img src="{{asset('phiatay/assets/images/banner/values-image.jpg')}}" alt="Giá trị cốt lõi">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section class="flat-counter bg-color-1">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="counter-box center">
                        <div class="icon">
                            <svg width="60" height="60" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M30 5L35 20H25L30 5Z" fill="#FFA920"/>
                                <rect x="15" y="25" width="30" height="25" rx="5" fill="#FFA920" opacity="0.7"/>
                                <circle cx="30" cy="35" r="8" fill="white"/>
                            </svg>
                        </div>
                        <div class="content">
                            <h3 class="number fw-8" data-speed="2000" data-to="8" data-inviewport="yes">8</h3>
                            <p class="text-color-4">Năm kinh nghiệm</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="counter-box center">
                        <div class="icon">
                            <svg width="60" height="60" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="20" cy="20" r="12" fill="#FFA920" opacity="0.7"/>
                                <circle cx="40" cy="25" r="12" fill="#FFA920" opacity="0.7"/>
                                <circle cx="30" cy="40" r="12" fill="#FFA920" opacity="0.7"/>
                            </svg>
                        </div>
                        <div class="content">
                            <h3 class="number fw-8" data-speed="2000" data-to="5000" data-inviewport="yes">5000+</h3>
                            <p class="text-color-4">Khách hàng tin tựa</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="counter-box center">
                        <div class="icon">
                            <svg width="60" height="60" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect x="10" y="15" width="40" height="30" rx="5" fill="#FFA920" opacity="0.7"/>
                                <rect x="15" y="20" width="12" height="8" fill="white"/>
                                <rect x="33" y="20" width="12" height="8" fill="white"/>
                                <rect x="15" y="32" width="30" height="4" fill="white"/>
                            </svg>
                        </div>
                        <div class="content">
                            <h3 class="number fw-8" data-speed="2000" data-to="150" data-inviewport="yes">150+</h3>
                            <p class="text-color-4">Dự án thành công</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="counter-box center">
                        <div class="icon">
                            <svg width="60" height="60" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M30 10L40 25H20L30 10Z" fill="#FFA920"/>
                                <circle cx="15" cy="35" r="8" fill="#FFA920" opacity="0.7"/>
                                <circle cx="30" cy="45" r="8" fill="#FFA920" opacity="0.7"/>
                                <circle cx="45" cy="35" r="8" fill="#FFA920" opacity="0.7"/>
                            </svg>
                        </div>
                        <div class="content">
                            <h3 class="number fw-8" data-speed="2000" data-to="50" data-inviewport="yes">50+</h3>
                            <p class="text-color-4">Chuyên viên giỏi</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="flat-call-to-action bg-color-3">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="content-left">
                        <h2 class="text-white">Bạn đang tìm kiếm bất động sản ưng ý?</h2>
                        <p class="text-white">Hãy để Phía Tây đồng hành cùng bạn trong hành trình tìm kiếm và đầu tư bất động sản</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="content-right">
                        <a href="{{route('contact')}}" class="tf-btn bg-color-primary text-color-white">Liên hệ ngay
                            <i class="icon-MagnifyingGlass"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('styles')
<style>
    .flat-about .heading-about h2 {
        color: #1a1a1a;
        margin-bottom: 20px;
    }
    
    .flat-about .heading-about h4 {
        color: #666;
        font-weight: 400;
        line-height: 1.6;
        margin-bottom: 20px;
    }

    .flat-iconbox .box-icon {
        padding: 30px;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        margin-bottom: 30px;
        transition: all 0.3s ease;
    }

    .flat-iconbox .box-icon:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.15);
    }

    .flat-iconbox .box-icon .icon {
        margin-right: 20px;
    }

    .flat-counter {
        padding: 80px 0;
        background: linear-gradient(135deg, #FFA920 0%, #FF8C00 100%);
    }

    .counter-box {
        padding: 40px 20px;
        background: rgba(255,255,255,0.1);
        border-radius: 15px;
        backdrop-filter: blur(10px);
        margin-bottom: 30px;
    }

    .counter-box .icon {
        margin-bottom: 20px;
    }

    .counter-box .number {
        color: white;
        font-size: 48px;
        margin-bottom: 10px;
    }

    .counter-box p {
        color: rgba(255,255,255,0.9);
        font-size: 16px;
        margin: 0;
    }

    .flat-call-to-action {
        background: linear-gradient(135deg, #1a1a1a 0%, #333 100%);
        padding: 60px 0;
    }

    .number-icon-box {
        margin-bottom: 30px;
        padding: 20px 0;
    }

    .icon-number {
        width: 60px;
        height: 60px;
        background: #FFA920;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 20px;
        margin-right: 20px;
        flex-shrink: 0;
    }
</style>
@endsection