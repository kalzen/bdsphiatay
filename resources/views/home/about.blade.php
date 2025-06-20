@extends('layouts.master')

@section('title', 'Về Phía Tây - Công ty Bất động sản Cao Bằng')

@section('meta')
<meta name="keywords" content="về phía tây, công ty bất động sản cao bằng, bất động sản uy tín, mua bán nhà đất cao bằng, đầu tư bất động sản">
<meta name="description" content="Công ty TNHH Bất động sản Phía Tây - Chuyên tư vấn, môi giới bất động sản tại Cao Bằng. Giám đốc Nguyễn Trung Kiên với đội ngũ chuyên nghiệp, uy tín.">
<meta property="og:title" content="Về Phía Tây - Công ty Bất động sản Cao Bằng">
<meta property="og:description" content="Công ty TNHH Bất động sản Phía Tây - Chuyên tư vấn, môi giới bất động sản tại Cao Bằng. Giám đốc Nguyễn Trung Kiên với đội ngũ chuyên nghiệp, uy tín.">
<meta property="og:type" content="website">
<meta property="og:url" content="{{url()->current()}}">
<meta property="og:image" content="{{asset('favicon.png')}}">
@endsection

@section('schema_markup')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Organization",
  "name": "Công ty TNHH Bất động sản Phía Tây",
  "alternateName": "Bất động sản Phía Tây",
  "url": "{{url('/')}}",
  "logo": "{{asset('favicon.png')}}",
  "description": "Chuyên tư vấn, môi giới bất động sản tại Cao Bằng",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "SN181 tổ 9, Phường Hợp Giang",
    "addressLocality": "Thành phố Cao Bằng",
    "addressRegion": "Tỉnh Cao Bằng",
    "addressCountry": "VN"
  },
  "taxID": "4800933757",
  "founder": {
    "@type": "Person",
    "name": "Nguyễn Trung Kiên",
    "jobTitle": "Giám đốc"
  },
  "knowsAbout": ["Bất động sản", "Tư vấn đầu tư", "Môi giới nhà đất", "Dự án bất động sản"],
  "areaServed": {
    "@type": "Place",
    "name": "Cao Bằng, Việt Nam"
  }
}
</script>
@endsection

