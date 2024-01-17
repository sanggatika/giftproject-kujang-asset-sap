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
        <form class="form w-100" novalidate="novalidate" id="kt_new_password_form" data-kt-redirect-url="#" action="#">
            <!--begin::Heading-->
            <div class="text-center mb-10">
                <!--begin::Title-->
                <h1 class="text-gray-900 fw-bolder mb-3">Setup New Password</h1>
                <!--end::Title-->
                <!--begin::Link-->
                <div class="text-gray-500 fw-semibold fs-6">Have you already reset the password ? 
                <a href="{{url('/auth/login')}}" class="link-primary fw-bold">Sign in</a></div>
                <!--end::Link-->
            </div>
            <!--begin::Heading-->

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
                        <span>Untuk melakukan reset password silahkan isi form dibawah ini. Token hanya dapat digunakan satu kali.</span>
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
                            <span>Token anda invalid, tidak seseuai dengan sistem. Silahkan melakukan pengajuan reset password, dengan menekan tombol dibawah ini.</span>
                            <!--end::Content-->
                        @endif

                        @if ($model['vilid_token']['reason'] == 'token_sudah_digunakan')
                            <!--begin::Content-->
                            <span>Token anda sudah digunakan. Silahkan melakukan pengajuan reset ulang password, dengan menekan tombol dibawah ini.</span>
                            <!--end::Content-->
                        @endif
                        
                        @if ($model['vilid_token']['reason'] == 'token_expired')
                            <!--begin::Content-->
                            <span>Token anda expired atau tidak bisa digunakan. Silahkan melakukan pengajuan reset ulang password, dengan menekan tombol dibawah ini.</span>
                            <!--end::Content-->
                        @endif

                    </div>
                    <!--end::Wrapper-->
                </div>

                <div class="d-grid mb-10">
                    <a href="{{url('/auth/forgot')}}" class="btn btn-warning mt-5"><i class="bi bi-building-lock fs-4 me-2"></i> Reset Password</a>
                </div>
            @endif
            
            @if ($model['vilid_token']['status'] == true)
                <!--begin::Input group-->
                <div class="fv-row mb-3" data-kt-password-meter="true">
                    <!--begin::Label-->
                    <label class="form-label fw-bold">New Password</label>
                    <!--end::Label-->

                    <!--begin::Input group-->
                    <div class="input-group mb-2">
                        <span class="input-group-text" id="basic-addon1" style="padding: 5px;">
                            <!--begin::Svg Icon | path: icons/duotune/communication/com006.svg-->
                            <span class="svg-icon svg-icon-3x">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="black"/>
                                    <path d="M15.8054 11.639C15.6757 11.5093 15.5184 11.4445 15.3331 11.4445H15.111V10.1111C15.111 9.25927 14.8055 8.52784 14.1944 7.91672C13.5833 7.30557 12.8519 7 12 7C11.148 7 10.4165 7.30557 9.80547 7.9167C9.19432 8.52784 8.88885 9.25924 8.88885 10.1111V11.4445H8.66665C8.48153 11.4445 8.32408 11.5093 8.19444 11.639C8.0648 11.7685 8 11.926 8 12.1112V16.1113C8 16.2964 8.06482 16.4539 8.19444 16.5835C8.32408 16.7131 8.48153 16.7779 8.66665 16.7779H15.3333C15.5185 16.7779 15.6759 16.7131 15.8056 16.5835C15.9351 16.4539 16 16.2964 16 16.1113V12.1112C16.0001 11.926 15.9351 11.7686 15.8054 11.639ZM13.7777 11.4445H10.2222V10.1111C10.2222 9.6204 10.3958 9.20138 10.7431 8.85421C11.0903 8.507 11.5093 8.33343 12 8.33343C12.4909 8.33343 12.9097 8.50697 13.257 8.85421C13.6041 9.20135 13.7777 9.6204 13.7777 10.1111V11.4445Z" fill="black"/>
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <input type="password" class="form-control" name="form_useradm_password" id="form_useradm_password" placeholder="User Admin New Password" aria-label="User Admin New Password" value="" aria-describedby="basic-addon1"/>
                    </div>
                    <input type="hidden" placeholder="data_token" name="form_token" id="form_token" value="{{$model['token']}}" autocomplete="off" class="form-control bg-transparent" readonly/>
                    <!--end::Input group-->
                    <small>Password 8 Karakter, Mengandung Huruf Besar, Simbol dan Angka</small>
                </div>
                <!--end::Input group=-->
                
                <!--end::Input group=-->
                <div class="fv-row mb-3">
                    <!--begin::Label-->
                    <label class="form-label fw-bold">Confirm New Password</label>
                    <!--end::Label-->

                    <!--begin::Input group-->
                    <div class="input-group mb-2">
                        <span class="input-group-text" id="basic-addon1" style="padding: 5px;">
                            <!--begin::Svg Icon | path: icons/duotune/communication/com006.svg-->
                            <span class="svg-icon svg-icon-3x">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path opacity="0.3" d="M20.5543 4.37824L12.1798 2.02473C12.0626 1.99176 11.9376 1.99176 11.8203 2.02473L3.44572 4.37824C3.18118 4.45258 3 4.6807 3 4.93945V13.569C3 14.6914 3.48509 15.8404 4.4417 16.984C5.17231 17.8575 6.18314 18.7345 7.446 19.5909C9.56752 21.0295 11.6566 21.912 11.7445 21.9488C11.8258 21.9829 11.9129 22 12.0001 22C12.0872 22 12.1744 21.983 12.2557 21.9488C12.3435 21.912 14.4326 21.0295 16.5541 19.5909C17.8169 18.7345 18.8277 17.8575 19.5584 16.984C20.515 15.8404 21 14.6914 21 13.569V4.93945C21 4.6807 20.8189 4.45258 20.5543 4.37824Z" fill="black"/>
                                    <path d="M10.5606 11.3042L9.57283 10.3018C9.28174 10.0065 8.80522 10.0065 8.51412 10.3018C8.22897 10.5912 8.22897 11.0559 8.51412 11.3452L10.4182 13.2773C10.8099 13.6747 11.451 13.6747 11.8427 13.2773L15.4859 9.58051C15.771 9.29117 15.771 8.82648 15.4859 8.53714C15.1948 8.24176 14.7183 8.24176 14.4272 8.53714L11.7002 11.3042C11.3869 11.6221 10.874 11.6221 10.5606 11.3042Z" fill="black"/>
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <input type="password" class="form-control" name="form_useradm_password_re" id="form_useradm_password_re" placeholder="User Admin Confirm New Password" aria-label="User Admin Confirm New Password" value="" aria-describedby="basic-addon1"/>
                    </div>
                    <!--end::Input group-->

                    <div id="popover-password">
                        <p class="text-bold" id="re-password-verif"></p>
                    </div>
                </div>
                <!--end::Input group=-->

                <!--end::Input group=-->
                <div class="fv-row mb-8">
                    <div class="form-group">
                        <div id="popover-password">
                            <p class="font-weight-bolder fw-bold">Password Strength : <span id="result"> </span></p>
                            <div id="password-indikator" class="progress mt-5" style="height: 30px;">
                                <div id="password-strength" class="progress-bar progress-bar-striped progress-bar-animated bg-warning" role="progressbar" style="width: 0%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div> 
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

                <!--begin::Action-->
                <div class="d-grid mb-10">
                    <button type="button" id="kt_new_password_submit" class="btn btn-primary" onclick="acttion_UpdatePasswordUser()">
                        <!--begin::Indicator label-->
                        <span class="indicator-label">Submit</span>
                        <!--end::Indicator label-->
                        <!--begin::Indicator progress-->
                        <span class="indicator-progress">Please wait... 
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        <!--end::Indicator progress-->
                    </button>
                </div>
                <!--end::Action-->

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
    <script src="{{ URL::asset('js/pages/auth/reset-password.js?version=') }}{{uniqid()}}"></script>
@endsection