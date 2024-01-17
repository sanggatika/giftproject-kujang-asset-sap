@extends('layouts/adminLayoutMaster')

@section('title', 'Dashboard Admin')

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
            <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Multipurpose</h1>
            <!--end::Title-->
            <!--begin::Breadcrumb-->
            <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                <!--begin::Item-->
                <li class="breadcrumb-item text-muted">
                    <a href="index.html" class="text-muted text-hover-primary">Home</a>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-500 w-5px h-2px"></span>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-muted">Dashboards</li>
                <!--end::Item-->
            </ul>
            <!--end::Breadcrumb-->
        </div>
        <!--end::Page title-->
        <!--begin::Actions-->
        <div class="d-flex align-items-center gap-2 gap-lg-3">
            <!--begin::Secondary button-->
            <a href="#" class="btn btn-sm fw-bold btn-secondary" data-bs-toggle="modal" data-bs-target="#kt_modal_create_app">Rollover</a>
            <!--end::Secondary button-->
            <!--begin::Primary button-->
            <a href="#" class="btn btn-sm fw-bold btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_new_target">Add Target</a>
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
        <div class="row">
            <div class="col-md-6 mb-2">
                <!--begin::Label-->
                <label class="form-label fw-bold">NIK Atlet Pemain :</label>
                <!--end::Label-->

                <!--begin::Input group-->
                <div class="input-group mb-2">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="bi bi-upc-scan fs-1"></i>
                    </span>
                    <input type="text" class="form-control" name="form_atlet_nik" id="form_atlet_nik" placeholder="NIK Atlet Pemain" aria-label="NIK Atlet Pemain" value="" aria-describedby="basic-addon1"/>
                </div>
                <!--end::Input group-->        
            </div>

            <div class="col-md-6 mb-2">
                <!--begin::Label-->
                <label class="form-label fw-bold">KK Atlet Pemain :</label>
                <!--end::Label-->

                <!--begin::Input group-->
                <div class="input-group mb-2">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="bi bi-clipboard-heart fs-1"></i>
                    </span>
                    <input type="text" class="form-control" name="form_atlet_kk" id="form_atlet_kk" placeholder="KK Atlet Pemain" aria-label="KK Atlet Pemain" value="" aria-describedby="basic-addon1"/>
                </div>
                <!--end::Input group-->        
            </div>

            <div class="col-md-12 mb-2">
                <!--begin::Label-->
                <label class="form-label fw-bold">Nama Pemain :</label>
                <!--end::Label-->

                <!--begin::Input group-->
                <div class="input-group mb-2">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="bi bi-person-bounding-box fs-1"></i>
                    </span>
                    <input type="text" class="form-control" name="form_atlet_nama" id="form_atlet_nama" placeholder="Nama Pemain" aria-label="Nama Pemain" value="" aria-describedby="basic-addon1"/>
                </div>
                <!--end::Input group-->        
            </div>

            <div class="col-md-6 file_wajib_upload">
                <!--begin::Label-->
                <label class="form-label fw-bold">1. Dokumen KTP Atlet : <small>Gambar atau PDF</small></label>
                <!--end::Label-->
                <div class="input-group mb-5">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="bi bi-file-earmark-richtext fs-3"></i>
                    </span>
                    <input type="file" class="form-control"  name="form_club_file_ktp" id="form_club_file_ktp" placeholder="Dokumen KTP Atlet" aria-label="Dokumen KTP Atlet" aria-describedby="basic-addon1" multiple/>
                </div>
            </div>

            <div class="col-md-6 file_wajib_upload">
                <!--begin::Label-->
                <label class="form-label fw-bold">2. Dokumen KK Atlet : <small>Gambar atau PDF</small></label>
                <!--end::Label-->
                <div class="input-group mb-5">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="bi bi-file-earmark-richtext fs-3"></i>
                    </span>
                    <input type="file" class="form-control"  name="form_club_file_kk" id="form_club_file_kk" placeholder="Dokumen KK Atlet" aria-label="Dokumen KK Atlet" aria-describedby="basic-addon1" multiple/>
                </div>
            </div>

            <div class="col-md-12 mt-5">
                <div class="d-flex float-md-end">
                    <button type="button" class="btn btn-primary mt-2 mx-5" id="btnTambahData" onclick="act_submitTambahData()">
                        <span class="indicator-label"><i class="bi bi-person-bounding-box fs-2 me-2"></i> Storage S3</span>
                    </button>

                    <button type="button" class="btn btn-primary mt-2" id="btnTambahData" onclick="act_submitTambahDataLocal()">
                        <span class="indicator-label"><i class="bi bi-person-bounding-box fs-2 me-2"></i> Storage Local</span>
                    </button>
                </div>
            </div>

        </div>
    </div>
    <!--end::Content container-->
</div>
<!--end::Content-->

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
    
    <script src="{{ URL::asset('js/pages/dashboard_harian.js?version=') }}{{uniqid()}}"></script>

@endsection