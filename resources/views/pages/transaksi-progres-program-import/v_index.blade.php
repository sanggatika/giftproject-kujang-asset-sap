@extends('layouts/adminLayoutMaster')

@section('title', '- Transaksi Progres Import')

@section('page-style')
    <!-- Current Page CSS Costum -->
    <style>
        .cardDataCutOff {
          display: none;
        }
    </style>
@endsection

@section('content')

<!--begin::Toolbar-->
<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
    <!--begin::Toolbar container-->
    <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
        <!--begin::Page title-->
        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
            <!--begin::Title-->
            <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Transaksi Progres Import</h1>
            <!--end::Title-->
            <!--begin::Breadcrumb-->
            <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                <!--begin::Item-->
                <li class="breadcrumb-item text-muted">
                    <a href="#" class="text-muted text-hover-primary">Transaksi</a>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-500 w-5px h-2px"></span>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-muted">Progres Import</li>
                <!--end::Item-->
            </ul>
            <!--end::Breadcrumb-->
        </div>
        <!--end::Page title-->
        <!--begin::Actions-->
        <div class="d-flex align-items-center gap-2 gap-lg-3">
            <!--begin::Secondary button-->
            <button type="button" class="btn btn-sm fw-bold btn-secondary" onclick="act_resetFilter()">
                <i class="bi bi-arrow-counterclockwise fs-4 me-2"></i>
                Reset Filter
            </button>
            <!--end::Secondary button-->

            <!--begin::Primary button-->
            <button type="button" class="btn btn-sm fw-bold btn-success" onclick="btn_importProgresProgram()">
                <i class="bi bi-file-earmark-diff fs-4 me-2"></i>
                Import Progres Program
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
        <div class="row">
            <div class="col-12 col-lg-3 col-md-3">
                <!--begin::Label-->
                <label class="form-label fw-bold">Program / Fund Number : </label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" name="form_filter_program" id="form_filter_program" class="form-control mb-2" placeholder="Nama Program / Fund Number"/>
                <!--end::Input-->
            </div>
            <div class="col-12 col-lg-3 col-md-3">
                <!--begin::Label-->
                <label class="form-label fw-bold">Program Account : </label>
                <!--end::Label-->
                <!--begin::Input-->
                <select class="form-select mb-2" name="form_filter_program_account" id="form_filter_program_account"  data-control="select2" data-placeholder="Select an option">
                    <option value="-">-- Program GL Account -- </option> 
                    @foreach ($model['ms_program_account'] as $program_account)
                        <option value="{{$program_account->uuid}}">{{$program_account->name}}</option>
                    @endforeach                             
                </select>
                <!--end::Input-->
            </div>
            <div class="col-12 col-lg-3 col-md-3">
                <!--begin::Label-->
                <label class="form-label fw-bold">Program Departement CCK : </label>
                <!--end::Label-->
                <!--begin::Input-->
                <select class="form-select mb-2" name="form_filter_program_departement" id="form_filter_program_departement"  data-control="select2" data-placeholder="Select an option">
                    <option value="-">-- Program Departement CCK -- </option> 
                    @foreach ($model['ms_program_departement_cck'] as $program_departement_cck)
                        <option value="{{$program_departement_cck->uuid}}">{{$program_departement_cck->name}}</option>
                    @endforeach                             
                </select>
                <!--end::Input-->
            </div>
            <div class="col-12 col-lg-3 col-md-3">
                <!--begin::Label-->
                <label class="form-label fw-bold">Program Bagian CC : </label>
                <!--end::Label-->
                <!--begin::Input-->
                <select class="form-select mb-2" name="form_filter_program_bagian" id="form_filter_program_bagian"  data-control="select2" data-placeholder="Select an option">
                    <option value="-">-- Program Bagian CC -- </option> 
                    @foreach ($model['ms_program_bagian_cc'] as $program_bagian_cc)
                        <option value="{{$program_bagian_cc->uuid}}">{{$program_bagian_cc->name}}</option>
                    @endforeach                             
                </select>
                <!--end::Input-->
            </div>
            <div class="col-12 col-lg-3 col-md-3">
                <!--begin::Label-->
                <label class="form-label fw-bold">Kriteria Program : </label>
                <!--end::Label-->
                <!--begin::Input-->
                <select class="form-select mb-2" name="form_filter_program_kriteria" id="form_filter_program_kriteria"  data-control="select2" data-placeholder="Select an option">
                    <option value="-">-- Kriteria Program -- </option>
                    <option value="Singleyear">SINGLE YEAR</option>
                    <option value="Multiyears 24-25">MULTI YEAR 2024 - 2025</option>                      
                </select>
                <!--end::Input-->
            </div>
            <div class="col-12 col-lg-3 col-md-3">
                <!--begin::Label-->
                <label class="form-label fw-bold">Direktorat : </label>
                <!--end::Label-->
                <!--begin::Input-->
                <select class="form-select mb-2" name="form_filter_program_direktorat" id="form_filter_program_direktorat"  data-control="select2" data-placeholder="Select an option">
                    <option value="-">-- Direktorat -- </option>
                    <option value="PRODUKSI">PRODUKSI</option>
                    <option value="TEKBANG">TEKBANG</option>                      
                </select>
                <!--end::Input-->
            </div>
            <div class="col-12 col-lg-3 col-md-3">
                <!--begin::Label-->
                <label class="form-label fw-bold">Status Progres : </label>
                <!--end::Label-->
                <!--begin::Input-->
                <select class="form-select mb-2" name="form_filter_program_statusprogres" id="form_filter_program_statusprogres"  data-control="select2" data-placeholder="Select an option">
                    <option value="-">-- Status Progres -- </option>
                    <option value="USER">USER</option>
                    <option value="MIR">MIR</option>
                    <option value="SR">SR</option>
                    <option value="PR">PR</option>
                    <option value="GR">GR</option>                      
                </select>
                <!--end::Input-->
            </div>
            <div class="col-12 col-lg-3 col-md-3">
                <!--begin::Label-->
                <label class="form-label fw-bold">Priority Program : </label>
                <!--end::Label-->
                <!--begin::Input-->
                <select class="form-select mb-2" name="form_filter_program_priority" id="form_filter_program_priority"  data-control="select2" data-placeholder="Select an option">
                    <option value="-">-- Priority Program -- </option>
                    <option value="high">High Priority</option>
                    <option value="medium">Medium Priority</option>
                    <option value="low">Low High Priority</option>                          
                </select>
                <!--end::Input-->
            </div>            

            <!--begin::Col-->
            <div class="col-lg-3 mb-2">
                <div class="mb-5">
                    <div class="d-flex flex-stack">
                        <div class="fw-bolder fs-4">Total Program
                            <span class="fs-6 text-gray-400 ms-2"></span>
                        </div>
                        <!--begin::Menu-->
                        <div>
                            <button type="button"
                                class="btn btn-sm btn-icon btn-color-light-dark btn-active-light-primary"
                                data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                <!--begin::Svg Icon | path: icons/duotune/general/gen024.svg-->
                                <span class="svg-icon svg-icon-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px"
                                        viewBox="0 0 24 24">
                                        <g stroke="none" stroke-width="1" fill="none"
                                            fill-rule="evenodd">
                                            <rect x="5" y="5" width="5"
                                                height="5" rx="1" fill="#000000"></rect>
                                            <rect x="14" y="5" width="5"
                                                height="5" rx="1" fill="#000000" opacity="0.3">
                                            </rect>
                                            <rect x="5" y="14" width="5"
                                                height="5" rx="1" fill="#000000" opacity="0.3">
                                            </rect>
                                            <rect x="14" y="14" width="5"
                                                height="5" rx="1" fill="#000000" opacity="0.3">
                                            </rect>
                                        </g>
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </button>
                        </div>
                        <!--end::Menu-->
                    </div>
                    <div class="h-3px w-100 bg-warning"></div>
                </div>

                <div class="card bg-light-warning shadow-sm card-xl-stretch">
                    <div class="card-body p-5">                            
                        <div class="d-flex justify-content-between mt-1">
                            <div class="sales-info d-flex align-items-center">
                                <i class="bi bi-stickies fs-1 me-2 text-primary"></i>
                                <div class="sales-info-content">
                                    <h6 class="mb-0">Program</h6>
                                </div>
                            </div>
                            <h5 class="mb-0 fw-bold" id="data_line2_program_total">0</h5>
                        </div>
                    </div>
                </div>

            </div>
            <!--end::Col-->

            <!--begin::Col-->
            <div class="col-lg-3 mb-2">
                <div class="mb-5">
                    <div class="d-flex flex-stack">
                        <div class="fw-bolder fs-4">Total Program Filter
                            <span class="fs-6 text-gray-400 ms-2"></span>
                        </div>
                        <!--begin::Menu-->
                        <div>
                            <button type="button"
                                class="btn btn-sm btn-icon btn-color-light-dark btn-active-light-primary"
                                data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                <!--begin::Svg Icon | path: icons/duotune/general/gen024.svg-->
                                <span class="svg-icon svg-icon-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px"
                                        viewBox="0 0 24 24">
                                        <g stroke="none" stroke-width="1" fill="none"
                                            fill-rule="evenodd">
                                            <rect x="5" y="5" width="5"
                                                height="5" rx="1" fill="#000000"></rect>
                                            <rect x="14" y="5" width="5"
                                                height="5" rx="1" fill="#000000" opacity="0.3">
                                            </rect>
                                            <rect x="5" y="14" width="5"
                                                height="5" rx="1" fill="#000000" opacity="0.3">
                                            </rect>
                                            <rect x="14" y="14" width="5"
                                                height="5" rx="1" fill="#000000" opacity="0.3">
                                            </rect>
                                        </g>
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </button>
                        </div>
                        <!--end::Menu-->
                    </div>
                    <div class="h-3px w-100 bg-warning"></div>
                </div>

                <div class="card bg-light-warning shadow-sm card-xl-stretch">
                    <div class="card-body p-5">                            
                        <div class="d-flex justify-content-between mt-1">
                            <div class="sales-info d-flex align-items-center">
                                <i class="bi bi-filter-circle fs-1 me-2 text-primary"></i>
                                <div class="sales-info-content">
                                    <h6 class="mb-0">Program</h6>
                                </div>
                            </div>
                            <h5 class="mb-0 fw-bold" id="data_line2_program_total_filter">0</h5>
                        </div>
                    </div>
                </div>

            </div>
            <!--end::Col-->

            <!--begin::Col-->
            <div class="col-lg-3 mb-2">
                <div class="mb-5">
                    <div class="d-flex flex-stack">
                        <div class="fw-bolder fs-4">Single Year
                            <span class="fs-6 text-gray-400 ms-2"></span>
                        </div>
                        <!--begin::Menu-->
                        <div>
                            <button type="button"
                                class="btn btn-sm btn-icon btn-color-light-dark btn-active-light-primary"
                                data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                <!--begin::Svg Icon | path: icons/duotune/general/gen024.svg-->
                                <span class="svg-icon svg-icon-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px"
                                        viewBox="0 0 24 24">
                                        <g stroke="none" stroke-width="1" fill="none"
                                            fill-rule="evenodd">
                                            <rect x="5" y="5" width="5"
                                                height="5" rx="1" fill="#000000"></rect>
                                            <rect x="14" y="5" width="5"
                                                height="5" rx="1" fill="#000000" opacity="0.3">
                                            </rect>
                                            <rect x="5" y="14" width="5"
                                                height="5" rx="1" fill="#000000" opacity="0.3">
                                            </rect>
                                            <rect x="14" y="14" width="5"
                                                height="5" rx="1" fill="#000000" opacity="0.3">
                                            </rect>
                                        </g>
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </button>
                        </div>
                        <!--end::Menu-->
                    </div>
                    <div class="h-3px w-100 bg-warning"></div>
                </div>

                <div class="card bg-light-warning shadow-sm card-xl-stretch">
                    <div class="card-body p-5">                            
                        <div class="d-flex justify-content-between mt-1">
                            <div class="sales-info d-flex align-items-center">
                                <i class="bi bi-layers-half fs-1 me-2 text-primary"></i>
                                <div class="sales-info-content">
                                    <h6 class="mb-0">Single Year</h6>
                                </div>
                            </div>
                            <h6 class="mb-0" id="data_line2_program_single_year">0</h6>
                        </div>
                    </div>
                </div>

            </div>
            <!--end::Col-->

            <!--begin::Col-->
            <div class="col-lg-3 mb-2">
                <div class="mb-5">
                    <div class="d-flex flex-stack">
                        <div class="fw-bolder fs-4">Multi Years
                            <span class="fs-6 text-gray-400 ms-2"></span>
                        </div>
                        <!--begin::Menu-->
                        <div>
                            <button type="button"
                                class="btn btn-sm btn-icon btn-color-light-dark btn-active-light-primary"
                                data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                <!--begin::Svg Icon | path: icons/duotune/general/gen024.svg-->
                                <span class="svg-icon svg-icon-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px"
                                        viewBox="0 0 24 24">
                                        <g stroke="none" stroke-width="1" fill="none"
                                            fill-rule="evenodd">
                                            <rect x="5" y="5" width="5"
                                                height="5" rx="1" fill="#000000"></rect>
                                            <rect x="14" y="5" width="5"
                                                height="5" rx="1" fill="#000000" opacity="0.3">
                                            </rect>
                                            <rect x="5" y="14" width="5"
                                                height="5" rx="1" fill="#000000" opacity="0.3">
                                            </rect>
                                            <rect x="14" y="14" width="5"
                                                height="5" rx="1" fill="#000000" opacity="0.3">
                                            </rect>
                                        </g>
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </button>
                        </div>
                        <!--end::Menu-->
                    </div>
                    <div class="h-3px w-100 bg-warning"></div>
                </div>

                <div class="card bg-light-warning shadow-sm card-xl-stretch">
                    <div class="card-body p-5">                            
                        <div class="d-flex justify-content-between mt-1">
                            <div class="sales-info d-flex align-items-center">
                                <i class="bi bi-layers fs-1 me-2 text-primary"></i>
                                <div class="sales-info-content">
                                    <h6 class="mb-0">Multi Years</h6>
                                </div>
                            </div>
                            <h6 class="mb-0" id="data_line2_program_multi_year">0</h6>
                        </div>
                    </div>
                </div>

            </div>
            <!--end::Col-->

            <!--begin::Col-->
            <div class="col-12 cardDataCutOff">
                <div class="notice d-flex bg-light-danger rounded border-danger border border-dashed mt-2 p-2">
                    <!--begin::Icon-->
                    <!--begin::Svg Icon | path: icons/duotune/general/gen044.svg-->
                    <span class="svg-icon svg-icon-2tx svg-icon-warning me-4">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor"></rect>
                            <rect x="11" y="14" width="7" height="2" rx="1" transform="rotate(-90 11 14)" fill="currentColor"></rect>
                            <rect x="11" y="17" width="2" height="2" rx="1" transform="rotate(-90 11 17)" fill="currentColor"></rect>
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                    <!--end::Icon-->
                    <!--begin::Wrapper-->
                    <div class="d-flex flex-stack flex-grow-1">
                        <!--begin::Content-->
                        <div class="fw-semibold">
                            {{-- @php
                                dd($model['MsMenu']);
                            @endphp --}}
                            <h4 class="text-gray-900 fw-bold">Informasi - Data Belum Cut Off</h4>
                            <div class="fs-6 text-gray-700">Data update import belum dilakukan cut off, periksa kembali data sebelum melakukan cut off data. Dahsboard tidak akan berubah ketika data update belum di cut off</div>
                        </div>
                        <!--end::Content-->
                    </div>
                    <!--end::Wrapper-->

                    <div class="text-end">
                        <button type="button" class="btn btn-sm fw-bold btn-info" onclick="btn_cutoffProgresProgram()">
                            <i class="bi bi-alarm fs-4 me-2"></i>
                            Data Cut Off
                        </button>
                    </div>

                </div>
            </div>
            <!--end::Col-->

            <!--begin::Col-->
            <div class="col-12">
                <div class="card shadow-sm mt-5">                
                    <div class="card-body">                        
                        <div class="table-responsive">
                            <!--begin::Table-->
                            <table class="table table-striped table-hover table-bordered border-primary align-middle table-row-dashed fs-7" id="tabel_master_data_program_jenis">
                                <!--begin::Table head-->
                                <thead class="bg-light-info">
                                    <!--begin::Table row-->
                                    <tr class="text-center text-dark fw-bolder fs-7 text-uppercase gs-0">                                
                                        <th rowspan="2" class="align-middle">NO.</th>
                                        <th colspan="3">PROGRAM</th>
                                        <th colspan="2">USER</th>
                                        <th colspan="2">MIR</th>
                                        <th colspan="2">SR</th>
                                        <th colspan="2">PR</th>
                                        <th colspan="2">PO</th>
                                        <th colspan="2">REALISASI</th>
                                    </tr>
                                    <tr class="text-center text-dark fw-bolder fs-7 text-uppercase gs-0">   
                                        <th>GL ACCOUNT</th>
                                        <th>JML</th>
                                        <th>NILAI</th>
                                        <th>JML</th>
                                        <th>NILAI</th>
                                        <th>JML</th>
                                        <th>NILAI</th>
                                        <th>JML</th>
                                        <th>NILAI</th>
                                        <th>JML</th>
                                        <th>NILAI</th>
                                        <th>JML</th>
                                        <th>NILAI</th>
                                        <th>JML</th>
                                        <th>NILAI</th>
                                    </tr>
                                    <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody class="text-gray-600 fw-bold">
                                    <tr>
                                        <td class="text-center">
                                            <div class="position-relative py-2">
                                                <div class="position-absolute start-0 top-0 w-4px h-100 rounded-2 bg-success"></div>&nbsp;
                                                <a href="#" class="mb-1 text-dark text-hover-primary fw-bolder">1</a>
                                            </div>
                                        </td>
                                        <td class="text-start">
                                            PABRIK
                                        </td>
                                        <td class="text-center" id="data_account_pabrik_program_jml">
                                            0
                                        </td>
                                        <td class="text-end" id="data_account_pabrik_program_nilai">
                                            0
                                        </td>
                                        <td class="text-center" id="data_account_pabrik_user_jml">
                                            0
                                        </td>
                                        <td class="text-end" id="data_account_pabrik_user_nilai">
                                            0
                                        </td>
                                        <td class="text-center" id="data_account_pabrik_mir_jml">
                                            0
                                        </td>
                                        <td class="text-end" id="data_account_pabrik_mir_nilai">
                                            0
                                        </td>
                                        <td class="text-center" id="data_account_pabrik_sr_jml">
                                            0
                                        </td>
                                        <td class="text-end" id="data_account_pabrik_sr_nilai">
                                            0
                                        </td>
                                        <td class="text-center" id="data_account_pabrik_pr_jml">
                                            0
                                        </td>
                                        <td class="text-end" id="data_account_pabrik_pr_nilai">
                                            0
                                        </td>
                                        <td class="text-center" id="data_account_pabrik_po_jml">
                                            0
                                        </td>
                                        <td class="text-end" id="data_account_pabrik_po_nilai">
                                            0
                                        </td>
                                        <td class="text-center" id="data_account_pabrik_gr_jml">
                                            0
                                        </td>
                                        <td class="text-end" id="data_account_pabrik_gr_nilai">
                                            0
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <div class="position-relative py-2">
                                                <div class="position-absolute start-0 top-0 w-4px h-100 rounded-2 bg-success"></div>&nbsp;
                                                <a href="#" class="mb-1 text-dark text-hover-primary fw-bolder">2</a>
                                            </div>
                                        </td>
                                        <td class="text-start">
                                            A2B
                                        </td>
                                        <td class="text-center" id="data_account_a2b_program_jml">
                                            0
                                        </td>
                                        <td class="text-end" id="data_account_a2b_program_nilai">
                                            0
                                        </td>
                                        <td class="text-center" id="data_account_a2b_user_jml">
                                            0
                                        </td>
                                        <td class="text-end" id="data_account_a2b_user_nilai">
                                            0
                                        </td>
                                        <td class="text-center" id="data_account_a2b_mir_jml">
                                            0
                                        </td>
                                        <td class="text-end" id="data_account_a2b_mir_nilai">
                                            0
                                        </td>
                                        <td class="text-center" id="data_account_a2b_sr_jml">
                                            0
                                        </td>
                                        <td class="text-end" id="data_account_a2b_sr_nilai">
                                            0
                                        </td>
                                        <td class="text-center" id="data_account_a2b_pr_jml">
                                            0
                                        </td>
                                        <td class="text-end" id="data_account_a2b_pr_nilai">
                                            0
                                        </td>
                                        <td class="text-center" id="data_account_a2b_po_jml">
                                            0
                                        </td>
                                        <td class="text-end" id="data_account_a2b_po_nilai">
                                            0
                                        </td>
                                        <td class="text-center" id="data_account_a2b_gr_jml">
                                            0
                                        </td>
                                        <td class="text-end" id="data_account_a2b_gr_nilai">
                                            0
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <div class="position-relative py-2">
                                                <div class="position-absolute start-0 top-0 w-4px h-100 rounded-2 bg-success"></div>&nbsp;
                                                <a href="#" class="mb-1 text-dark text-hover-primary fw-bolder">3</a>
                                            </div>
                                        </td>
                                        <td class="text-start">
                                            PERALATAN
                                        </td>
                                        <td class="text-center" id="data_account_peralatan_program_jml">
                                            0
                                        </td>
                                        <td class="text-end" id="data_account_peralatan_program_nilai">
                                            0
                                        </td>
                                        <td class="text-center" id="data_account_peralatan_user_jml">
                                            0
                                        </td>
                                        <td class="text-end" id="data_account_peralatan_user_nilai">
                                            0
                                        </td>
                                        <td class="text-center" id="data_account_peralatan_mir_jml">
                                            0
                                        </td>
                                        <td class="text-end" id="data_account_peralatan_mir_nilai">
                                            0
                                        </td>
                                        <td class="text-center" id="data_account_peralatan_sr_jml">
                                            0
                                        </td>
                                        <td class="text-end" id="data_account_peralatan_sr_nilai">
                                            0
                                        </td>
                                        <td class="text-center" id="data_account_peralatan_pr_jml">
                                            0
                                        </td>
                                        <td class="text-end" id="data_account_peralatan_pr_nilai">
                                            0
                                        </td>
                                        <td class="text-center" id="data_account_peralatan_po_jml">
                                            0
                                        </td>
                                        <td class="text-end" id="data_account_peralatan_po_nilai">
                                            0
                                        </td>
                                        <td class="text-center" id="data_account_peralatan_gr_jml">
                                            0
                                        </td>
                                        <td class="text-end" id="data_account_peralatan_gr_nilai">
                                            0
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <div class="position-relative py-2">
                                                <div class="position-absolute start-0 top-0 w-4px h-100 rounded-2 bg-success"></div>&nbsp;
                                                <a href="#" class="mb-1 text-dark text-hover-primary fw-bolder">4</a>
                                            </div>
                                        </td>
                                        <td class="text-start">
                                            BANGUNAN
                                        </td>
                                        <td class="text-center" id="data_account_bangunan_program_jml">
                                            0
                                        </td>
                                        <td class="text-end" id="data_account_bangunan_program_nilai">
                                            0
                                        </td>
                                        <td class="text-center" id="data_account_bangunan_user_jml">
                                            0
                                        </td>
                                        <td class="text-end" id="data_account_bangunan_user_nilai">
                                            0
                                        </td>
                                        <td class="text-center" id="data_account_bangunan_mir_jml">
                                            0
                                        </td>
                                        <td class="text-end" id="data_account_bangunan_mir_nilai">
                                            0
                                        </td>
                                        <td class="text-center" id="data_account_bangunan_sr_jml">
                                            0
                                        </td>
                                        <td class="text-end" id="data_account_bangunan_sr_nilai">
                                            0
                                        </td>
                                        <td class="text-center" id="data_account_bangunan_pr_jml">
                                            0
                                        </td>
                                        <td class="text-end" id="data_account_bangunan_pr_nilai">
                                            0
                                        </td>
                                        <td class="text-center" id="data_account_bangunan_po_jml">
                                            0
                                        </td>
                                        <td class="text-end" id="data_account_bangunan_po_nilai">
                                            0
                                        </td>
                                        <td class="text-center" id="data_account_bangunan_gr_jml">
                                            0
                                        </td>
                                        <td class="text-end" id="data_account_bangunan_gr_nilai">
                                            0
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <div class="position-relative py-2">
                                                <div class="position-absolute start-0 top-0 w-4px h-100 rounded-2 bg-success"></div>&nbsp;
                                                <a href="#" class="mb-1 text-dark text-hover-primary fw-bolder">5</a>
                                            </div>
                                        </td>
                                        <td class="text-start">
                                            ASET T'BWJD
                                        </td>
                                        <td class="text-center" id="data_account_asettbwjd_program_jml">
                                            0
                                        </td>
                                        <td class="text-end" id="data_account_asettbwjd_program_nilai">
                                            0
                                        </td>
                                        <td class="text-center" id="data_account_asettbwjd_user_jml">
                                            0
                                        </td>
                                        <td class="text-end" id="data_account_asettbwjd_user_nilai">
                                            0
                                        </td>
                                        <td class="text-center" id="data_account_asettbwjd_mir_jml">
                                            0
                                        </td>
                                        <td class="text-end" id="data_account_asettbwjd_mir_nilai">
                                            0
                                        </td>
                                        <td class="text-center" id="data_account_asettbwjd_sr_jml">
                                            0
                                        </td>
                                        <td class="text-end" id="data_account_asettbwjd_sr_nilai">
                                            0
                                        </td>
                                        <td class="text-center" id="data_account_asettbwjd_pr_jml">
                                            0
                                        </td>
                                        <td class="text-end" id="data_account_asettbwjd_pr_nilai">
                                            0
                                        </td>
                                        <td class="text-center" id="data_account_asettbwjd_po_jml">
                                            0
                                        </td>
                                        <td class="text-end" id="data_account_asettbwjd_po_nilai">
                                            0
                                        </td>
                                        <td class="text-center" id="data_account_asettbwjd_gr_jml">
                                            0
                                        </td>
                                        <td class="text-end" id="data_account_asettbwjd_gr_nilai">
                                            0
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <div class="position-relative py-2">
                                                <div class="position-absolute start-0 top-0 w-4px h-100 rounded-2 bg-success"></div>&nbsp;
                                                <a href="#" class="mb-1 text-dark text-hover-primary fw-bolder">6</a>
                                            </div>
                                        </td>
                                        <td class="text-start">
                                            SCP
                                        </td>
                                        <td class="text-center" id="data_account_scp_program_jml">
                                            0
                                        </td>
                                        <td class="text-end" id="data_account_scp_program_nilai">
                                            0
                                        </td>
                                        <td class="text-center" id="data_account_scp_user_jml">
                                            0
                                        </td>
                                        <td class="text-end" id="data_account_scp_user_nilai">
                                            0
                                        </td>
                                        <td class="text-center" id="data_account_scp_mir_jml">
                                            0
                                        </td>
                                        <td class="text-end" id="data_account_scp_mir_nilai">
                                            0
                                        </td>
                                        <td class="text-center" id="data_account_scp_sr_jml">
                                            0
                                        </td>
                                        <td class="text-end" id="data_account_scp_sr_nilai">
                                            0
                                        </td>
                                        <td class="text-center" id="data_account_scp_pr_jml">
                                            0
                                        </td>
                                        <td class="text-end" id="data_account_scp_pr_nilai">
                                            0
                                        </td>
                                        <td class="text-center" id="data_account_scp_po_jml">
                                            0
                                        </td>
                                        <td class="text-end" id="data_account_scp_po_nilai">
                                            0
                                        </td>
                                        <td class="text-center" id="data_account_scp_gr_jml">
                                            0
                                        </td>
                                        <td class="text-end" id="data_account_scp_gr_nilai">
                                            0
                                        </td>
                                    </tr>
                                </tbody>
                                <!--end::Table body-->
                                <tfoot class="text-gray-600 fw-bold bg-light-info">
                                    <tr>
                                        <td class="text-center" colspan="2">
                                            <div class="position-relative py-2">
                                                <div class="position-absolute start-0 top-0 w-4px h-100 rounded-2 bg-success"></div>&nbsp;
                                                <a href="#" class="mb-1 text-dark text-hover-primary fw-bolder">Total</a>
                                            </div>
                                        </td>
                                        <td class="text-center" id="data_account_program_jml">
                                            0
                                        </td>
                                        <td class="text-end" id="data_account_program_nilai">
                                            0
                                        </td>
                                        <td class="text-center" id="data_account_program_jml_user">
                                            0
                                        </td>
                                        <td class="text-end" id="data_account_program_nilai_user">
                                            0
                                        </td>
                                        <td class="text-center" id="data_account_program_jml_mir">
                                            0
                                        </td>
                                        <td class="text-end" id="data_account_program_nilai_mir">
                                            0
                                        </td>
                                        <td class="text-center" id="data_account_program_jml_sr">
                                            0
                                        </td>
                                        <td class="text-end" id="data_account_program_nilai_sr">
                                            0
                                        </td>
                                        <td class="text-center" id="data_account_program_jml_pr">
                                            0
                                        </td>
                                        <td class="text-end" id="data_account_program_nilai_pr">
                                            0
                                        </td>
                                        <td class="text-center" id="data_account_program_jml_po">
                                            0
                                        </td>
                                        <td class="text-end" id="data_account_program_nilai_po">
                                            0
                                        </td>
                                        <td class="text-center" id="data_account_program_jml_gr">
                                            0
                                        </td>
                                        <td class="text-end" id="data_account_program_nilai_gr">
                                            0
                                        </td>
                                    </tr>
                                    <tr class="fs-8">
                                        <td class="text-center" colspan="2">
                                            <a href="#" class="mb-1 text-dark text-hover-primary fw-bolder">Persentase</a>
                                        </td>
                                        <td class="text-center" id="data_account_program_persentase_jml">
                                            0
                                        </td>
                                        <td class="text-end" id="data_account_program_persentase_nilai">
                                            0
                                        </td>
                                        <td class="text-center" id="data_account_program_persentase_jml_user">
                                            0
                                        </td>
                                        <td class="text-end" id="data_account_program_persentase_nilai_user">
                                            0
                                        </td>
                                        <td class="text-center" id="data_account_program_persentase_jml_mir">
                                            0
                                        </td>
                                        <td class="text-end" id="data_account_program_persentase_nilai_mir">
                                            0
                                        </td>
                                        <td class="text-center" id="data_account_program_persentase_jml_sr">
                                            0
                                        </td>
                                        <td class="text-end" id="data_account_program_persentase_nilai_sr">
                                            0
                                        </td>
                                        <td class="text-center" id="data_account_program_persentase_jml_pr">
                                            0
                                        </td>
                                        <td class="text-end" id="data_account_program_persentase_nilai_pr">
                                            0
                                        </td>
                                        <td class="text-center" id="data_account_program_persentase_jml_po">
                                            0
                                        </td>
                                        <td class="text-end" id="data_account_program_persentase_nilai_po">
                                            0
                                        </td>
                                        <td class="text-center" id="data_account_program_persentase_jml_gr">
                                            0
                                        </td>
                                        <td class="text-end" id="data_account_program_persentase_nilai_gr">
                                            0
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                            <!--end::Table-->
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Col-->            

            <!--begin::Col-->
            <div class="col-12">
                <div class="card shadow-sm mt-5">                
                    <div class="card-body">
                        <div class="table-responsive">
                            <!--begin::Table-->
                            <table class="table table-striped table-hover align-middle table-row-dashed fs-6 gy-5" id="tabel_master_data">
                                <!--begin::Table head-->
                                <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-center text-muted fw-bolder fs-7 text-uppercase gs-0">                                
                                        <th>No.</th>
                                        <th>Fund Number</th>
                                        <th>Program</th>
                                        <th>Kriteria</th>
                                        <th>Departement</th>
                                        <th>Direktorat</th>
                                        <th>Account</th>
                                        <th>Progres</th>
                                        <th>NILAI EAC</th>
                                        <th>NILAI Commit</th>
                                        <th>Sisa Nilai</th>
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
            <!--end::Col-->

        </div>
    </div>
    <!--end::Content container-->
