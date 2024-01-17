@extends('layouts/adminLayoutMaster')

@section('title', 'Dashboard Transaksi')

@section('page-style')
    <!-- Current Page CSS Costum -->
    <style>
        .dataContenDashboard {
          display: none;
        }

        .jam-digital {
            margin: 0 auto;
        }

        .clock {
            height: 120px;
        }
        .date {
            width: 100%;
            text-align: center;
            font-size: 1.5rem;
        }
        .date, .hr, .min, .sec, .colon {
            color: var(--text);
            text-shadow: 0 0 10px var(--shadow-1), 0 0 15px var(--shadow-2), 0 0 20px var(--shadow-2);
        }
        .hr, .min, .sec, .colon {
            width: 20%;
            float: left;
            text-align: center;
            font-size: 1.5rem;
        }
    </style>
@endsection

@section('content')

<!--begin::Content-->
<div id="kt_app_content" class="app-content flex-column-fluid">
    <!--begin::Content container-->
    <div id="kt_app_content_container" class="app-container container-fluid">
        <div class="row mt-5">
            <!--begin::Col-->
            <div class="col-lg-4 mb-2">
                <!--begin::Label-->
                <label class="form-label fw-bold"> Dashboard Pendapatan - {{ Carbon\Carbon::now('Asia/Jakarta')->locale('id')->isoFormat('HH:mm:ss') }}</label>
                <!--end::Label-->
                <h2 class="fw-bold mt-2">{{ Carbon\Carbon::now('Asia/Jakarta')->locale('id')->isoFormat('dddd, D
                    MMMM Y') }}</h2>
                <h2 class="fw-bold" id="time"></h2>
            </div>
            <!--end::Col-->

            <!--begin::Col-->
            <div class="col-lg-2 mb-2">
                <div class="d-flex flex-stack">
                    <!--begin::Wrapper-->
                    <div class="d-flex align-items-center me-3">
                        <!--begin::Logo-->
                        <span class="indicator-label"><i class="bi bi-boxes fs-1 me-5 text-primary"></i></span>
                        <!--end::Logo-->

                        <!--begin::Section-->
                        <div class="flex-grow-1">
                            <!--begin::Text-->
                            <a href="#" class="text-gray-800 text-hover-primary fs-5 fw-bold lh-0">Jenis</a>
                            <!--end::Text-->
                            <!--begin::Description-->
                            <span class="text-gray-400 fw-semibold d-block fs-6">Jumlah</span>
                            <!--end::Description=-->
                        </div>
                        <!--end::Section-->

                    </div>
                    <!--end::Wrapper-->

                    <!--begin::Statistics-->
                    <div class="d-flex align-items-center w-100 mw-125px">
                        <!--begin::Progress-->
                        <div class="progress h-6px w-100 me-2 bg-light-success">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <!--end::Progress-->
                        <!--begin::Value-->
                        <span class="fs-2hx fw-bold text-dark" id="data_line1_jumlah_barang_jenis">0</span>
                        <!--end::Value-->
                    </div>
                    <!--end::Statistics-->
                </div>
                <div class="separator separator-dashed my-3"></div>
            </div>
            <!--end::Col-->

            <!--begin::Col-->
            <div class="col-lg-2 mb-2">
                <div class="d-flex flex-stack">
                    <!--begin::Wrapper-->
                    <div class="d-flex align-items-center me-3">
                        <!--begin::Logo-->
                        <span class="indicator-label"><i class="bi bi-archive fs-1 me-5 text-primary"></i></span>
                        <!--end::Logo-->

                        <!--begin::Section-->
                        <div class="flex-grow-1">
                            <!--begin::Text-->
                            <a href="#" class="text-gray-800 text-hover-primary fs-5 fw-bold lh-0">Barang</a>
                            <!--end::Text-->
                            <!--begin::Description-->
                            <span class="text-gray-400 fw-semibold d-block fs-6">Jumlah</span>
                            <!--end::Description=-->
                        </div>
                        <!--end::Section-->

                    </div>
                    <!--end::Wrapper-->
                    <!--begin::Statistics-->
                    <div class="d-flex align-items-center w-100 mw-125px">
                        <!--begin::Progress-->
                        <div class="progress h-6px w-100 me-2 bg-light-success">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <!--end::Progress-->
                        <!--begin::Value-->
                        <span class="fs-2hx fw-bold text-dark" id="data_line1_jumlah_barang">0</span>
                        <!--end::Value-->
                    </div>
                    <!--end::Statistics-->
                </div>
                <div class="separator separator-dashed my-3"></div>
            </div>
            <!--end::Col-->

            <!--begin::Col-->
            <div class="col-lg-2 mb-2">
                <div class="d-flex flex-stack">
                    <!--begin::Wrapper-->
                    <div class="d-flex align-items-center me-3">
                        <!--begin::Logo-->
                        <span class="indicator-label"><i class="bi bi-buildings fs-1 me-5 text-primary"></i></span>
                        <!--end::Logo-->
                        <!--begin::Section-->
                        <div class="flex-grow-1">
                            <!--begin::Text-->
                            <a href="#" class="text-gray-800 text-hover-primary fs-5 fw-bold lh-0">Supplier</a>
                            <!--end::Text-->
                            <!--begin::Description-->
                            <span class="text-gray-400 fw-semibold d-block fs-6">Jumlah</span>
                            <!--end::Description=-->
                        </div>
                        <!--end::Section-->
                    </div>
                    <!--end::Wrapper-->
                    <!--begin::Statistics-->
                    <div class="d-flex align-items-center w-100 mw-125px">
                        <!--begin::Progress-->
                        <div class="progress h-6px w-100 me-2 bg-light-success">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <!--end::Progress-->
                        <!--begin::Value-->
                        <span class="fs-2hx fw-bold text-dark" id="data_line1_jumlah_supplier">0</span>
                        <!--end::Value-->
                    </div>
                    <!--end::Statistics-->
                </div>
                <div class="separator separator-dashed my-3"></div>
            </div>
            <!--end::Col-->

            <!--begin::Col-->
            <div class="col-lg-2 mb-2">
                <div class="d-flex flex-stack">
                    <!--begin::Wrapper-->
                    <div class="d-flex align-items-center me-3">
                        <!--begin::Logo-->
                        <span class="indicator-label"><i class="bi bi-person-bounding-box fs-1 me-5 text-primary"></i></span>
                        <!--end::Logo-->
                        <!--begin::Section-->
                        <div class="flex-grow-1">
                            <!--begin::Text-->
                            <a href="#" class="text-gray-800 text-hover-primary fs-5 fw-bold lh-0">Customer</a>
                            <!--end::Text-->
                            <!--begin::Description-->
                            <span class="text-gray-400 fw-semibold d-block fs-6">Jumlah</span>
                            <!--end::Description=-->
                        </div>
                        <!--end::Section-->
                    </div>
                    <!--end::Wrapper-->
                    <!--begin::Statistics-->
                    <div class="d-flex align-items-center w-100 mw-125px">
                        <!--begin::Progress-->
                        <div class="progress h-6px w-100 me-2 bg-light-success">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <!--end::Progress-->
                        <!--begin::Value-->
                        <span class="fs-2hx fw-bold text-dark" id="data_line1_jumlah_customer">0</span>
                        <!--end::Value-->
                    </div>
                    <!--end::Statistics-->
                </div>
                <div class="separator separator-dashed my-3"></div>
            </div>
            <!--end::Col-->

            <!--begin::Col-->
            <div class="col-lg-6 mb-2">
                <div class="mb-5">
                    <div class="d-flex flex-stack">
                        <div class="fw-bolder fs-4">Data Transaksi Purchases
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

                <div class="ph-item loaderConten rounded" id="loaderconten_line2_trpurchases">
                    <div class="ph-col-2">
                        <div class="ph-avatar"></div>
                    </div>
                    <div>
                        <div class="ph-row">
                            <div class="ph-col-12"></div>
                            <div class="ph-col-2"></div>
                            <div class="ph-col-2 empty"></div>
                            <div class="ph-col-6"></div>
                            <div class="ph-col-2 empty"></div>
                            <div class="ph-col-8 big"></div>
                            <div class="ph-col-4 big empty"></div>
                            <div class="ph-col-12 big"></div>
                        </div>
                    </div>
                </div> 

                <div class="row">
                    <div class="col-md-4 mb-2">
                        <div class="card bg-light-warning shadow-sm card-xl-stretch dataContenDashboard" id="conten_line2_trpurchases_harian">
                            <div class="card-body p-3">                            
                                <div class="d-flex flex-row mb-2">
                                    <div class="text-dark fs-1hx fw-bolder fs-3 mt-3 ms-2" id="data_line2_trpurchases_harian" class="indicator-progress"> 0 Transaksi</div>
                                </div>
    
                                <div class="fw-bold fs-5 text-dark">Transaksi Hari Ini</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-2">
                        <div class="card bg-light-warning shadow-sm card-xl-stretch dataContenDashboard" id="conten_line2_trpurchases_total">
                            <div class="card-body p-3">                            
                                <div class="d-flex flex-row mb-2">
                                    <span class="indicator-label pt-2"><i class="bi bi-clipboard-data fs-2hx me-5 text-primary"></i></span>
                                    <div class="text-dark fs-1hx fw-bolder fs-3 mt-3 ms-2" id="data_line2_trpurchases_total" class="indicator-progress"> 0 Transaksi</div>
                                </div>
    
                                <div class="fw-bold fs-5 text-dark">Total Transaksi</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-2">
                        <div class="card bg-light-warning shadow-sm card-xl-stretch dataContenDashboard" id="conten_line2_trpurchases_estimasi">
                            <div class="card-body p-3">                            
                                <div class="d-flex flex-row mb-2">
                                    <div class="text-dark fs-1hx fw-bolder fs-3 mt-3 ms-2" id="data_line2_trpurchases_estimasi" class="indicator-progress"> Rp. -</div>
                                </div>
    
                                <div class="fw-bold fs-5 text-dark">Estimasi Purchases</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-2">
                        <div class="card bg-light-warning shadow-sm card-xl-stretch dataContenDashboard" id="conten_line2_trpurchases_barang">
                            <div class="card-body p-5">                            
                                <div class="d-flex justify-content-between mt-1">
                                    <div class="sales-info d-flex align-items-center">
                                        <i class="bi bi-archive fs-1 me-2 text-primary"></i>
                                        <div class="sales-info-content">
                                            <h6 class="mb-0">Jenis Barang</h6>
                                        </div>
                                    </div>
                                    <h6 class="mb-0" id="data_line2_trpurchases_barang">0</h6>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-2">
                        <div class="card bg-light-warning shadow-sm card-xl-stretch dataContenDashboard" id="conten_line2_trpurchases_barang_unit">
                            <div class="card-body p-5">                            
                                <div class="d-flex justify-content-between mt-1">
                                    <div class="sales-info d-flex align-items-center">
                                        <i class="bi bi-arrows-fullscreen fs-1 me-2 text-primary"></i>
                                        <div class="sales-info-content">
                                            <h6 class="mb-0">Unit Barang</h6>
                                        </div>
                                    </div>
                                    <h6 class="mb-0" id="data_line2_trpurchases_barang_unit">0</h6>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!--end::Col-->

            <!--begin::Col-->
            <div class="col-lg-6 mb-2">
                <div class="mb-5">
                    <div class="d-flex flex-stack">
                        <div class="fw-bolder fs-4">Data Asset Inventory
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

                <div class="ph-item loaderConten rounded" id="loaderconten_line2_trinventory">
                    <div class="ph-col-2">
                        <div class="ph-avatar"></div>
                    </div>
                    <div>
                        <div class="ph-row">
                            <div class="ph-col-12"></div>
                            <div class="ph-col-2"></div>
                            <div class="ph-col-2 empty"></div>
                            <div class="ph-col-6"></div>
                            <div class="ph-col-2 empty"></div>
                            <div class="ph-col-8 big"></div>
                            <div class="ph-col-4 big empty"></div>
                            <div class="ph-col-12 big"></div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-2">
                        <div class="card bg-light-warning shadow-sm card-xl-stretch dataContenDashboard" id="conten_line2_trinventory_setharga">
                            <div class="card-body p-3">                            
                                <div class="d-flex flex-row mb-2">
                                    <span class="indicator-label pt-2"><i class="bi bi-calendar-x fs-2hx me-5 text-primary"></i></span>
                                    <div class="text-dark fs-1hx fw-bolder fs-3 mt-3 ms-2" id="data_line2_trinventory_setharga" class="indicator-progress"> 0 Barang</div>
                                </div>
    
                                <div class="fw-bold fs-5 text-dark">Belum Set Harga</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-2">
                        <div class="card bg-light-warning shadow-sm card-xl-stretch dataContenDashboard" id="conten_line2_trinventory_total">
                            <div class="card-body p-3">                            
                                <div class="d-flex flex-row mb-2">
                                    <span class="indicator-label pt-2"><i class="bi bi-calendar2-check fs-2hx me-5 text-primary"></i></span>
                                    <div class="text-dark fs-1hx fw-bolder fs-3 mt-3 ms-2" id="data_line2_trinventory_total" class="indicator-progress"> 0 Barang</div>
                                </div>
    
                                <div class="fw-bold fs-5 text-dark">Total Asset Inventory</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-2">
                        <div class="card bg-light-warning shadow-sm card-xl-stretch dataContenDashboard" id="conten_line2_trinventory_estimasi">
                            <div class="card-body p-3">                            
                                <div class="d-flex flex-row mb-2">
                                    <div class="text-dark fs-1hx fw-bolder fs-3 mt-3 ms-2" id="data_line2_trinventory_estimasi" class="indicator-progress"> Rp. 0</div>
                                </div>
    
                                <div class="fw-bold fs-5 text-dark">Estimasi Penjulan</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-2">
                        <div class="card bg-light-warning shadow-sm card-xl-stretch dataContenDashboard" id="conten_line2_trinventory_barang">
                            <div class="card-body p-5">                            
                                <div class="d-flex justify-content-between mt-1">
                                    <div class="sales-info d-flex align-items-center">
                                        <i class="bi bi-archive fs-1 me-2 text-primary"></i>
                                        <div class="sales-info-content">
                                            <h6 class="mb-0">Jenis Barang</h6>
                                        </div>
                                    </div>
                                    <h6 class="mb-0" id="data_line2_trinventory_barang">0</h6>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-2">
                        <div class="card bg-light-warning shadow-sm card-xl-stretch dataContenDashboard" id="conten_line2_trinventory_barang_unit">
                            <div class="card-body p-5">                            
                                <div class="d-flex justify-content-between mt-1">
                                    <div class="sales-info d-flex align-items-center">
                                        <i class="bi bi-arrows-fullscreen fs-1 me-2 text-primary"></i>
                                        <div class="sales-info-content">
                                            <h6 class="mb-0">Unit Barang</h6>
                                        </div>
                                    </div>
                                    <h6 class="mb-0" id="data_line2_trinventory_barang_unit">0</h6>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                
            </div>
            <!--end::Col-->

            <!--begin::Col-->
            <div class="col-lg-12 mb-2">
                <div class="mb-5">
                    <div class="d-flex flex-stack">
                        <div class="fw-bolder fs-4">Data Transaksi Penjualan
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

                <div class="ph-item loaderConten rounded" id="loaderconten_line3_trpenjualan">
                    <div class="ph-col-2">
                        <div class="ph-avatar"></div>
                    </div>
                    <div class="ph-col-10">
                        <div class="ph-picture"></div>
                        <div class="ph-row">
                            <div class="ph-col-6 big"></div>
                            <div class="ph-col-4 empty big"></div>
                            <div class="ph-col-2 big"></div>
                            <div class="ph-col-4"></div>
                            <div class="ph-col-8 empty"></div>
                            <div class="ph-col-6"></div>
                            <div class="ph-col-6 empty"></div>
                            <div class="ph-col-12"></div>
                        </div>
                    </div>       
                </div>

                <div class="row">
                    <div class="col-md-3 mb-2">
                        <div class="card bg-light-warning shadow-sm card-xl-stretch dataContenDashboard" id="conten_line3_trpenjualan_harian">
                            <div class="card-body p-3">                            
                                <div class="d-flex flex-row mb-2">
                                    <span class="indicator-label pt-2"><i class="bi bi-calendar-date fs-2hx me-5 text-primary"></i></span>
                                    <div class="text-dark fs-1hx fw-bolder fs-3 mt-3 ms-2" id="data_line3_trpenjualan_harian" class="indicator-progress"> 0 Transaksi</div>
                                </div>
    
                                <div class="fw-bold fs-5 text-dark">Transaksi Hari Ini</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-2">
                        <div class="card bg-light-warning shadow-sm card-xl-stretch dataContenDashboard" id="conten_line3_trpenjualan_total">
                            <div class="card-body p-3">                            
                                <div class="d-flex flex-row mb-2">
                                    <span class="indicator-label pt-2"><i class="bi bi-clipboard-data fs-2hx me-5 text-primary"></i></span>
                                    <div class="text-dark fs-1hx fw-bolder fs-3 mt-3 ms-2" id="data_line3_trpenjualan_total" class="indicator-progress"> 0 Transaksi</div>
                                </div>
    
                                <div class="fw-bold fs-5 text-dark">Total Transaksi Penjualan</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-2">
                        <div class="card bg-light-warning shadow-sm card-xl-stretch dataContenDashboard" id="conten_line3_trpenjualan_barang">
                            <div class="card-body p-3">                            
                                <div class="d-flex flex-row mb-2">
                                    <span class="indicator-label pt-2"><i class="bi bi-boxes fs-2hx me-5 text-primary"></i></span>
                                    <div class="text-dark fs-1hx fw-bolder fs-3 mt-3 ms-2" id="data_line3_trpenjualan_barang" class="indicator-progress"> 0 Barang</div>
                                </div>
    
                                <div class="fw-bold fs-5 text-dark">Total Barang Penjualan</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-2">
                        <div class="card bg-light-warning shadow-sm card-xl-stretch dataContenDashboard" id="conten_line3_trpenjualan_estimasipendapatan">
                            <div class="card-body p-3">                            
                                <div class="d-flex flex-row mb-2">
                                    <div class="text-dark fs-1hx fw-bolder fs-1 mt-2 ms-2" id="data_line3_trpenjualan_estimasipendapatan" class="indicator-progress"> Rp. 0</div>
                                </div>
    
                                <div class="fw-bold fs-5 text-dark">Total Penjualan</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mb-2 mt-5">
                        <div class="ph-item loaderConten" id="loaderconten_line4_grafik_penjualan">
                            <div class="ph-col-2">
                                <div class="ph-avatar"></div>
                            </div>
                            <div class="ph-col-10">
                                <div class="ph-picture"></div>
                                <div class="ph-row">
                                    <div class="ph-col-6 big"></div>
                                    <div class="ph-col-4 empty big"></div>
                                    <div class="ph-col-2 big"></div>
                                    <div class="ph-col-4"></div>
                                    <div class="ph-col-8 empty"></div>
                                    <div class="ph-col-6"></div>
                                    <div class="ph-col-6 empty"></div>
                                    <div class="ph-col-12"></div>
                                </div>
                            </div> 
                        </div>

                        <div class="dataContenDashboard" id="conten_line4_grafik_penjualan">
                            <div id="line4_grafik_penjualan"></div>       
                        </div>
                    </div>

                    <div class="col-md-12 mb-2">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                
                                <div class="table-responsive">
                                    <!--begin::Table-->
                                    <table class="table table-striped table-hover align-middle table-row-dashed fs-6 gy-5" id="tabel_master_data">
                                        <!--begin::Table head-->
                                        <thead>
                                            <!--begin::Table row-->
                                            <tr class="text-center text-muted fw-bolder fs-7 text-uppercase gs-0">                                
                                                <th>No.</th>
                                                <th>Data Purchase</th>
                                                <th>Customer</th>
                                                <th>Jumlah Barang</th>
                                                <th>Total Pembelian</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                            <!--end::Table row-->
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody class="text-gray-600 fw-bold">
                                            @foreach ($model['tr_penjualan']  as $penjualan)
                                            <tr>
                                                <td class="text-center">
                                                    <div class="position-relative py-2">
                                                        <div class="position-absolute start-0 top-0 w-4px h-100 rounded-2 bg-success"></div>
                                                        <a href="#" class="mb-1 text-dark text-hover-primary fw-bolder">{{ $loop->iteration }}</a>
                                                    </div>
                                                </td>
                                                <td class="text-start">
                                                    <div class="d-flex flex-column">
                                                        <a href="#" class="text-gray-800 text-hover-primary mb-1 fw-bolder fs-5">{{ $penjualan->invoice_nomor }}</a>
                                                        <small>{{ Carbon\Carbon::parse($penjualan->invoice_tanggal)->locale('id')->isoFormat('D MMMM Y') }}</small>
                                                        <hr>
                                                    </div>
                                                </td>
                                                <td class="text-start">
                                                    <div class="d-flex flex-column">
                                                        <a href="#" class="text-gray-800 text-hover-primary mb-1 fw-bolder fs-5">{{ $penjualan->mCustomer->nama  }}</a>
                                                        <div class="d-flex justify-content-between mb-2">
                                                            <div class="sales-info d-flex align-items-center">
                                                                <i class="bi bi-envelope-at fs-4 me-4 text-primary"></i>
                                                                <div class="sales-info-content">
                                                                    <h6 class="mb-0">: {{ $penjualan->mCustomer->email }}</h6>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex justify-content-between mb-2">
                                                            <div class="sales-info d-flex align-items-center">
                                                                <i class="bi bi-whatsapp fs-4 me-4 text-primary"></i>
                                                                <div class="sales-info-content">
                                                                    <h6 class="mb-0">: {{ $penjualan->mCustomer->handphone }}</h6>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="w-100 text-end"><span class="form-label fw-bold text-dark"> {{ number_format($penjualan->trPenjualanDetail->count(),0,',','.') }}</span></div>
                                                </td>
                                                <td class="text-end">
                                                    <div class="w-100 text-end"><span class="form-label fw-bold text-dark"> {{ number_format($penjualan->total,0,',','.') }}</span></div>
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge badge-light-info badge-lg">{{ $penjualan->status }}</span>
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('transaksi.penjualan.detail', ['data_uuid' => $penjualan->uuid]) }}" class="btn btn-sm btn-warning">
                                                        <i class="bi bi-eye-fill fs-4 ms-2"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <!--end::Table body-->
                                    </table>
                                    <!--end::Table-->
                                </div>
                
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!--end::Col-->

            <!--begin::Col-->
            <div class="col-lg-8 mb-2">
                <div class="mb-5">
                    <div class="d-flex flex-stack">
                        <div class="fw-bolder fs-4">Grafik Transaksi Pengeluaran
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

                <div class="ph-item loaderConten" id="loaderconten_line4_grafik_keuangan_pengeluaran">
                    <div class="ph-col-2">
                        <div class="ph-avatar"></div>
                    </div>
                    <div class="ph-col-10">
                        <div class="ph-picture"></div>
                        <div class="ph-row">
                            <div class="ph-col-6 big"></div>
                            <div class="ph-col-4 empty big"></div>
                            <div class="ph-col-2 big"></div>
                            <div class="ph-col-4"></div>
                            <div class="ph-col-8 empty"></div>
                            <div class="ph-col-6"></div>
                            <div class="ph-col-6 empty"></div>
                            <div class="ph-col-12"></div>
                        </div>
                    </div> 
                </div>

                <div class="dataContenDashboard" id="conten_statistik_tr_keuangan_pengeluaran">
                    <div id="line4_chart_statistik_tr_keuangan_pengeluaran"></div>       
                </div>

            </div>
            <!--end::Col-->

            <!--begin::Col-->
            <div class="col-lg-4 mb-2">
                <div class="mb-5">
                    <div class="d-flex flex-stack">
                        <div class="fw-bolder fs-4">Diagram Laporan Keuangan
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

                <div class="ph-item loaderConten" id="loaderconten_line4_diagram_statistik_tr_keuangan">
                    <div class="ph-col-12">
                        <div class="ph-picture"></div>
                        <div class="ph-row">
                            <div class="ph-col-6 big"></div>
                            <div class="ph-col-4 empty big"></div>
                            <div class="ph-col-2 big"></div>
                            <div class="ph-col-4"></div>
                            <div class="ph-col-8 empty"></div>
                            <div class="ph-col-6"></div>
                            <div class="ph-col-6 empty"></div>
                            <div class="ph-col-12"></div>
                        </div>
                    </div> 
                </div>

                <div class="dataContenDashboard" id="conten_diagram_statistik_tr_keuangan">
                    <div id="diagram_statistik_tr_keuangan"></div>       
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
    
    <script src="{{ URL::asset('js/pages/dashboard_transaksi.js?version=') }}{{uniqid()}}"></script>

@endsection