@extends('layouts/authLayoutMaster')

@section('title', '- Reset Password')

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
        <form class="form w-100" novalidate="novalidate" id="kt_password_reset_form" data-kt-redirect-url="#" action="#">
            <!--begin::Heading-->
            <div class="text-center mb-10">
                <!--begin::Title-->
                <h1 class="text-gray-900 fw-bolder mb-3">Forgot Password ?</h1>
                <!--end::Title-->
                <!--begin::Link-->
                <div class="text-gray-500 fw-semibold fs-6">Enter your email to reset your password.</div>
                <!--end::Link-->
            </div>
            <!--begin::Heading-->
            <!--begin::Input group=-->
            <div class="fv-row mb-8">
                <!--begin::Email-->
                <input type="text" placeholder="Email" name="form_email" id="form_email" autocomplete="off" class="form-control bg-transparent" />
                <!--end::Email-->
            </div>
            <!--end::Input group=-->

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

            <!--begin::Actions-->
            <div class="d-flex flex-wrap justify-content-center pb-lg-0">
                <button type="button" id="kt_password_reset_submit" class="btn btn-primary me-4" onclick="btn_submitForgotPassword()">
                    <!--begin::Indicator label-->
                    <span class="indicator-label">Submit</span>
                    <!--end::Indicator label-->
                    <!--begin::Indicator progress-->
                    <span class="indicator-progress">Please wait... 
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    <!--end::Indicator progress-->
                </button>
                <a href="{{url('/auth/login')}}" class="btn btn-light">Cancel</a>
            </div>
            <!--end::Actions-->
        </form>
        <!--end::Form-->
    </div>
    
    <!--end::Wrapper-->
</div>
<!--end::Form-->

<!--end::Content-->
@endsection

@section('page-script')
    <!-- Current Page JS Costum -->
    <script src="{{ URL::asset('js/pages/auth/forgot-password.js?version=') }}{{uniqid()}}"></script>
@endsection