@section('styles')
<!-- Icon Moon CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@iconscout/unicons@4.0.8/css/line.css">
<style>
    /* About Page Styles */
    .about-hero {
        background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('{{asset('phiatay/assets/images/slider/bg-slider-3.jpg')}}');
        background-size: cover;
        background-position: center;
        padding: 100px 0;
        color: white;
        text-align: center;
    }
    
    .about-section {
        padding: 80px 0;
    }
    
    .about-card {
        background: white;
        border-radius: 15px;
        padding: 40px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        margin-bottom: 30px;
        transition: transform 0.3s ease;
    }
    
    .about-card:hover {
        transform: translateY(-10px);
    }
    
    .about-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #FFA920, #FF8C00);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-size: 2.5rem;
        color: white;
    }
    
    .company-info {
        background: #f8f9fa;
        padding: 60px 0;
    }
    
    .info-box {
        background: white;
        padding: 30px;
        border-radius: 10px;
        border-left: 5px solid #FFA920;
        margin-bottom: 20px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    }
    
    .info-box h5 {
        color: #FFA920;
        margin-bottom: 10px;
        font-weight: 600;
    }
    
    .info-box p {
        margin: 0;
        color: #666;
    }
    
    .section-title {
        text-align: center;
        margin-bottom: 60px;
    }
    
    .section-title h2 {
        color: #333;
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 15px;
    }
    
    .section-title p {
        color: #666;
        font-size: 1.1rem;
        max-width: 600px;
        margin: 0 auto;
    }
    
    .ceo-quote {
        background: linear-gradient(135deg, #FFA920, #FF8C00);
        color: white;
        padding: 60px 0;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    
    .ceo-quote::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('{{asset('phiatay/assets/images/slider/bg-slider-3.jpg')}}');
        background-size: cover;
        background-position: center;
        opacity: 0.1;
    }
    
    .ceo-quote .container {
        position: relative;
        z-index: 2;
    }
    
    .quote-text {
        font-size: 1.3rem;
        font-style: italic;
        margin-bottom: 30px;
        line-height: 1.8;
    }
    
    .quote-author {
        font-size: 1.1rem;
        font-weight: 600;
    }
    
    .stats-section {
        background: #333;
        color: white;
        padding: 80px 0;
    }
    
    .stat-item {
        text-align: center;
        margin-bottom: 30px;
    }
    
    .stat-number {
        font-size: 3rem;
        font-weight: 700;
        color: #FFA920;
        display: block;
    }
    
    .stat-label {
        font-size: 1.1rem;
        margin-top: 10px;
    }
</style>
@endsection

@section('content')
<!-- Hero Section -->
<section class="about-hero">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="fs-60 font-2 fw-8 mb-3">Về Phía Tây</h1>
                <p class="fs-18">Công ty TNHH Bất động sản Phía Tây - Đối tác tin cậy trong lĩnh vực bất động sản Cao Bằng</p>
            </div>
        </div>
    </div>
</section>

<!-- Company Introduction -->
<section class="about-section">
    <div class="container">
        <div class="section-title">
            <h2>Giới thiệu công ty</h2>
            <p>Chúng tôi là đơn vị hàng đầu chuyên về tư vấn và môi giới bất động sản tại Cao Bằng</p>
        </div>
        
        <div class="row">
            <div class="col-lg-6">
                <div class="about-card">
                    <h3 class="mb-4">Câu chuyện của chúng tôi</h3>
                    <p class="mb-3">
                        Công ty TNHH Bất động sản Phía Tây được thành lập với sứ mệnh mang đến những giải pháp bất động sản tốt nhất cho người dân Cao Bằng. Với kinh nghiệm nhiều năm trong lĩnh vực này, chúng tôi hiểu rõ nhu cầu và mong muốn của khách hàng.
                    </p>
                    <p class="mb-3">
                        Dưới sự lãnh đạo của Giám đốc Nguyễn Trung Kiên, công ty đã không ngừng phát triển và khẳng định vị thế trên thị trường bất động sản địa phương.
                    </p>
                    <p>
                        Chúng tôi cam kết mang đến dịch vụ chuyên nghiệp, uy tín và hiệu quả nhất cho mọi khách hàng.
                    </p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about-card">
                    <h3 class="mb-4">Dịch vụ chính</h3>
                    <ul class="list-unstyled">
                        <li class="mb-3"><i class="uil uil-check-circle text-warning me-2"></i> Tư vấn đầu tư bất động sản</li>
                        <li class="mb-3"><i class="uil uil-check-circle text-warning me-2"></i> Môi giới mua bán nhà đất</li>
                        <li class="mb-3"><i class="uil uil-check-circle text-warning me-2"></i> Cho thuê bất động sản</li>
                        <li class="mb-3"><i class="uil uil-check-circle text-warning me-2"></i> Định giá bất động sản</li>
                        <li class="mb-3"><i class="uil uil-check-circle text-warning me-2"></i> Tư vấn pháp lý bất động sản</li>
                        <li class="mb-3"><i class="uil uil-check-circle text-warning me-2"></i> Quản lý và vận hành dự án</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Vision, Mission, Goals -->
<section class="about-section" style="background: #f8f9fa;">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="about-card text-center">
                    <div class="about-icon">
                        <i class="uil uil-eye"></i>
                    </div>
                    <h4 class="mb-3">Tầm nhìn</h4>
                    <p>Trở thành công ty bất động sản hàng đầu tại Cao Bằng, được khách hàng tin tưởng và lựa chọn số 1 trong các dịch vụ tư vấn, môi giới bất động sản.</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="about-card text-center">
                    <div class="about-icon">
                        <i class="uil uil-heart"></i>
                    </div>
                    <h4 class="mb-3">Sứ mệnh</h4>
                    <p>Kết nối khách hàng với những cơ hội bất động sản tốt nhất, mang đến giá trị bền vững và góp phần phát triển thị trường bất động sản Cao Bằng.</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="about-card text-center">
                    <div class="about-icon">
                        <i class="uil uil-target"></i>
                    </div>
                    <h4 class="mb-3">Mục tiêu</h4>
                    <p>Cung cấp dịch vụ chất lượng cao, xây dựng mối quan hệ lâu dài với khách hàng và đối tác, đóng góp tích cực vào sự phát triển kinh tế địa phương.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CEO Quote -->
<section class="ceo-quote">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="quote-text">
                    "Chúng tôi không chỉ môi giới bất động sản, mà còn là người bạn đồng hành tin cậy, giúp khách hàng hiện thực hóa ước mơ về một mái ấm lý tưởng và những khoản đầu tư sinh lời."
                </div>
                <div class="quote-author">
                    <strong>Nguyễn Trung Kiên</strong><br>
                    <span>Giám đốc Công ty TNHH Bất động sản Phía Tây</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Company Information -->
<section class="company-info">
    <div class="container">
        <div class="section-title">
            <h2>Thông tin công ty</h2>
            <p>Thông tin chi tiết về Công ty TNHH Bất động sản Phía Tây</p>
        </div>
        
        <div class="row">
            <div class="col-lg-6">
                <div class="info-box">
                    <h5><i class="uil uil-building me-2"></i>Tên công ty</h5>
                    <p>Công ty TNHH Bất động sản Phía Tây</p>
                </div>
                
                <div class="info-box">
                    <h5><i class="uil uil-user-circle me-2"></i>Giám đốc</h5>
                    <p>Nguyễn Trung Kiên</p>
                </div>
                
                <div class="info-box">
                    <h5><i class="uil uil-receipt me-2"></i>Mã số thuế</h5>
                    <p>4800933757</p>
                </div>
            </div>
            
            <div class="col-lg-6">
                <div class="info-box">
                    <h5><i class="uil uil-map-marker me-2"></i>Địa chỉ</h5>
                    <p>SN181 tổ 9, Phường Hợp Giang, Thành phố Cao Bằng, Tỉnh Cao Bằng, Việt Nam</p>
                </div>
                
                <div class="info-box">
                    <h5><i class="uil uil-briefcase me-2"></i>Lĩnh vực hoạt động</h5>
                    <p>Tư vấn, môi giới bất động sản Cao Bằng</p>
                </div>
                
                <div class="info-box">
                    <h5><i class="uil uil-award me-2"></i>Giá trị cốt lõi</h5>
                    <p>Uy tín - Chuyên nghiệp - Hiệu quả - Tận tâm</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Statistics -->
<section class="stats-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="stat-item">
                    <span class="stat-number">500+</span>
                    <div class="stat-label">Khách hàng hài lòng</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-item">
                    <span class="stat-number">200+</span>
                    <div class="stat-label">Giao dịch thành công</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-item">
                    <span class="stat-number">50+</span>
                    <div class="stat-label">Dự án đã tư vấn</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-item">
                    <span class="stat-number">5+</span>
                    <div class="stat-label">Năm kinh nghiệm</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Us -->
<section class="about-section">
    <div class="container">
        <div class="section-title">
            <h2>Tại sao chọn chúng tôi?</h2>
            <p>Những lý do khiến khách hàng tin tưởng và lựa chọn Bất động sản Phía Tây</p>
        </div>
        
        <div class="row">
            <div class="col-lg-4">
                <div class="about-card text-center">
                    <div class="about-icon">
                        <i class="uil uil-users-alt"></i>
                    </div>
                    <h4 class="mb-3">Đội ngũ chuyên nghiệp</h4>
                    <p>Đội ngũ tư vấn viên giàu kinh nghiệm, am hiểu thị trường địa phương, luôn tận tâm với khách hàng.</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="about-card text-center">
                    <div class="about-icon">
                        <i class="uil uil-shield-check"></i>
                    </div>
                    <h4 class="mb-3">Uy tín đáng tin cậy</h4>
                    <p>Hoạt động minh bạch, pháp lý rõ ràng, cam kết bảo vệ quyền lợi tối đa cho khách hàng.</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="about-card text-center">
                    <div class="about-icon">
                        <i class="uil uil-clock-three"></i>
                    </div>
                    <h4 class="mb-3">Dịch vụ nhanh chóng</h4>
                    <p>Quy trình làm việc chuyên nghiệp, xử lý nhanh chóng, tiết kiệm thời gian cho khách hàng.</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection