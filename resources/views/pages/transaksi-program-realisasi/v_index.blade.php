@extends('layouts/adminLayoutMaster')

@section('title', '- Transaksi Program Realisasi')

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
            <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Transaksi Program Realisasi</h1>
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
                <li class="breadcrumb-item text-muted">Program Realisasi</li>
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
                <label class="form-label fw-bold">Program : </label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" name="form_filter_program" id="form_filter_program" class="form-control mb-2" placeholder="Nama Program"/>
                <!--end::Input-->
            </div>
            <div class="col-12 col-lg-3 col-md-3">
                <!--begin::Label-->
                <label class="form-label fw-bold">Program Jenis CCK : </label>
                <!--end::Label-->
                <!--begin::Input-->
                <select class="form-select mb-2" name="form_filter_program_jenis" id="form_filter_program_jenis"  data-control="select2" data-placeholder="Select an option">
                    <option value="-">-- Program Jenis CCK -- </option> 
                    @foreach ($model['ms_program_jenis_cck'] as $program_jenis_cck)
                        <option value="{{$program_jenis_cck->uuid}}">{{$program_jenis_cck->name}}</option>
                    @endforeach                             
                </select>
                <!--end::Input-->
            </div>
            <div class="col-12 col-lg-3 col-md-3">
                <!--begin::Label-->
                <label class="form-label fw-bold">Program Lokasi CC : </label>
                <!--end::Label-->
                <!--begin::Input-->
                <select class="form-select mb-2" name="form_filter_program_lokasi" id="form_filter_program_lokasi"  data-control="select2" data-placeholder="Select an option">
                    <option value="-">-- Program Lokasi CC -- </option> 
                    @foreach ($model['ms_program_lokasi_cc'] as $program_lokasi_cc)
                        <option value="{{$program_lokasi_cc->uuid}}">{{$program_lokasi_cc->name}}</option>
                    @endforeach                             
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
            <div class="col-12 col-lg-3 col-md-3">
                <!--begin::Label-->
                <label class="form-label fw-bold">Fund Number : </label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" name="form_filter_program_fundnumber" id="form_filter_program_fundnumber" class="form-control mb-2" placeholder="Fund Number"/>
                <!--end::Input-->
            </div>
            <div class="col-12 col-lg-3 col-md-3">
                <!--begin::Label-->
                <label class="form-label fw-bold">Status Program : </label>
                <!--end::Label-->
                <!--begin::Input-->
                <select class="form-select mb-2" name="form_filter_program_status" id="form_filter_program_status"  data-control="select2" data-placeholder="Select an option">
                    <option value="-">-- Status Program -- </option>                       
                </select>
                <!--end::Input-->
            </div>
            <div class="col-12 col-lg-3 col-md-3">
                <!--begin::Label-->
                <label class="form-label fw-bold">MIN Anggaran : </label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="number" name="form_filter_program_min_anggaran" id="form_filter_program_min_anggaran" class="form-control mb-2" placeholder="MIN Anggaran"/>
                <!--end::Input-->
            </div>
            <div class="col-12 col-lg-3 col-md-3">
                <!--begin::Label-->
                <label class="form-label fw-bold">MAX Anggaran : </label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="number" name="form_filter_program_max_anggaran" id="form_filter_program_max_anggaran" class="form-control mb-2" placeholder="MAX Anggaran"/>
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
            <div class="col-lg-6 mb-2">
                <div class="mb-5">
                    <div class="d-flex flex-stack">
                        <div class="fw-bolder fs-4">Progres Program
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
                        <div class="row">
                            <div class="col-md-4">
                                <!--begin::Item-->
                                <div class="d-flex flex-stack">
                                    <!--begin::Section-->
                                    <a href="#" class="text-primary fw-semibold fs-6 me-2">PR</a>
                                    <!--end::Section-->
                                    <!--begin::Action-->
                                    <b class="fw-bold fs-5">0</b>
                                    <!--end::Action-->
                                </div>
                                <!--end::Item-->
                                <!--begin::Separator-->
                                <div class="separator separator-dashed my-1"></div>
                                <!--end::Separator-->
                            </div>

                            <div class="col-md-4">
                                <!--begin::Item-->
                                <div class="d-flex flex-stack">
                                    <!--begin::Section-->
                                    <a href="#" class="text-primary fw-semibold fs-6 me-2">PO</a>
                                    <!--end::Section-->
                                    <!--begin::Action-->
                                    <b class="fw-bold fs-5">0</b>
                                    <!--end::Action-->
                                </div>
                                <!--end::Item-->
                                <!--begin::Separator-->
                                <div class="separator separator-dashed my-1"></div>
                                <!--end::Separator-->
                            </div>

                            <div class="col-md-4">
                                <!--begin::Item-->
                                <div class="d-flex flex-stack">
                                    <!--begin::Section-->
                                    <a href="#" class="text-primary fw-semibold fs-6 me-2">GR</a>
                                    <!--end::Section-->
                                    <!--begin::Action-->
                                    <b class="fw-bold fs-5">0</b>
                                    <!--end::Action-->
                                </div>
                                <!--end::Item-->
                                <!--begin::Separator-->
                                <div class="separator separator-dashed my-1"></div>
                                <!--end::Separator-->
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!--end::Col-->

            <!--begin::Col-->
            <div class="col-12">
                <div class="card shadow-sm mt-5">                
                    <div class="card-body">
                        <div class="text-end d-none">
                            <button type="button" class="btn btn-success py-4" onclick="downloadExportExcel()">
                                <span class="indicator-label"><i class="bi bi-filetype-xlsx fs-2 me-2"></i> Export Excell</span>
                            </button>
                        </div>
                        <div class="table-responsive">
                            <!--begin::Table-->
                            <table class="table table-striped table-hover align-middle table-row-dashed fs-6 gy-5" id="tabel_master_data">
                                <!--begin::Table head-->
                                <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-center text-muted fw-bolder fs-7 text-uppercase gs-0">                                
                                        <th class="text-center">No.</th>
                                        <th class="text-center">Fund Number</th>
                                        <th class="text-center">Program</th>
                                        <th class="text-center">Anggaran</th>
                                        <th class="text-center">MR / SR</th>
                                        <th class="text-center">PR</th>
                                        <th class="text-center">PO</th>
                                        <th class="text-center">Realisasi</th>
                                        <th class="text-center">Actions</th>
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
    
    <script src="{{ URL::asset('js/pages/tr_program_realisasi.js?version=') }}{{uniqid()}}"></script>

@endsection