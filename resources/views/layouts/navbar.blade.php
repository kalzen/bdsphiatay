    <!-- Header-->
    <!-- Navbar top-->
    <nav class="navbar navbar-expand-lg navbar-top  bg-white">
        <div class="container"><a class="navbar-brand" href="{{route('index')}}"><img
                    src="{{asset('hocvienielts/logo.png')}}" alt="logo"></a><a
                class="navbar-toggle order-4 popup-inline"
                href="#navbar-mobile-style-1"><span></span><span></span><span></span></a>
            <ul class="nav navbar-nav order-2 ms-auto nav-no-opacity">
                <li class="nav-item navbar-dropdown"><a class="nav-link" href="{{route('index')}}"><span>Trang
                            chủ</span></a>
                </li>
                <li class="nav-item navbar-dropdown"><a class="nav-link" href="{{ route('post.category', ['alias' => 'gioi-thieu'])}}"><span>Giới thiệu</span></a>
                    <div class="dropdown-menu rounded-2 shadow">
                        <ul class="nav navbar-nav">
                            <li class="nav-item"><a class="nav-link"
                                    href="/tin-tuc/doi-loi-tam-su-ve-the-ielts-academy"><span>Về TIA</span></a></li>
                            <li class="nav-item"><a class="nav-link" href="#"><span>Đội ngũ giảng viên</span></a></li>
                            <li class="nav-item"><a class="nav-link" href="#"><span>Cảm nhận học viên</span></a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item navbar-dropdown"><a class="nav-link"
                        href="{{ route('post.category', ['alias' => 'khoa-hoc'])}}"><span>Khóa Học</span></a>
                    <div class="dropdown-menu rounded-2 shadow">
                        <ul class="nav navbar-nav">
                            <li class="nav-item"><a class="nav-link" href="/tin-tuc/khoa-hoc-ielts-foudation">IELTS
                                    FOUNDATION</a></li>
                            <li class="nav-item"><a class="nav-link" href="/tin-tuc/khoa-hoc-forward-ielts">FORWARD
                                    IELTS</a></li>
                            <li class="nav-item"><a class="nav-link" href="/tin-tuc/khoa-hoc-ielts-advanced">IELTS
                                    ADVANCED</a></li>
                            <li class="nav-item"><a class="nav-link" href="/tin-tuc/khoa-hoc-ielts-coaching">IELTS
                                    COACHING</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item navbar-dropdown"><a class="nav-link" href="{{ route('advise')}}"><span>Tư
                            vấn</span></a>

                </li>
                <li class="nav-item navbar-dropdown"><a class="nav-link"
                        href="{{ route('post.category', ['alias' => 'tai-lieu'])}}"><span>Tài liệu</span></a>
                    <div class="dropdown-menu rounded-2 shadow">
                        <ul class="nav navbar-nav">
                            <li class="nav-item"><a class="nav-link" href="{{ route('post.category', ['alias' => 'ielts-listening'])}}">IELTS LISTENING</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('post.category', ['alias' => 'ielts-reading'])}}">IELTS READING</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('post.category', ['alias' => 'ielts-speaking'])}}">IELTS SPEAKING</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('post.category', ['alias' => 'ielts-writing'])}}">IELTS WRITING</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('post.category', ['alias' => 'chia-se-phuong-phap'])}}">Chia sẻ phương
                                    pháp</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item navbar-dropdown"><a class="nav-link" href="/danh-muc-tin-tuc/tin-tuc-tia"><span>Tin
                            tức</span></a>
                </li>
                <li class="nav-item navbar-dropdown"><a class="nav-link" href="{{ route('contact')}}"><span>Liên
                            hệ</span></a>
                </li>
            </ul>
        </div>
    </nav><!-- Navbar mobile-->
    <div class="navbar navbar-mobile navbar-mobile-style-1 bg-white mfp-hide" id="navbar-mobile-style-1">
        <div class="navbar-wrapper">
            <div class="navbar-head"><a class="navbar-brand d-block d-md-none" href="{{route('index')}}"><img
                        src="{{asset('hocvienielts/logo.png')}}" alt="logo"></a><a
                    class="navbar-toggle popup-modal-dismiss" href="#"><span></span><span></span><span></span></a></div>
            <div class="navbar-body">
                <ul class="nav navbar-nav navbar-nav-collapse">
                    <li class="nav-item navbar-collapse"><a class="nav-link" href="{{route('index')}}"><span>Trang
                                chủ</span></a>
                    </li>
                    <li class="nav-item navbar-collapse"><a class="nav-link" href="{{route('about')}}"
                            data-bs-toggle="collapse" role="button" aria-expanded="false"
                            data-bs-target="#navbarCollapsePagesAbout" aria-controls="navbarCollapseServices"><span>Giới
                                thiệu</span></a>
                        <div class="navbar-collapse-menu collapse" id="navbarCollapsePagesAbout">
                            <ul class="nav navbar-nav">
                                <li class="nav-item"><a class="nav-link"
                                        href="/tin-tuc/doi-loi-tam-su-ve-the-ielts-academy"><span>Về TIA</span></a></li>
                                <li class="nav-item"><a class="nav-link" href="#"><span>Đội ngũ giảng viên</span></a>
                                </li>
                                <li class="nav-item"><a class="nav-link" href="#"><span>Cảm nhận học viên</span></a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item navbar-collapse"><a class="nav-link"
                            href="{{ route('post.category', ['alias' => 'khoa-hoc'])}}" data-bs-toggle="collapse"
                            data-bs-target="#navbarCollapsePages" role="button" aria-expanded="false"
                            aria-controls="navbarCollapsePages"><span>Khóa học</span></a>
                        <div class="navbar-collapse-menu collapse" id="navbarCollapsePages">
                            <ul class="nav navbar-nav">
                                <li class="nav-item"><a class="nav-link" href="/tin-tuc/khoa-hoc-ielts-foudation">IELTS
                                        FOUNDATION</a></li>
                                <li class="nav-item"><a class="nav-link" href="/tin-tuc/khoa-hoc-forward-ielts">FORWARD
                                        IELTS</a></li>
                                <li class="nav-item"><a class="nav-link" href="/tin-tuc/khoa-hoc-ielts-advanced">IELTS
                                        ADVANCED</a></li>
                                <li class="nav-item"><a class="nav-link" href="/tin-tuc/khoa-hoc-ielts-coaching">IELTS
                                        COACHING</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item navbar-collapse"><a class="nav-link"
                            href="{{ route('post.category', ['alias' => 'tai-lieu'])}}" data-bs-toggle="collapse"
                            data-bs-target="#navbarCollapsePages1" role="button" aria-expanded="false"
                            aria-controls="navbarCollapsePortfolio"><span>Tài liệu</span></a>
                        <div class="navbar-collapse-menu collapse" id="navbarCollapsePages1">
                            <ul class="nav navbar-nav">
                            <li class="nav-item"><a class="nav-link" href="{{ route('post.category', ['alias' => 'ielts-listening'])}}">IELTS LISTENING</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('post.category', ['alias' => 'ielts-reading'])}}">IELTS READING</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('post.category', ['alias' => 'ielts-speaking'])}}">IELTS SPEAKING</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('post.category', ['alias' => 'ielts-writing'])}}">IELTS WRITING</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('post.category', ['alias' => 'chia-se-phuong-phap'])}}">Chia sẻ phương
                                    pháp</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item navbar-collapse"><a class="nav-link" href="{{ route('advise')}}"
                         role="button" aria-expanded="false"
                            aria-controls="navbarCollapseBlog"><span>Tư vấn</span></a>

                    </li>
                    <li class="nav-item navbar-collapse"><a class="nav-link" href="/danh-muc-tin-tuc/tin-tuc-tia"
                             role="button" aria-expanded="false"
                            aria-controls="navbarCollapseContact"><span>Tin tức</span></a>
                    </li>
                    <li class="nav-item navbar-collapse"><a href="{{ route('contact') }}" class="nav-link"><span>Liên
                                hệ</span></a>
                    </li>
                </ul>
            </div>
            <div class="navbar-footer">
                <!-- Contacts-->
                <ul class="list-group borderless font-size-15">
                    <li class="list-group-item">Email: <a href="mailto:mail@example.com">{{  $shared_config['email']->value }}</a></li>
                    <li class="list-group-item">Phone: <a href="tel:{{  $shared_config['hotline']->value }}">{{  $shared_config['hotline']->value }}</a></li>
                </ul><!-- Social-->
                <ul class="nav nav-gap-sm navbar-nav nav-social mt-30 nav-no-opacity">
                    <li class="nav-item"><a class="nav-link" target="_blank" href="{{  $shared_config['facebook']->value }}"><svg xmlns="http://www.w3.org/2000/svg" width="8"
                                height="15" fill="none">
                                <path fill="currentColor"
                                    d="M5.93 3.08h1.128V.974A13.651 13.651 0 0 0 5.416.882c-1.626 0-2.74 1.096-2.74 3.11v1.853H.882v2.353h1.794v5.92h2.2v-5.92h1.721l.274-2.353H4.875v-1.62c0-.68.171-1.146 1.056-1.146Z" />
                            </svg></a></li>
                    <li class="nav-item"><a class="nav-link" target="_blank" href="{{  $shared_config['youtube']->value }}"><svg xmlns="http://www.w3.org/2000/svg" width="17"
                                height="13" fill="none">
                                <path fill="currentColor"
                                    d="M16.409 2.635a2.004 2.004 0 0 0-1.405-1.423c-1.24-.337-6.21-.337-6.21-.337s-4.971 0-6.21.337a2.004 2.004 0 0 0-1.406 1.423C.846 3.891.846 6.511.846 6.511s0 2.62.332 3.876a1.974 1.974 0 0 0 1.405 1.402c1.24.336 6.21.336 6.21.336s4.971 0 6.21-.336a1.974 1.974 0 0 0 1.406-1.402c.332-1.255.332-3.876.332-3.876s0-2.62-.332-3.876ZM7.168 8.89V4.132l4.154 2.38L7.168 8.89Z" />
                            </svg></a></li>
                  
                    <li class="nav-item"><a class="nav-link" target="_blank" href="{{  $shared_config['instagram']->value }}"><svg xmlns="http://www.w3.org/2000/svg" width="15"
                                height="15" fill="none">
                                <path fill="currentColor"
                                    d="M7.504 4.13c-1.88 0-3.395 1.504-3.395 3.367s1.516 3.366 3.395 3.366 3.394-1.503 3.394-3.366c0-1.863-1.515-3.366-3.394-3.366Zm0 5.556a2.202 2.202 0 0 1-2.207-2.189A2.2 2.2 0 0 1 7.504 5.31 2.2 2.2 0 0 1 9.71 7.497a2.202 2.202 0 0 1-2.207 2.189Zm4.325-5.693a.787.787 0 0 1-.792.785.787.787 0 0 1-.792-.785c0-.433.355-.785.792-.785.437 0 .792.352.792.785Zm2.248.797c-.05-1.052-.293-1.983-1.07-2.75-.774-.769-1.713-1.009-2.774-1.061C9.14.917 5.864.917 4.771.979c-1.058.05-1.997.29-2.774 1.057-.777.768-1.016 1.7-1.07 2.751-.062 1.084-.062 4.333 0 5.417.05 1.052.293 1.983 1.07 2.751.777.768 1.713 1.008 2.774 1.06 1.093.062 4.37.062 5.462 0 1.061-.05 2-.29 2.775-1.06.774-.768 1.016-1.7 1.069-2.75.062-1.085.062-4.331 0-5.415Zm-1.412 6.577a2.225 2.225 0 0 1-1.259 1.248c-.871.343-2.94.264-3.902.264-.963 0-3.034.076-3.903-.264a2.225 2.225 0 0 1-1.259-1.248c-.345-.864-.265-2.915-.265-3.87 0-.955-.077-3.009.265-3.87a2.225 2.225 0 0 1 1.259-1.248c.872-.343 2.94-.264 3.903-.264.963 0 3.034-.076 3.902.264.58.228 1.025.67 1.259 1.248.346.864.266 2.915.266 3.87 0 .955.08 3.009-.266 3.87Z" />
                            </svg></a></li>
                </ul>
            </div>
        </div>
    </div><!-- Topbar-->
    <div class="navbar navbar-topbar navbar-expand-xl bg-primary navbar-absolute top-0 d-none d-xl-flex">
        <div class="container">
            <!-- Language switcher-->
            <span class="text-white">
                The IELTS Academy – trung tâm luyện thi IELTS
            </span>
            <!-- 
            <ul class="nav navbar-nav nav-gap-xl nav-contacts nav-no-opacity">
                <li class="nav-item"><a class="nav-link" href="tel:12023580309"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none">
                            <path fill="currentColor" d="M16 11.98v2.408a1.604 1.604 0 0 1-1.094 1.527 1.613 1.613 0 0 1-.66.079 15.941 15.941 0 0 1-6.943-2.465A15.672 15.672 0 0 1 2.476 8.71a15.869 15.869 0 0 1-2.47-6.96A1.603 1.603 0 0 1 .96.136C1.163.047 1.384 0 1.607 0h2.414A1.61 1.61 0 0 1 5.63 1.381c.102.77.29 1.528.563 2.256a1.603 1.603 0 0 1-.362 1.694l-1.022 1.02a12.86 12.86 0 0 0 4.827 4.817l1.022-1.02a1.61 1.61 0 0 1 1.697-.36c.73.271 1.489.46 2.26.561A1.61 1.61 0 0 1 16 11.98Z" />
                        </svg>+1 202-358-0309</a></li>
                <li class="nav-item"><a class="nav-link" href="mailto:help@startbox.com"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="11" fill="none">
                            <path fill="currentColor" d="M14 0H0l7 4.583L14 0Z" />
                            <path fill="currentColor" d="M14 9.821V2L7 6.5 0 2v7.821C0 10.47.63 11 1.4 11h11.2c.77 0 1.4-.53 1.4-1.179Z" />
                        </svg>help@startbox.com</a></li>
                <li class="nav-item"><a class="nav-link" href="#"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="14" fill="none">
                            <path fill="currentColor" fill-rule="evenodd" d="M6 14s6-3.818 6-8.273a5.598 5.598 0 0 0-1.757-4.05A6.148 6.148 0 0 0 6 0a6.148 6.148 0 0 0-4.243 1.677A5.598 5.598 0 0 0 0 5.727C0 10.182 6 14 6 14Zm2-8a2 2 0 1 1-4 0 2 2 0 0 1 4 0Z" clip-rule="evenodd" />
                        </svg>2260 Lady Bug Drive, New York, NY 10011</a></li>
            </ul>-->
            <!-- Socials-->
            <ul class="nav nav-gap-sm navbar-nav nav-social ms-auto nav-no-opacity align-items-center">
                <li class="nav-item "><a class="nav-link text-white" href="#"><svg xmlns="http://www.w3.org/2000/svg"
                            width="7" height="14" fill="#fff">
                            <path fill="currentColor"
                                d="M5.535 2.71h1.053V.748A12.741 12.741 0 0 0 5.055.66c-1.518 0-2.557 1.023-2.557 2.903v1.73H.823v2.195h1.675v5.525h2.053V7.488h1.607l.255-2.195H4.551V3.78c0-.635.159-1.07.984-1.07Z" />
                        </svg></a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#"><svg xmlns="http://www.w3.org/2000/svg"
                            width="16" height="12" fill="#fff">
                            <path fill="currentColor"
                                d="M15.048 2.23A1.87 1.87 0 0 0 13.737.9C12.58.587 7.94.587 7.94.587S3.301.587 2.144.9A1.87 1.87 0 0 0 .832 2.23c-.31 1.172-.31 3.618-.31 3.618s0 2.445.31 3.617c.171.647.674 1.135 1.312 1.308 1.157.314 5.796.314 5.796.314s4.64 0 5.797-.314a1.842 1.842 0 0 0 1.311-1.308c.31-1.172.31-3.617.31-3.617s0-2.446-.31-3.618ZM6.423 8.068v-4.44l3.877 2.22-3.877 2.22Z" />
                        </svg></a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#"><svg xmlns="http://www.w3.org/2000/svg"
                            width="15" height="12" fill="#fff">
                            <path fill="currentColor"
                                d="M12.854 2.986c.009.124.009.248.009.373 0 3.793-2.887 8.163-8.164 8.163a8.108 8.108 0 0 1-4.406-1.288c.23.027.453.036.693.036a5.746 5.746 0 0 0 3.562-1.226 2.874 2.874 0 0 1-2.683-1.99 3.035 3.035 0 0 0 1.297-.053 2.87 2.87 0 0 1-2.3-2.816v-.036a2.89 2.89 0 0 0 1.296.365A2.867 2.867 0 0 1 .88 2.124c0-.533.142-1.022.391-1.448a8.156 8.156 0 0 0 5.916 3.002 3.239 3.239 0 0 1-.07-.657c0-1.581 1.278-2.87 2.869-2.87.826 0 1.572.347 2.096.907a5.65 5.65 0 0 0 1.821-.693 2.862 2.862 0 0 1-1.261 1.581 5.751 5.751 0 0 0 1.652-.444 6.169 6.169 0 0 1-1.44 1.484Z" />
                        </svg></a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#"><svg xmlns="http://www.w3.org/2000/svg"
                            width="14" height="13" fill="#fff">
                            <path fill="currentColor"
                                d="M7.004 3.692c-1.754 0-3.169 1.403-3.169 3.142 0 1.74 1.415 3.142 3.169 3.142 1.753 0 3.168-1.403 3.168-3.142 0-1.739-1.415-3.142-3.168-3.142Zm0 5.185a2.055 2.055 0 0 1-2.06-2.043c0-1.126.924-2.042 2.06-2.042 1.136 0 2.06.916 2.06 2.042a2.055 2.055 0 0 1-2.06 2.043Zm4.036-5.313c0 .407-.33.733-.739.733a.734.734 0 0 1-.739-.733c0-.405.331-.733.74-.733.407 0 .738.328.738.733Zm2.099.744c-.047-.982-.273-1.852-.998-2.568-.723-.716-1.6-.94-2.59-.99-1.02-.057-4.078-.057-5.098 0-.987.047-1.864.27-2.59.987-.724.717-.948 1.586-.997 2.568-.058 1.011-.058 4.044 0 5.056.047.981.273 1.85.998 2.567.725.717 1.6.94 2.589.99 1.02.058 4.078.058 5.098 0 .99-.046 1.867-.27 2.59-.99.722-.716.948-1.586.998-2.567.058-1.012.058-4.042 0-5.053Zm-1.318 6.138a2.077 2.077 0 0 1-1.175 1.165c-.813.32-2.744.246-3.642.246-.9 0-2.832.071-3.643-.246a2.076 2.076 0 0 1-1.175-1.165c-.322-.806-.248-2.72-.248-3.612 0-.891-.071-2.808.248-3.612a2.077 2.077 0 0 1 1.175-1.165c.814-.32 2.744-.246 3.643-.246.898 0 2.831-.071 3.642.246.54.213.957.626 1.175 1.165.322.807.248 2.72.248 3.612 0 .891.074 2.808-.248 3.612Z" />
                        </svg></a></li>
            </ul>
        </div>
    </div><!-- Main-->