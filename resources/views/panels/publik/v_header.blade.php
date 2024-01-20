<!--begin::Header Section-->
<div class="mb-0" id="home">
    <!--begin::Wrapper-->
    <div class="bgi-no-repeat bgi-size-contain bgi-position-x-center bgi-position-y-bottom landing-dark-bg" style="background-image: url({{ asset('media/svg/illustrations/hexagon.svg') }})">
        <!--begin::Header-->
        <div class="landing-header" data-kt-sticky="true" data-kt-sticky-name="landing-header" data-kt-sticky-offset="{default: '200px', lg: '300px'}">
            <!--begin::Container-->
            <div class="container">
                <!--begin::Wrapper-->
                <div class="d-flex align-items-center justify-content-between">
                    <!--begin::Logo-->
                    <div class="d-flex align-items-center flex-equal">
                        <!--begin::Mobile menu toggle-->
                        <button class="btn btn-icon btn-active-color-primary me-3 d-flex d-lg-none" id="kt_landing_menu_toggle">
                            <i class="ki-duotone ki-abstract-14 fs-2hx">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </button>
                        <!--end::Mobile menu toggle-->
                        <!--begin::Logo image-->
                        <a href="{{ url('/') }}">
                            <img alt="Logo" src="{{ asset('images/pupuk-indonesia-putih.png') }}" class="logo-default h-60px h-lg-75px" />
                            <img alt="Logo" src="{{ asset('images/pupuk-indonesia-hitam.png') }}" class="logo-sticky h-60px h-lg-75px" />
                        </a>
                        <!--end::Logo image-->
                    </div>
                    <!--end::Logo-->                    
                    
                    <!--begin::Toolbar-->
                    <div class="flex-equal text-end ms-1">
                        <a href="{{url('/auth/login')}}" class="btn btn-success">
                            Sign In Aplikasi
                        </a>
                    </div>
                    <!--end::Toolbar-->

                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Header-->

        <!--begin::Landing hero-->
        <div class="d-flex flex-column flex-center w-100 min-h-350px min-h-lg-500px px-9">
            <!--begin::Heading-->
            <div class="text-center mb-5 mb-lg-10 py-10 py-lg-20">
                 <!--begin::Title-->
                 <h1 class="text-white lh-base fw-bold fs-2x fs-lg-3x mb-2">
                    <span
                        style="background: linear-gradient(to right, #12CE5D 0%, #FFD80C 100%);-webkit-background-clip: text;-webkit-text-fill-color: transparent;">
                        <span id="kt_landing_hero_text">GIFTPROJECT.ID</span>
                    </span>
                </h1>
                <h1 class="text-white lh-base fw-bold fs-1x fs-lg-2x">
                    APP KUJANG ASSET SAP 
                </h1>

                <img src="{{ asset('images/kujang-asset-beranda.png') }}" class="img-fluid" style="max-height: 350px;" alt="bupati_logo">
                <!--end::Title-->
            </div>
            <!--end::Heading-->            
        </div>
        <!--end::Landing hero-->
    </div>
    <!--end::Wrapper-->
    <!--begin::Curve bottom-->
    <div class="landing-curve landing-dark-color mb-5">
        <svg viewBox="15 12 1470 48" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 11C3.93573 11.3356 7.85984 11.6689 11.7725 12H1488.16C1492.1 11.6689 1496.04 11.3356 1500 11V12H1488.16C913.668 60.3476 586.282 60.6117 11.7725 12H0V11Z" fill="currentColor"></path>
        </svg>
    </div>
    <!--end::Curve bottom-->
</div>
<!--end::Header Section-->