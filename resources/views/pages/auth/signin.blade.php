@extends('layouts/authLayoutMaster')

@section('title', ' - Sign In')

@section('page-style')
    <!-- Current Page CSS Costum -->

@endsection

@section('content')
<!--begin::Content-->

<!--begin::Form-->
<div class="d-flex flex-center flex-column flex-lg-row-fluid">
    <!--begin::Wrapper-->
    
    <div class="w-lg-500px w-sm-100 w-100 p-10">
        <!--begin::Form-->
        <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" data-kt-redirect-url="index.html" action="#">
            <!--begin::Heading-->
            <div class="text-center mb-11">
                <!--begin::Title-->
                <h1 class="text-gray-900 fw-bolder mb-3">Sign In</h1>
                <!--end::Title-->
                <!--begin::Subtitle-->
                <div class="text-gray-500 fw-semibold fs-6">Your Social Campaigns</div>
                <!--end::Subtitle=-->
            </div>
            <!--begin::Heading-->
    
            <!--begin::Separator-->
            <div class="separator separator-content my-14">
                <span class="w-125px text-gray-500 fw-semibold fs-7">Or with email</span>
            </div>
            <!--end::Separator-->

            <!--begin::Alert-->
            <div id="card_alert_informasi" style="display:none">
                <div class="alert alert-danger d-flex align-items-center p-2">
                    <!--begin::Icon-->
                    <span class="svg-icon svg-icon-2hx svg-icon-danger me-3">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path opacity="0.3" d="M20.5543 4.37824L12.1798 2.02473C12.0626 1.99176 11.9376 1.99176 11.8203 2.02473L3.44572 4.37824C3.18118 4.45258 3 4.6807 3 4.93945V13.569C3 14.6914 3.48509 15.8404 4.4417 16.984C5.17231 17.8575 6.18314 18.7345 7.446 19.5909C9.56752 21.0295 11.6566 21.912 11.7445 21.9488C11.8258 21.9829 11.9129 22 12.0001 22C12.0872 22 12.1744 21.983 12.2557 21.9488C12.3435 21.912 14.4326 21.0295 16.5541 19.5909C17.8169 18.7345 18.8277 17.8575 19.5584 16.984C20.515 15.8404 21 14.6914 21 13.569V4.93945C21 4.6807 20.8189 4.45258 20.5543 4.37824Z" fill="currentColor"/>
                            <rect x="9" y="13.0283" width="7.3536" height="1.2256" rx="0.6128" transform="rotate(-45 9 13.0283)" fill="currentColor"/>
                            <rect x="9.86664" y="7.93359" width="7.3536" height="1.2256" rx="0.6128" transform="rotate(45 9.86664 7.93359)" fill="currentColor"/>
                        </svg>
                    </span>
                    <!--end::Icon-->
    
                    <!--begin::Wrapper-->
                    <div class="d-flex flex-column">
                        <!--begin::Title-->
                        <h4 class="mb-1 text-dark">This is an alert</h4>
                        <!--end::Title-->
                        <!--begin::Content-->
                        <span id="alert_informasi">The alert component can be used to highlight</span>
                        <!--end::Content-->
                    </div>
                    <!--end::Wrapper-->
                </div>
            </div>            
            <!--end::Alert-->
            
            <!--begin::Input group=-->
            <div class="fv-row mb-8">
                <!--begin::Email-->
                <input type="text" placeholder="Email or Username" name="form_email" id="form_email" autocomplete="off" class="form-control bg-transparent" />
                <!--end::Email-->
            </div>
            <!--end::Input group=-->

            <!--begin::Input group=-->
            <div class="fv-row mb-3">
                <!--begin::Password-->
                <input type="password" placeholder="Password" name="form_password" id="form_password" autocomplete="off"
                    class="form-control bg-transparent" />
                    <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
                        <i class="bi bi-eye-slash fs-2" id="togglePassword"></i>
                    </span>
                <!--end::Password-->
            </div>
            <!--end::Input group=-->

            <!--begin::Wrapper-->
            <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold d-none">
                <div></div>
                <!--begin::Link-->
                <a href="{{url('/auth/forgot')}}" class="link-primary">Forgot Password ?</a>
                <!--end::Link-->
            </div>
            <!--end::Wrapper-->

            <!--begin::Input group=-->
            <div class="fv-row mb-3">
                <div class="form-group">
                    <strong>ReCaptcha:</strong>
                    <div class="g-recaptcha" data-sitekey="{{ env('GOOGLE_RECAPTCHA_KEY') }}"></div>
                    @if ($errors->has('g-recaptcha-response'))
                        <span class="text-danger">{{ $errors->first('g-recaptcha-response') }}</span>
                    @endif
                </div>  
            </div>
            <!--end::Input group=-->

            <!--begin::Submit button-->
            <div class="d-grid mb-5">
                <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
                    <!--begin::Indicator label-->
                    <span class="indicator-label">Sign In</span>
                    <!--end::Indicator label-->
                    <!--begin::Indicator progress-->
                    <span class="indicator-progress">Please wait... 
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    <!--end::Indicator progress-->
                </button>
            </div>

            <div class="d-grid mb-10">
                <a href="{{ url('/') }}" class="btn btn-sm fw-bold btn-success">
                    <i class="bi bi-shop-window fs-4 me-2"></i>
                    Kembali Ke Halaman Beranda
                </a>
            </div>
            <!--end::Submit button-->
            <!--begin::Sign up-->
            {{-- <div class="text-gray-500 text-center fw-semibold fs-6">Not a Member yet? 
            <a href="{{url('/auth/register')}}" class="link-primary">Sign up</a></div> --}}
            <!--end::Sign up-->
        </form>
        <!--end::Form-->
    </div>
    
    <!--end::Wrapper-->
</div>
<!--end::Form-->

<!--end::Content-->
@endsection

@section('page-script')
    <!--begin::Custom Javascript(used for this page only)-->
    {{-- <script src="{{ asset('js/custom/authentication/sign-in/general.js') }}"></script> --}}
    <!--end::Custom Javascript-->

    <!-- Current Page JS Costum -->
    <script src="{{ URL::asset('js/pages/auth/signin.js?version=') }}{{uniqid()}}"></script>
@endsection