</div>
<!--end::Content-->

<div class="modal fade" id="modal-data-upload" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" data-bs-focus="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Data Upload Excell Program</h5>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <span class="svg-icon svg-icon-2x"></span>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body">
                <div class="row">
                    <!--begin::Col-->
                    <div class="col-lg-12">
                        <!--begin::Label-->
                        <label class="form-label">Tanggal Upload :</label>
                        <!--end::Label-->
                        <div class="input-group mb-5">
                            <span class="input-group-text" id="basic-addon1">
                                <i class="bi bi-calendar-month fs-3"></i>
                            </span>
                            <input type="text" class="form-control"  name="form_progres_program_upload_tanggal" id="form_progres_program_upload_tanggal" placeholder="Tanggal Upload" aria-label="Tanggal Upload" aria-describedby="basic-addon1"/>
                        </div>
                    </div>
                    <!--end::Col-->

                    <!--begin::Col-->
                    <div class="col-lg-12">
                        <!--begin::Label-->
                        <label class="form-label">Excell Master Program :</label>
                        <!--end::Label-->
                        <div class="input-group mb-5">
                            <span class="input-group-text" id="basic-addon1">
                                <i class="bi bi-file-earmark-richtext fs-3"></i>
                            </span>
                            <input type="file" class="form-control"  name="form_progres_program_upload_file[]" id="form_progres_program_upload_file" placeholder="Upload Excell Progres" aria-label="Upload Excell Progres" aria-describedby="basic-addon1" multiple/>
                        </div>
                    </div>
                    <!--end::Col-->

                    <!--begin::Col-->
                    <div class="col-md-12">
                        <div class="d-flex float-md-end">
                            <button type="button" class="btn btn-primary mt-2" id="btnTambahData" onclick="act_btnTambahDataUpload()">
                                <span class="indicator-label"><i class="bi bi-cloud-upload-fill fs-4 me-2"></i> Upload Master Program</span>
                            </button>
                        </div>
                    </div>
                    <!--end::Col-->

                </div>                                   
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
    
    <script src="{{ URL::asset('js/pages/tr_progres_program_import.js?version=') }}{{uniqid()}}"></script>

@endsection