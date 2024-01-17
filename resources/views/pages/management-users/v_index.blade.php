@extends('layouts/adminLayoutMaster')

@section('title', 'Master Users')

@section('page-style')
    <!-- Current Page CSS Costum -->

@endsection

@section('content')
    
<!--begin::Toolbar-->
<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
    <!--begin::Toolbar container-->
    <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
        <!--begin::Page title-->
        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
            <!--begin::Title-->
            <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Management Users</h1>
            <!--end::Title-->
            <!--begin::Breadcrumb-->
            <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                <!--begin::Item-->
                <li class="breadcrumb-item text-muted">
                    <a href="index.html" class="text-muted text-hover-primary">Management</a>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-500 w-5px h-2px"></span>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-muted">Users</li>
                <!--end::Item-->
            </ul>
            <!--end::Breadcrumb-->
        </div>
        <!--end::Page title-->
        <!--begin::Actions-->
        <div class="d-flex align-items-center gap-2 gap-lg-3">
            <!--begin::Secondary button-->
            <button type="button" class="btn btn-sm fw-bold btn-secondary" onclick="btnResetFilterData()">
                <span class="indicator-label"><i class="bi bi-arrow-repeat fs-4 me-2"></i> Reset Filter</span>
            </button>
            <!--end::Secondary button-->

            <!--begin::Primary button-->
            <button type="button" class="btn btn-sm fw-bold btn-primary" onclick="btnTambahDataUser()">
                <span class="indicator-label"><i class="bi bi-person-fill-add fs-4 me-2"></i> Tambah User Pengguna</span>
            </button>
            <!--end::Primary button-->
        </div>
        <!--end::Actions-->
    </div>
    <!--end::Toolbar container-->
</div>
<!--end::Toolbar-->

<!--begin::Content-->
<div id="kt_app_content" class="app-content flex-column-fluid">
    <!--begin::Content container-->
    <div id="kt_app_content_container" class="app-container container-fluid">
        
        <div class="card shadow-sm">
            <div class="card-header">
                <div class="d-flex flex-stack w-100">
                    <!--begin::Wrapper-->
                    <div>
                        <!--begin::Title-->
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bold text-dark">Filter Data</span>
                            <span class="text-gray-400 mt-1 fw-semibold fs-6">Master Users Aplikasi</span>
                        </h3>
                        <!--end::Title-->
                    </div>
                    <!--end::Wrapper-->                    
                </div>
            </div>
            <div class="card-body">                           
                <div class="row">
                    <!--begin::Col-->
                    <div class="col-lg-3 mb-2">
                        <!--begin::Label-->
                        <label class="form-label">Filter Username : </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" name="form_filter_username" id="form_filter_username" class="form-control mb-2" placeholder="Filter Username"/>
                        <!--end::Input-->
                    </div>
                    <!--end::Col-->

                    <!--begin::Col-->
                    <div class="col-lg-3 mb-2">
                        <!--begin::Label-->
                        <label class="form-label">Filter Nama : </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" name="form_filter_nama" id="form_filter_nama" class="form-control mb-2" placeholder="Filter Nama"/>
                        <!--end::Input-->
                    </div>
                    <!--end::Col-->

                    <!--begin::Col-->
                    <div class="col-lg-3 mb-2">
                        <!--begin::Label-->
                        <label class="form-label">Filter Role : </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <select class="form-select mb-2" name="form_filter_role" id="form_filter_role"  data-control="select2" data-placeholder="Select an option">
                            <option value="-">-- Pilih Role User -- </option>
                            @foreach ($model['msrole'] as $role)
                                <option value="{{$role->id}}">{{$role->name}}</option>
                            @endforeach                                
                        </select>
                        <!--end::Input-->
                    </div>
                    <!--end::Col-->                       

                    <!--begin::Col-->
                    <div class="col-lg-3 mb-2">
                        <!--begin::Label-->
                        <label class="form-label">Filter Status : </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <select class="form-select mb-2" name="form_filter_status" id="form_filter_status"  data-control="select2" data-placeholder="Select an option">
                            <option value="-">-- Pilih Status -- </option>
                            <option value="1">User Aktif</option>
                            <option value="0">User In-Aktif</option>
                        </select>
                        <!--end::Input-->
                    </div>
                    <!--end::Col-->
                </div>
            </div>
        </div>

        <div class="card shadow-sm mt-5">                
            <div class="card-body">

                <div class="table-responsive">
                    <!--begin::Table-->
                    <table class="table table-striped table-hover align-middle table-row-dashed fs-6 gy-5" id="tabel_master_users">
                        <!--begin::Table head-->
                        <thead>
                            <!--begin::Table row-->
                            <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">                                
                                <th>No.</th>
                                <th class="text-center"> </th>
                                <th>Username</th>
                                <th>Nama User</th>
                                <th>Role User</th>
                                <th>Status</th>
                                <th>Last Login</th>
                                <th>Actions</th>
                            </tr>
                            <!--end::Table row-->
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody class="text-gray-600 fw-bold">
                            
                        </tbody>
                        <!--end::Table body-->
                    </table>
                    <!--end::Table-->
                </div>
                
            </div>
        </div>

    </div>
    <!--end::Content container-->
