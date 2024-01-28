@extends('layouts/adminLayoutMaster')

@section('title', 'Dashboard Admin')

@section('page-style')
    <!-- Current Page CSS Costum -->

@endsection

@section('content')

<!--begin::Content-->
<div id="kt_app_content" class="app-content flex-column-fluid">
    <!--begin::Content container-->
    <div id="kt_app_content_container" class="app-container container-fluid">
        <div class="row">
            <!--begin::Col-->
            <div class="col-lg-3 mb-2 mt-5">
                <!--begin::Label-->
                <label class="form-label fw-bold"> Dashboard Realisasi - {{ Carbon\Carbon::now('Asia/Jakarta')->locale('id')->isoFormat('HH:mm:ss') }}</label>
                <!--end::Label-->
                <h2 class="fw-bold mt-2">{{ Carbon\Carbon::now('Asia/Jakarta')->locale('id')->isoFormat('dddd, D
                    MMMM Y') }}</h2>
                <h2 class="fw-bold" id="time"></h2>
            </div>
            <!--end::Col-->
            
            @php
                $total_program_anggaran = $model['ms_program']->sum('nominal');
                $total_progres_sr = $model['tr_progres_sr']->sum('nominal');
                $total_progres_sr_belum = $total_program_anggaran - $total_progres_sr;
                $total_progres_realisasi = $model['tr_progres_gr']->sum('nominal');
                $persentase_progres_realisasi = ( $total_progres_realisasi / $total_program_anggaran) * 100;
                $total_program_anggaran_sisa = $total_program_anggaran - $total_progres_realisasi;
                $persentase_progres_realisasi_sisa = ( $total_program_anggaran_sisa / $total_program_anggaran) * 100;
                $total_progres_pr = $model['tr_progres_pr']->where('status', 1)->sum('pr_nominal');
                $persentase_progres_pr = ( $total_progres_pr / $total_program_anggaran) * 100;
                $total_progres_po = $model['tr_progres_po']->where('status', 1)->sum('po_nominal');
                $persentase_progres_po = ( $total_progres_po / $total_program_anggaran) * 100;
            @endphp

            <!--begin::Col-->
            <div class="col-lg-3 mb-2 mt-5">
                <div class="d-flex flex-stack">
                    <!--begin::Wrapper-->
                    <div class="d-flex align-items-center me-3">
                        <!--begin::Logo-->
                        <span class="indicator-label"><i class="bi bi-boxes fs-1 me-5 text-primary"></i></span>
                        <!--end::Logo-->

                        <!--begin::Section-->
                        <div class="flex-grow-1">
                            <!--begin::Text-->
                            <a href="#" class="text-gray-800 text-hover-primary fs-5 fw-bold lh-0">Program Jenis CCK</a>
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
                        <span class="fs-2hx fw-bold text-dark" id="data_line1_jumlah_program_jenis">{{ $model['ms_program']->groupBy('id_program_jenis_cck')->count() }}</span>
                        <!--end::Value-->
                    </div>
                    <!--end::Statistics-->
                </div>
                <div class="separator separator-dashed my-3"></div>
            </div>
            <!--end::Col-->

            <!--begin::Col-->
            <div class="col-lg-3 mb-2 mt-5">
                <div class="d-flex flex-stack">
                    <!--begin::Wrapper-->
                    <div class="d-flex align-items-center me-3">
                        <!--begin::Logo-->
                        <span class="indicator-label"><i class="bi bi-buildings-fill fs-1 me-5 text-primary"></i></span>
                        <!--end::Logo-->

                        <!--begin::Section-->
                        <div class="flex-grow-1">
                            <!--begin::Text-->
                            <a href="#" class="text-gray-800 text-hover-primary fs-5 fw-bold lh-0">Program Lokasi CC</a>
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
                        <span class="fs-2hx fw-bold text-dark" id="data_line1_jumlah_program_lokasi">{{ $model['ms_program']->groupBy('id_program_lokasi_cc')->count() }}</span>
                        <!--end::Value-->
                    </div>
                    <!--end::Statistics-->
                </div>
                <div class="separator separator-dashed my-3"></div>
            </div>
            <!--end::Col-->

            <!--begin::Col-->
            <div class="col-lg-3 mb-2 mt-5">
                <div class="d-flex flex-stack">
                    <!--begin::Wrapper-->
                    <div class="d-flex align-items-center me-3">
                        <!--begin::Logo-->
                        <span class="indicator-label"><i class="bi bi-stickies fs-1 me-5 text-primary"></i></span>
                        <!--end::Logo-->

                        <!--begin::Section-->
                        <div class="flex-grow-1">
                            <!--begin::Text-->
                            <a href="#" class="text-gray-800 text-hover-primary fs-5 fw-bold lh-0">Program Anggaran</a>
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
                        <span class="fs-2hx fw-bold text-dark" id="data_line1_jumlah_program">{{ $model['ms_program']->count() }}</span>
                        <!--end::Value-->
                    </div>
                    <!--end::Statistics-->
                </div>
                <div class="separator separator-dashed my-3"></div>
            </div>
            <!--end::Col-->  

            <!--begin::Col-->
            <div class="col-xl-4">
                <!--begin::Card widget 3-->
                <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-xl-100" style="background-color: #7239EA;background-image:url({{ URL::asset('media/svg/shapes/wave-bg-purple.svg') }})">
                        
                    <div class="card-header" style="border-bottom: 1px solid rgba(255, 255, 255, 0.3);background: rgba(0, 0, 0, 0.15);">
                        <!--begin::Progress-->
                        <div class="fw-bold text-white text-hover-dark py-2">
                            <span class="fs-2 d-block">Total Anggaran Program</span>
                            <span class="opacity-50 update_tanggal_conten">Tahun Anggaran 2024</span>
                        </div>
                        <!--end::Progress-->
                    </div>

                    <!--begin::Card body-->
                    <div class="card-body p-2">
                        <div class="d-flex align-items-center justify-content-center text-center">
                            <h1 class="text-white text-hover-dark lh-base fw-bold fs-lg-2tx fs-md-3 fs-sm-1">
                                <b id="data_line2_total_program_anggaran">Rp. {{  number_format($total_program_anggaran,0,',','.') }}</b>
                            </h1>
                        </div>
                        <div class="separator separator-dashed my-3"></div>

                    </div>
                    <!--end::Card body-->

                    <!--begin::Card footer-->
                    <div class="card-footer p-2" style="border-top: 1px solid rgba(255, 255, 255, 0.3);background: rgba(0, 0, 0, 0.15);">
                        
                    </div>
                    <!--end::Card footer-->

                </div>
                <!--end::Card widget 3-->                            
            </div>
            <!--end::Col--> 

            <!--begin::Col-->
            <div class="col-xl-4">
                <!--begin::Card widget 3-->
                <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-xl-100" style="background-color: #7239EA;background-image:url({{ URL::asset('media/svg/shapes/wave-bg-purple.svg') }})">
                        
                    <div class="card-header" style="border-bottom: 1px solid rgba(255, 255, 255, 0.3);background: rgba(0, 0, 0, 0.15);">
                        <!--begin::Progress-->
                        <div class="fw-bold text-white text-hover-dark py-2">
                            <span class="fs-2 d-block">Total Progres Realisasi</span>
                            <span class="opacity-50 update_tanggal_conten">Tahun Anggaran 2024</span>
                        </div>
                        <!--end::Progress-->
                    </div>

                    <!--begin::Card body-->
                    <div class="card-body p-2">
                        <div class="d-flex align-items-center justify-content-center text-center">
                            <h1 class="text-white text-hover-dark lh-base fw-bold fs-lg-2tx fs-md-3 fs-sm-1">
                                <b id="data_line2_total_program_anggaran">Rp. {{  number_format($total_progres_realisasi,0,',','.') }}</b>
                            </h1>
                        </div>
                        <div class="separator separator-dashed my-3"></div>

                    </div>
                    <!--end::Card body-->

                    <!--begin::Card footer-->
                    <div class="card-footer p-2" style="border-top: 1px solid rgba(255, 255, 255, 0.3);background: rgba(0, 0, 0, 0.15);">
                        
                    </div>
                    <!--end::Card footer-->

                </div>
                <!--end::Card widget 3-->                            
            </div>
            <!--end::Col--> 

            <!--begin::Col-->
            <div class="col-xl-4">
                <!--begin::Card widget 3-->
                <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-xl-100" style="background-color: #7239EA;background-image:url({{ URL::asset('media/svg/shapes/wave-bg-purple.svg') }})">
                        
                    <div class="card-header" style="border-bottom: 1px solid rgba(255, 255, 255, 0.3);background: rgba(0, 0, 0, 0.15);">
                        <!--begin::Progress-->
                        <div class="fw-bold text-white text-hover-dark py-2">
                            <span class="fs-2 d-block">Sisa Program Anggaran</span>
                            <span class="opacity-50 update_tanggal_conten">Tahun Anggaran 2024</span>
                        </div>
                        <!--end::Progress-->
                    </div>

                    <!--begin::Card body-->
                    <div class="card-body p-2">
                        <div class="d-flex align-items-center justify-content-center text-center">
                            <h1 class="text-white text-hover-dark lh-base fw-bold fs-lg-2tx fs-md-3 fs-sm-1">
                                <b id="data_line2_total_program_anggaran">Rp. {{  number_format($total_program_anggaran_sisa,0,',','.') }}</b>
                            </h1>
                        </div>
                        <div class="separator separator-dashed my-3"></div>

                    </div>
                    <!--end::Card body-->

                    <!--begin::Card footer-->
                    <div class="card-footer p-2" style="border-top: 1px solid rgba(255, 255, 255, 0.3);background: rgba(0, 0, 0, 0.15);">
                        
                    </div>
                    <!--end::Card footer-->

                </div>
                <!--end::Card widget 3-->                            
            </div>
            <!--end::Col--> 

            <!--begin::Col-->
            <div class="col-xl-4 mt-5">
                <div class="mb-5">
                    <div class="d-flex flex-stack">
                        <div class="fw-bolder fs-4">Diagram Progres Realisasi
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

                <div id="line2_diagram_progres_realisasi"></div>

            </div>
            <!--end::Col--> 

            <!--begin::Col-->
            <div class="col-xl-4 mt-5">
                <div class="mb-5">
                    <div class="d-flex flex-stack">
                        <div class="fw-bolder fs-4">Detail Progres Realisasi
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

                <!--begin::Card widget 3-->
                <div class="card">
                    <!--begin::Card body-->
                    <div class="card-body">
                        
                        <!--begin::Table container-->
                        <div class="table-responsive">
                            <!--begin::Table-->
                            <table class="table table-row-dashed align-middle gs-0 gy-4 my-0">
                                <!--begin::Table head-->
                                <thead>
                                    <tr class="fs-7 fw-bold text-gray-500 border-bottom-0">
                                        <th class="min-w-125px"> Data Program</th>
                                        <th class="pe-0 text-end min-w-100px">Nominal</th>
                                        <th class="pe-0 text-end min-w-60px">&nbsp;%&nbsp;</th>
                                    </tr>
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody>
                                    <tr>
                                        <td class="ps-0">
                                            <a href="#" class="text-primary fw-semibold fs-6 me-2">Total Anggaran</a>
                                        </td>
                                        <td class="text-end pe-0">
                                            <span class="text-gray-800 fw-bold d-block fs-6">{{  number_format($total_program_anggaran,0,',','.') }}</span>
                                        </td>
                                        <td class="text-end pe-0">
                                            <span class="text-gray-800 fw-bold d-block fs-6">-</span>
                                        </td>
                                    </tr> 
                                    <tr>
                                        <td class="ps-0">
                                            <a href="#" class="text-primary fw-semibold fs-6 me-2">Update Sr</a>
                                        </td>
                                        <td class="text-end pe-0">
                                            <span class="text-gray-800 fw-bold d-block fs-6">{{  number_format($total_progres_sr,0,',','.') }}</span>
                                        </td>
                                        <td class="text-end pe-0">
                                            <span class="text-gray-800 fw-bold d-block fs-6">-</span>
                                        </td>
                                    </tr>   
                                    <tr>
                                        <td class="ps-0">
                                            <a href="#" class="text-primary fw-semibold fs-6 me-2">Belum Sr</a>
                                        </td>
                                        <td class="text-end pe-0">
                                            <span class="text-gray-800 fw-bold d-block fs-6">{{  number_format($total_progres_sr_belum,0,',','.') }}</span>
                                        </td>
                                        <td class="text-end pe-0">
                                            <span class="text-gray-800 fw-bold d-block fs-6">-</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="ps-0">
                                            <a href="#" class="text-primary fw-semibold fs-6 me-2">PR</a>
                                        </td>
                                        <td class="text-end pe-0">
                                            <span class="text-gray-800 fw-bold d-block fs-6">{{  number_format($total_progres_pr,0,',','.') }}</span>
                                        </td>
                                        <td class="text-end pe-0">
                                            <span class="text-gray-800 fw-bold d-block fs-6">{{  number_format($persentase_progres_pr,2,',','.') }} %</span>
                                        </td>
                                    </tr> 
                                    <tr>
                                        <td class="ps-0">
                                            <a href="#" class="text-primary fw-semibold fs-6 me-2">PO</a>
                                        </td>
                                        <td class="text-end pe-0">
                                            <span class="text-gray-800 fw-bold d-block fs-6">{{  number_format($total_progres_po,0,',','.') }}</span>
                                        </td>
                                        <td class="text-end pe-0">
                                            <span class="text-gray-800 fw-bold d-block fs-6">{{  number_format($persentase_progres_po,2,',','.') }} %</span>
                                        </td>
                                    </tr> 
                                    <tr>
                                        <td class="ps-0">
                                            <a href="#" class="text-primary fw-semibold fs-6 me-2">Realisasi</a>
                                        </td>
                                        <td class="text-end pe-0">
                                            <span class="text-gray-800 fw-bold d-block fs-6">{{  number_format($total_progres_realisasi,0,',','.') }}</span>
                                        </td>
                                        <td class="text-end pe-0">
                                            <span class="text-gray-800 fw-bold d-block fs-6">{{  number_format($persentase_progres_realisasi,2,',','.') }} %</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="ps-0">
                                            <a href="#" class="text-primary fw-semibold fs-6 me-2">Sisa Anggaran</a>
                                        </td>
                                        <td class="text-end pe-0">
                                            <span class="text-gray-800 fw-bold d-block fs-6">{{  number_format($total_program_anggaran_sisa,0,',','.') }}</span>
                                        </td>
                                        <td class="text-end pe-0">
                                            <span class="text-gray-800 fw-bold d-block fs-6">{{  number_format($persentase_progres_realisasi_sisa,2,',','.') }} %</span>
                                        </td>
                                    </tr>                                 
                                </tbody>
                                <!--end::Table body-->
                            </table>
                            <!--end::Table-->
                        </div>
                        <!--end::Table container-->

                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card widget 3-->                            
            </div>
            <!--end::Col-->

            <!--begin::Col-->
            <div class="col-xl-4">
                <div class="table-responsive">
                    <!--begin::Table-->
                    <table class="table table-striped table-hover align-middle table-row-dashed fs-6" id="tabel_master_data_program_jenis">
                        <!--begin::Table head-->
                        <thead>
                            <!--begin::Table row-->
                            <tr class="text-center text-dark fw-bolder fs-7 text-uppercase gs-0">                                
                                <th>No.</th>
                                <th>Jenis</th>
                                <th>Realisasi</th>
                                <th>&nbsp;%&nbsp;</th>
                            </tr>
                            <!--end::Table row-->
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody class="text-gray-600 fw-bold">
                            @foreach ($model['ms_program']->groupBy('id_program_jenis_cck') as $program_jenis)
                            <tr>
                                <td class="text-center">
                                    <div class="position-relative py-2">
                                        <div class="position-absolute start-0 top-0 w-4px h-100 rounded-2 bg-success"></div>&nbsp;
                                        <a href="#" class="mb-1 text-dark text-hover-primary fw-bolder">{{ $loop->iteration }}</a>
                                    </div>
                                </td>
                                <td class="text-start">
                                    <div class="d-flex flex-column">
                                        <a href="#" class="text-gray-800 text-hover-primary mb-1 fw-bolder fs-5">{{ $program_jenis[0]->name_program_jenis_cck }}</a>
                                        <small>{{ $program_jenis[0]->fund_center }}</small>
                                        <hr class="my-1">
                                    </div>
                                </td>
                                <td class="text-start">
                                    <div class="d-flex flex-column text-end">
                                        @php
                                            $realisasi_program_jenis = $model['tr_progres_gr']->where('name_program_jenis_cck', $program_jenis[0]->name_program_jenis_cck)->sum('gr_nominal');
                                        @endphp
                                        <a href="#" class="text-gray-800 text-hover-primary mb-1 fw-bold"> {{ number_format($realisasi_program_jenis,0,',','.')  }}</a>
                                        <small>{{ number_format($program_jenis->sum('nominal'),0,',','.') }}</small>
                                        <hr class="my-1">
                                    </div>
                                </td>
                                <td class="text-start">
                                    <div class="d-flex flex-column text-end">
                                        @php
                                            $persentase_realisasi_program_jenis = 0;
                                            if($realisasi_program_jenis != 0)
                                            {
                                                $persentase_realisasi_program_jenis = ($realisasi_program_jenis / $program_jenis->sum('nominal')) * 100;
                                            }
                                        @endphp
                                        <a href="#" class="text-gray-800 text-hover-primary mb-1 fw-bold"> {{ number_format($persentase_realisasi_program_jenis,2,',','.')  }} % &nbsp;</a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <!--end::Table body-->
                    </table>
                    <!--end::Table-->
                </div>

            </div>
            <!--end::Col-->

            <!--begin::Col-->
            <div class="col-xl-12 mt-5">
                <div class="table-responsive">
                    <!--begin::Table-->
                    <table class="table table-striped table-hover align-middle table-row-dashed fs-6 gy-5" id="tabel_master_tr_realisasi">
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
                                <th class="text-center">&nbsp; % &nbsp;</th>
                            </tr>
                            <!--end::Table row-->
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody class="text-gray-600 fw-bold">
                            @foreach ($model['ms_program'] as $program)
                            <tr>
                                <td class="text-center">
                                    <div class="position-relative py-2">
                                        <div class="position-absolute start-0 top-0 w-4px h-100 rounded-2 bg-success"></div>&nbsp;
                                        <a href="#" class="mb-1 text-dark text-hover-primary fw-bolder">{{ $loop->iteration }}</a>
                                    </div>
                                </td>
                                <td class="text-start">
                                    <div class="d-flex flex-column">
                                        <a href="#" class="text-gray-800 text-hover-primary mb-1 fw-bold">{{ $program->fund_number }}</a>
                                    </div>
                                </td>
                                <td class="text-start">
                                    <div class="d-flex flex-column">                    
                                        <a href="#" class="text-gray-800 text-hover-primary mb-1 fw-bolder fs-5">{{ $program->name }}</a>
                                        <small>{{ $program->code }}</small>
                                        <hr>
                                        <a href="#" class="text-gray-800 text-hover-primary mb-1 fw-bold">{{ $program->name_program_jenis_cck }} - {{ $program->name_program_lokasi_cc }} - {{ strtoupper($program->priority) }}</a>
                                    </div>
                                </td>
                                <td class="text-end">
                                    <div class="d-flex flex-column">
                                        <a href="#" class="text-gray-800 text-hover-primary mb-1 fw-bold">{{ number_format($program->nominal,0,',','.') }}</a>
                                    </div>
                                </td>
                                <td class="text-end">
                                    @php
                                        $nominal_sr = 0;
                                        if($program->trProgresProgramSR)
                                        {
                                            $nominal_sr = $program->trProgresProgramSR->sr_nominal;
                                        }
                                    @endphp 
                                    <div class="d-flex flex-column">
                                        <a href="#" class="text-gray-800 text-hover-primary mb-1 fw-bold">{{ number_format($nominal_sr,0,',','.') }}</a>
                                    </div>
                                </td>
                                <td class="text-end">
                                    @php
                                        $nominal_pr = 0;
                                        if($program->trProgresProgramPRMany)
                                        {
                                            $nominal_pr = $program->trProgresProgramPRMany->where('status', 1)->sum('pr_nominal');
                                        }
                                    @endphp 
                                    <div class="d-flex flex-column">
                                        <a href="#" class="text-gray-800 text-hover-primary mb-1 fw-bold">{{ number_format($nominal_pr,0,',','.') }}</a>
                                    </div>
                                </td>
                                <td class="text-end">
                                    @php
                                        $nominal_po = 0;
                                        if($program->trProgresProgramPOMany)
                                        {
                                            $nominal_po = $program->trProgresProgramPOMany->where('status', 1)->sum('po_nominal');
                                        }
                                    @endphp 
                                    <div class="d-flex flex-column">
                                        <a href="#" class="text-gray-800 text-hover-primary mb-1 fw-bold">{{ number_format($nominal_po,0,',','.') }}</a>
                                    </div>
                                </td>
                                <td class="text-end">
                                    @php
                                        $nominal_gr = 0;
                                        if($program->trProgresProgramGRMany)
                                        {
                                            $nominal_gr = $program->trProgresProgramGRMany->where('status', 1)->sum('gr_nominal');
                                        }
                                    @endphp 
                                    <div class="d-flex flex-column">
                                        <a href="#" class="text-gray-800 text-hover-primary mb-1 fw-bold">{{ number_format($nominal_gr,0,',','.') }}</a>
                                    </div>
                                </td>
                                <td class="text-end">
                                    @php
                                        $nominal_gr = 0;
                                        if($program->trProgresProgramGRMany)
                                        {
                                            $nominal_gr = $program->trProgresProgramGRMany->where('status', 1)->sum('gr_nominal');
                                        }

                                        $persentase_realisasi = ( $nominal_gr / $program->nominal ) * 100;
                                    @endphp 
                                    <div class="d-flex flex-column">
                                        <a href="#" class="text-gray-800 text-hover-primary mb-1 fw-bold">{{ number_format($persentase_realisasi,2,',','.') }} %</a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <!--end::Table body-->
                    </table>
                    <!--end::Table-->
                </div>
            </div>
            <!--end::Col-->
            @foreach ($model['ms_program']->groupBy('id_program_lokasi_cc') as $program_lokasi)
            <div class="col-lg-4 mb-5">
                <div class="card shadow-sm bg-light-info bg-hover-light">
                    <div class="card-body p-3">
                        <div class="table-responsive m-0">
                            <!--begin::Table-->
                            <table class="table table-striped table-hover align-middle table-row-dashed fs-6 m-0">
                                <!--begin::Table body-->
                                <tbody class="text-gray-600 fw-bold">                                    
                                    <tr>
                                        <td class="text-start">
                                            <div class="d-flex flex-column">
                                                <a href="#" class="text-gray-800 text-hover-primary mb-1 fw-bolder fs-5">{{ $program_lokasi[0]->name_program_lokasi_cc }}</a>
                                                <small>{{ $program_lokasi[0]->fund_center }}</small>
                                                <hr class="my-1">
                                            </div>
                                        </td>
                                        <td class="text-start">
                                            @php
                                                $realisasi_program_lokasi = $model['tr_progres_gr']->where('name_program_lokasi_cc', $program_lokasi[0]->name_program_lokasi_cc)->sum('gr_nominal');
                                            @endphp
                                            <div class="d-flex flex-column text-end">
                                                <a href="#" class="text-gray-800 text-hover-primary mb-1 fw-bold"> {{ number_format($realisasi_program_lokasi,0,',','.')  }}</a>
                                                <small>{{ number_format($program_lokasi->sum('nominal'),0,',','.') }}</small>
                                                <hr class="my-1">
                                            </div>
                                        </td>
                                        <td class="text-start">
                                            @php
                                                $persentase_realisasi_program_lokasi = 0;
                                                if($realisasi_program_lokasi != 0)
                                                {
                                                    $persentase_realisasi_program_lokasi = ($realisasi_program_lokasi / $program_lokasi->sum('nominal')) * 100;
                                                }
                                            @endphp
                                            <div class="d-flex flex-column text-end">
                                                <a href="#" class="text-gray-800 text-hover-primary mb-1 fw-bold"> {{ number_format($persentase_realisasi_program_lokasi,2,',','.')  }} % &nbsp;</a>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                                <!--end::Table body-->
                            </table>
                            <!--end::Table-->
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>
    <!--end::Content container-->
</div>
<!--end::Content-->

{{-- @php
    dd($model['ms_program']->where('id_program_jenis_cck', 1)->sum('nominal'));
@endphp --}}

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
    
    <script>
        let total_program_anggaran = {{ $total_program_anggaran }};
        let total_progres_pr = {{ $total_progres_pr }};
        let total_progres_po = {{ $total_progres_po }};
        let total_progres_realisasi = {{ $total_progres_realisasi }};
        let total_program_anggaran_sisa = {{ $total_program_anggaran_sisa }};
    </script>

    <script src="{{ URL::asset('js/pages/dashboard_program_realisasi.js?version=') }}{{uniqid()}}"></script>

@endsection