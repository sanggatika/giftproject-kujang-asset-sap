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
        <form class="form w-100 mb-13" novalidate="novalidate" data-kt-redirect-url="index.html" id="kt_sing_in_two_factor_form">
            <!--begin::Icon-->
            <div class="text-center mb-10">
                <img alt="Logo" class="mh-125px" src="{{ asset('media/svg/misc/smartphone-2.svg') }}" />
            </div>
            <!--end::Icon-->
            <!--begin::Heading-->
            <div class="text-center mb-10">
                <!--begin::Title-->
                <h1 class="text-gray-900 mb-3">Two-Factor Verification</h1>
                <!--end::Title-->
                <!--begin::Sub-title-->
                <div class="text-muted fw-semibold fs-5 mb-5">Enter the verification code we sent to</div>
                <!--end::Sub-title-->
                <!--begin::Mobile no-->
                <div class="fw-bold text-gray-900 fs-3">{{ $model['email'] }}</div>
                <!--end::Mobile no-->
            </div>
            <!--end::Heading-->

            @if ($model['vilid_token']['status'] == true)
                <div class="alert alert-info d-flex align-items-center p-2">
                    <!--begin::Icon-->
                    <span class="svg-icon svg-icon-2hx svg-icon-info me-3">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor"/>
                            <rect x="11" y="14" width="7" height="2" rx="1" transform="rotate(-90 11 14)" fill="currentColor"/>
                            <rect x="11" y="17" width="2" height="2" rx="1" transform="rotate(-90 11 17)" fill="currentColor"/>
                        </svg>
                    </span>
                    <!--end::Icon-->

                    <!--begin::Wrapper-->
                    <div class="d-flex flex-column">
                        <!--begin::Title-->
                        <h4 class="mb-1 text-dark">Informasi</h4>
                        <!--end::Title-->
                        <!--begin::Content-->
                        <span>Untuk melakukan verifikasi masukan 6 digit pin yang ada dalam email verifikasi akun, terimakasih.</span>
                        <!--end::Content-->
                    </div>
                    <!--end::Wrapper-->
                </div>
            @endif

            @if ($model['vilid_token']['status'] == false)                
                <div class="alert alert-danger d-flex align-items-center p-2">
                    <!--begin::Icon-->
                    <span class="svg-icon svg-icon-2hx svg-icon-danger me-3">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor"/>
                            <rect x="11" y="14" width="7" height="2" rx="1" transform="rotate(-90 11 14)" fill="currentColor"/>
                            <rect x="11" y="17" width="2" height="2" rx="1" transform="rotate(-90 11 17)" fill="currentColor"/>
                        </svg>
                    </span>
                    <!--end::Icon-->

                    <!--begin::Wrapper-->
                    <div class="d-flex flex-column">
                        <!--begin::Title-->
                        <h4 class="mb-1 text-dark">Informasi</h4>
                        <!--end::Title-->
                        
                        @if ($model['vilid_token']['reason'] == 'token_invalid')
                            <!--begin::Content-->
                            <span>Token anda invalid, tidak seseuai dengan sistem. dengan menekan tombol dibawah ini.</span>
                            <!--end::Content-->
                        @endif

                        @if ($model['vilid_token']['reason'] == 'token_sudah_digunakan')
                            <!--begin::Content-->
                            <span>Token anda sudah digunakan. anda sudah dapat login aplikasi, dengan menekan tombol dibawah ini.</span>
                            <!--end::Content-->
                        @endif
                        
                        @if ($model['vilid_token']['reason'] == 'token_expired')
                            <!--begin::Content-->
                            <span>Token anda expired atau tidak bisa digunakan. dengan menekan tombol dibawah ini.</span>
                            <!--end::Content-->
                        @endif

                    </div>
                    <!--end::Wrapper-->
                </div>

                <div class="d-grid mb-10">
                    <a href="{{url('/auth/login')}}" class="btn btn-info mt-5"><i class="bi bi-building-lock fs-4 me-2"></i> Beck Auth Login</a>
                </div>
            @endif
            
            @if ($model['vilid_token']['status'] == true)
                <!--begin::Section-->
                <div class="mb-10">
                    <!--begin::Label-->
                    <div class="fw-bold text-start text-gray-900 fs-6 mb-1 ms-1">Type your 6 digit security code</div>
                    <!--end::Label-->
                    <!--begin::Input group-->
                    <div class="d-flex flex-wrap flex-stack">
                        <input type="text" name="form_code_1" id="form_code_1" data-inputmask="'mask': '9', 'placeholder': ''" maxlength="1" class="form-control bg-transparent h-35px w-35px h-lg-60px w-lg-60px h-sm-50px w-sm-50px fs-2qx text-center mx-1 my-2" value="" />
                        <input type="text" name="form_code_2" id="form_code_2" data-inputmask="'mask': '9', 'placeholder': ''" maxlength="1" class="form-control bg-transparent h-35px w-35px h-lg-60px w-lg-60px h-sm-50px w-sm-50px fs-2qx text-center mx-1 my-2" value="" />
                        <input type="text" name="form_code_3" id="form_code_3" data-inputmask="'mask': '9', 'placeholder': ''" maxlength="1" class="form-control bg-transparent h-35px w-35px h-lg-60px w-lg-60px h-sm-50px w-sm-50px fs-2qx text-center mx-1 my-2" value="" />
                        <input type="text" name="form_code_4" id="form_code_4" data-inputmask="'mask': '9', 'placeholder': ''" maxlength="1" class="form-control bg-transparent h-35px w-35px h-lg-60px w-lg-60px h-sm-50px w-sm-50px fs-2qx text-center mx-1 my-2" value="" />
                        <input type="text" name="form_code_5" id="form_code_5" data-inputmask="'mask': '9', 'placeholder': ''" maxlength="1" class="form-control bg-transparent h-35px w-35px h-lg-60px w-lg-60px h-sm-50px w-sm-50px fs-2qx text-center mx-1 my-2" value="" />
                        <input type="text" name="form_code_6" id="form_code_6" data-inputmask="'mask': '9', 'placeholder': ''" maxlength="1" class="form-control bg-transparent h-35px w-35px h-lg-60px w-lg-60px h-sm-50px w-sm-50px fs-2qx text-center mx-1 my-2" value="" />
                    </div>
                    <!--begin::Input group-->

                    <input type="hidden" placeholder="data_token" name="form_token" id="form_token" value="{{$model['token']}}" autocomplete="off" class="form-control bg-transparent" readonly/>
                </div>
                <!--end::Section-->

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

                <!--begin::Submit-->
                <div class="d-flex flex-center">
                    <button type="button" id="kt_sing_in_two_factor_submit" class="btn btn-lg btn-primary fw-bold w-100" onclick="acttion_VerifiedUser()">
                        <span class="indicator-label">Verifikasi Akun</span>
                        <span class="indicator-progress">Please wait... 
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                </div>
                <!--end::Submit-->
            @endif

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
    <script src="{{ URL::asset('js/pages/auth/two-factor-verified.js?version=') }}{{uniqid()}}"></script>
@endsection