</div>
<!--end::Content-->


<div class="modal fade" id="modal-data-user" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Data Form User Admin</h5>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <span class="svg-icon svg-icon-2x"></span>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body">
                <form id="form-useradmcsr" class="form d-flex flex-column flex-lg-row" action="#" method="POST" enctype="multipart/form-data" autocomplete="off">
                    
                    <div class="row">                    
                        
                        <div class="col-md-12 card_useradm_profil">
                            <!--begin::Input group-->
                            <div class="input-group mb-2">
                                <!--begin::Label-->
                                <label class="form-label">Role User</label>
                                <!--end::Label-->
                                <!--begin::Select2-->
                                <select class="form-select mb-2" name="form_useradm_role" id="form_useradm_role"  data-control="select2" data-placeholder="Select an option" data-dropdown-parent="#modal-data-user">
                                    <option value="-">-- Pilih Role -- </option>
                                    @foreach ($model['msrole'] as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                <!--end::Select2-->
                            </div>
                            <!--end::Input group-->
                        </div>                        

                        <div class="col-md-12 my-10">
                            <div class="separator separator-dotted separator-content border-success my-2">
                                <img src="{{ asset('images/logo_giftproject_landscape.png') }}" style="max-height: 75px;" class="img-fluid" alt="logo-pssi">
                            </div>
                        </div>

                        <div class="col-md-6 card_useradm_profil">
                            <!--begin::Label-->
                            <label class="form-label">Nama User</label>
                            <!--end::Label-->
    
                            <!--begin::Input group-->
                            <div class="input-group mb-2">
                                <span class="input-group-text" id="basic-addon1" style="padding: 5px;">
                                    <!--begin::Svg Icon | path: icons/duotune/communication/com006.svg-->
                                    <span class="svg-icon svg-icon-3x">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path opacity="0.3" d="M22 12C22 17.5 17.5 22 12 22C6.5 22 2 17.5 2 12C2 6.5 6.5 2 12 2C17.5 2 22 6.5 22 12ZM12 7C10.3 7 9 8.3 9 10C9 11.7 10.3 13 12 13C13.7 13 15 11.7 15 10C15 8.3 13.7 7 12 7Z" fill="black"/>
                                            <path d="M12 22C14.6 22 17 21 18.7 19.4C17.9 16.9 15.2 15 12 15C8.8 15 6.09999 16.9 5.29999 19.4C6.99999 21 9.4 22 12 22Z" fill="black"/>
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                </span>
                                <input type="text" class="form-control" name="form_useradm_nama" id="form_useradm_nama" placeholder="User Admin Nama" aria-label="User Admin Nama" value="" aria-describedby="basic-addon1"/>
                                <input type="hidden" class="form-control" name="form_useradm_code" id="form_useradm_code" value="" aria-describedby="basic-addon1"/>
                                <input type="hidden" class="form-control" name="form_useradm_act" id="form_useradm_act" value="tambah_data" aria-describedby="basic-addon1"/>
                            </div>
                            <!--end::Input group-->
    
                        </div>
    
                        <div class="col-md-6 card_useradm_profil">
                            <!--begin::Label-->
                            <label class="form-label">Email User <small>(Digunakan sebagai username)</small></label>
                            <!--end::Label-->
    
                            <!--begin::Input group-->
                            <div class="input-group mb-2">
                                <span class="input-group-text" id="basic-addon1" style="padding: 5px;">
                                    <!--begin::Svg Icon | path: icons/duotune/communication/com006.svg-->
                                    <span class="svg-icon svg-icon-3x">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M6 8.725C6 8.125 6.4 7.725 7 7.725H14L18 11.725V12.925L22 9.725L12.6 2.225C12.2 1.925 11.7 1.925 11.4 2.225L2 9.725L6 12.925V8.725Z" fill="black"/>
                                            <path opacity="0.3" d="M22 9.72498V20.725C22 21.325 21.6 21.725 21 21.725H3C2.4 21.725 2 21.325 2 20.725V9.72498L11.4 17.225C11.8 17.525 12.3 17.525 12.6 17.225L22 9.72498ZM15 11.725H18L14 7.72498V10.725C14 11.325 14.4 11.725 15 11.725Z" fill="black"/>
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                </span>
                                <input type="email" class="form-control" name="form_useradm_email" id="form_useradm_email" placeholder="User Admin Email" aria-label="User Admin Email" value="" aria-describedby="basic-addon1"/>
                            </div>
                            <!--end::Input group-->
                            
                        </div>
    
                        <div class="col-md-6 card_useradm_password">
                            <!--begin::Label-->
                            <label class="form-label">Password</label>
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
                                <input type="password" class="form-control" name="form_useradm_password" id="form_useradm_password" placeholder="User Admin Password" aria-label="User Admin Password" value="" aria-describedby="basic-addon1"/>
                            </div>
                            <!--end::Input group-->
                            <small>Password 8 Karakter, Mengandung Huruf Besar, Simbol dan Angka</small>
                            
                        </div>
    
                        <div class="col-md-6 card_useradm_password">
                            <!--begin::Label-->
                            <label class="form-label">Re-Password</label>
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
                                <input type="password" class="form-control" name="form_useradm_password_re" id="form_useradm_password_re" placeholder="User Admin Re-Password" aria-label="User Admin Re-Password" value="" aria-describedby="basic-addon1"/>
                            </div>
                            <!--end::Input group-->
    
                            <div id="popover-password">
                                <p class="text-bold" id="re-password-verif"></p>
                            </div>
                            
                        </div>
    
                        <div class="col-12 col-md-12 mb-2 card_useradm_password">
                            <div class="form-group">
                                <div id="popover-password">
                                    <p class="font-weight-bolder fw-bold">Password Strength : <span id="result"> </span></p>
                                    <div id="password-indikator" class="progress mt-5" style="height: 30px;">
                                        <div id="password-strength" class="progress-bar progress-bar-striped progress-bar-animated bg-warning" role="progressbar" style="width: 0%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div> 
                        </div>
    
                        <div class="col-md-6 card_useradm_captcha">
                            <div class="form-group">
                                <strong>ReCaptcha:</strong>
                                <div class="g-recaptcha" data-sitekey="{{ env('GOOGLE_RECAPTCHA_KEY') }}"></div>
                                @if ($errors->has('g-recaptcha-response'))
                                    <span class="text-danger">{{ $errors->first('g-recaptcha-response') }}</span>
                                @endif
                            </div>  
                        </div>
    
                        <div class="col-md-6 card_useradm_btnaction">
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-info mt-2" id="btnTambahDataUser" onclick="act_btnTambahDataUser()">
                                    <span class="indicator-label"><i class="bi bi-person-lines-fill fs-4 me-2"></i> Tambah Data User</span>
                                </button>

                                <button type="button" class="btn btn-info mt-2" id="btnUpdateDataUser" onclick="acttion_UpdateDataUser()">
                                    <span class="indicator-label"><i class="bi bi-person-lines-fill fs-4 me-2"></i> Update Data User</span>
                                </button>
                            </div>
                        </div>
    
                        <div class="col-md-12">
                            <div class="separator separator-dotted separator-content border-success my-2">
                                <i class="bi bi-check-square text-success fs-2"></i>
                            </div>
                        </div>
    
                    </div>

                </form>                
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('page-script')
    <!-- Current Page JS Costum -->
    @if (session()->has('errors'))
    <script>
        Swal.fire({
            title: 'Error Data !',
            text: '{{ $errors->first() }}',
            icon: "warning",
            buttonsStyling: false,
            confirmButtonText: "Ok, got it!",
            customClass: {
                confirmButton: "btn btn-primary"
            }
        });
    </script>
    @endif
    <script src="{{ URL::asset('js/pages/management_users.js?version=') }}{{uniqid()}}"></script>
@endsection