@extends('layouts/adminLayoutMaster')

@section('title', 'Dashboard Prognosa')

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
                <label class="form-label fw-bold"> Dashboard Prognosa - {{ Carbon\Carbon::now('Asia/Jakarta')->locale('id')->isoFormat('HH:mm:ss') }}</label>
                <!--end::Label-->
                <h2 class="fw-bold mt-2">{{ Carbon\Carbon::now('Asia/Jakarta')->locale('id')->isoFormat('dddd, D
                    MMMM Y') }}</h2>
                <h2 class="fw-bold" id="time"></h2>
            </div>
            <!--end::Col-->
            
            @php
                $total_program_anggaran = $model['ms_program']->sum('nominal');

                $total_progres_pr = $model['tr_progres_pr']->sum('pr_nominal');
                $persentase_progres_pr = ( $total_progres_pr / $total_program_anggaran) * 100;

                $total_progres_po = $model['tr_progres_po']->sum('po_nominal');
                $persentase_progres_po = ( $total_progres_po / $total_program_anggaran) * 100;

                $total_progres_gr = $model['tr_progres_gr']->sum('gr_nominal');
                $persentase_progres_gr = ( $total_progres_gr / $total_program_anggaran) * 100;

                $total_prognosa =  $total_progres_pr + $total_progres_po + $total_progres_gr;
                $persentase_prognosa= ( $total_prognosa / $total_program_anggaran) * 100;

                $sisa_anggaran = $total_program_anggaran - $total_prognosa;
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
            <div class="col-lg-3 mb-2 mt-2">
                <!--begin::Label-->
                <label class="form-label fw-bold">Tanggal Cut OFF : </label>
                <!--end::Label-->
                <!--begin::Input-->
                <div class="position-relative d-flex align-items-center">
                    <!--begin::Icon-->
                    <i class="ki-duotone ki-calendar-8 fs-1 position-absolute mx-4">
                        <span class="path1"></span>
                        <span class="path2"></span>
                        <span class="path3"></span>
                        <span class="path4"></span>
                        <span class="path5"></span>
                        <span class="path6"></span>
                    </i>
                    <!--end::Icon-->
                    <!--begin::Datepicker-->
                    <input class="form-control ps-12" placeholder="Select a date" value="{{date('Y')}}-12-31" placeholder="{{date('Y')}}-12-31" id="form_filter_tanggal_cutoff" name="form_filter_tanggal_cutoff"/>
                    <!--end::Datepicker-->
                </div>
                <!--end::Input-->
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
                            <span class="fs-2 d-block">Total Prognosa</span>
                            <span class="opacity-50 update_tanggal_conten">Cut Off : {{ Carbon\Carbon::parse($model['tanggal_cut_off'])->locale('id')->isoFormat('dddd, D
                                MMMM Y') }}</span>
                        </div>
                        <!--end::Progress-->
                    </div>

                    <!--begin::Card body-->
                    <div class="card-body p-2">
                        <div class="d-flex align-items-center justify-content-center text-center">
                            <h1 class="text-white text-hover-dark lh-base fw-bold fs-lg-2tx fs-md-3 fs-sm-1">
                                <b id="data_line2_total_program_anggaran">Rp. {{  number_format($total_prognosa,0,',','.') }}</b>
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
                            <span class="opacity-50 update_tanggal_conten">Cut Off : {{ Carbon\Carbon::parse($model['tanggal_cut_off'])->locale('id')->isoFormat('dddd, D
                                MMMM Y') }}</span>
                        </div>
                        <!--end::Progress-->
                    </div>

                    <!--begin::Card body-->
                    <div class="card-body p-2">
                        <div class="d-flex align-items-center justify-content-center text-center">
                            <h1 class="text-white text-hover-dark lh-base fw-bold fs-lg-2tx fs-md-3 fs-sm-1">
                                <b id="data_line2_total_program_anggaran">Rp. {{  number_format($sisa_anggaran,0,',','.') }}</b>
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
                        <div class="fw-bolder fs-4">Diagram Prognosa
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
                                <th>Prognosa</th>
                                <th>&nbsp;%&nbsp;</th>
                            </tr>
                            <!--end::Table row-->
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody class="text-gray-600 fw-bold">
                            @foreach ($model['ms_program']->groupBy('id_program_jenis_cck') as $program_jenis)
                            <tr>
                                @php
                                    $nominal_program = $program_jenis->sum('nominal');
                                    $nominal_prognosa_pr = $model['tr_progres_pr']->where('id_program_jenis_cck', $program_jenis[0]->id_program_jenis_cck)->sum('pr_nominal');
                                    $nominal_prognosa_po = $model['tr_progres_po']->where('id_program_jenis_cck', $program_jenis[0]->id_program_jenis_cck)->sum('po_nominal');
                                    $nominal_prognosa_gr = $model['tr_progres_gr']->where('id_program_jenis_cck', $program_jenis[0]->id_program_jenis_cck)->sum('gr_nominal');

                                    $total_nominal_prognosa = $nominal_prognosa_pr + $nominal_prognosa_po + $nominal_prognosa_gr;
                                    $persentase_nominal_prognosa = ( $total_nominal_prognosa / $nominal_program) * 100;
                                @endphp
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
                                        <a href="#" class="text-gray-800 text-hover-primary mb-1 fw-bold"> {{ number_format($total_nominal_prognosa,0,',','.')  }}</a>
                                        <small>{{ number_format($nominal_program,0,',','.') }}</small>
                                        <hr class="my-1">
                                    </div>
                                </td>
                                <td class="text-start">
                                    <div class="d-flex flex-column text-end">
                                        <a href="#" class="text-gray-800 text-hover-primary mb-1 fw-bold"> {{ number_format($persentase_nominal_prognosa,2,',','.')  }} % &nbsp;</a>
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
            <div class="col-xl-4">
                <div class="table-responsive">
                    <!--begin::Table-->
                    <table class="table table-striped table-hover align-middle table-row-dashed fs-6" id="tabel_master_data_program_lokasi">
                        <!--begin::Table head-->
                        <thead>
                            <!--begin::Table row-->
                            <tr class="text-center text-dark fw-bolder fs-7 text-uppercase gs-0">                                
                                <th>No.</th>
                                <th>Lokasi</th>
                                <th>Prognosa</th>
                                <th>&nbsp;%&nbsp;</th>
                            </tr>
                            <!--end::Table row-->
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody class="text-gray-600 fw-bold">
                            @foreach ($model['ms_program']->groupBy('id_program_lokasi_cc') as $program_jenis)
                            <tr>
                                @php
                                    $nominal_program = $program_jenis->sum('nominal');
                                    $nominal_prognosa_pr = $model['tr_progres_pr']->where('id_program_lokasi_cc', $program_jenis[0]->id_program_lokasi_cc)->sum('pr_nominal');
                                    $nominal_prognosa_po = $model['tr_progres_po']->where('id_program_lokasi_cc', $program_jenis[0]->id_program_lokasi_cc)->sum('po_nominal');
                                    $nominal_prognosa_gr = $model['tr_progres_gr']->where('id_program_lokasi_cc', $program_jenis[0]->id_program_lokasi_cc)->sum('gr_nominal');

                                    $total_nominal_prognosa = $nominal_prognosa_pr + $nominal_prognosa_po + $nominal_prognosa_gr;
                                    $persentase_nominal_prognosa = ( $total_nominal_prognosa / $nominal_program) * 100;
                                @endphp
                                <td class="text-center">
                                    <div class="position-relative py-2">
                                        <div class="position-absolute start-0 top-0 w-4px h-100 rounded-2 bg-success"></div>&nbsp;
                                        <a href="#" class="mb-1 text-dark text-hover-primary fw-bolder">{{ $loop->iteration }}</a>
                                    </div>
                                </td>
                                <td class="text-start">
                                    <div class="d-flex flex-column">
                                        <a href="#" class="text-gray-800 text-hover-primary mb-1 fw-bolder fs-5">{{ $program_jenis[0]->name_program_lokasi_cc }}</a>
                                        <small>{{ $program_jenis[0]->fund_center }}</small>
                                        <hr class="my-1">
                                    </div>
                                </td>
                                <td class="text-start">
                                    <div class="d-flex flex-column text-end">
                                        <a href="#" class="text-gray-800 text-hover-primary mb-1 fw-bold"> {{ number_format($total_nominal_prognosa,0,',','.')  }}</a>
                                        <small>{{ number_format($nominal_program,0,',','.') }}</small>
                                        <hr class="my-1">
                                    </div>
                                </td>
                                <td class="text-start">
                                    <div class="d-flex flex-column text-end">
                                        <a href="#" class="text-gray-800 text-hover-primary mb-1 fw-bold"> {{ number_format($persentase_nominal_prognosa,2,',','.')  }} % &nbsp;</a>
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
                    <table class="table table-striped table-hover align-middle table-row-dashed fs-6 gy-5" id="tabel_master_tr_prognosa">
                        <!--begin::Table head-->
                        <thead>
                            <!--begin::Table row-->
                            <tr class="text-center text-muted fw-bolder fs-7 text-uppercase gs-0">                                
                                <th class="text-center">No.</th>
                                <th class="text-center">Fund Number</th>
                                <th class="text-center">Program</th>
                                <th class="text-center">Anggaran</th>
                                <th class="text-center">MR / SR</th>
                                <th class="text-center">Realisasi</th>
                                <th class="text-center">Prognosa</th>
                                <th class="text-center">Sisa</th>
                            </tr>
                            <!--end::Table row-->
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody class="text-gray-600 fw-bold">
                            @foreach ($model['ms_program'] as $program)
                            <tr>
                                @php
                                    $nominal_pr = 0;
                                    if($program->trProgresProgramPRMany)
                                    {
                                        $data_tr_pr = $program->trProgresProgramPRMany->where('status', 1);

                                        if($model['tanggal_cut_off'])
                                        {
                                            $data_tr_pr = $data_tr_pr->where('pr_tanggal', '<', Carbon\Carbon::parse($model['tanggal_cut_off'])->subDays(224));
                                        }                 

                                        $nominal_pr = $data_tr_pr->sum('pr_nominal');
                                    }

                                    $nominal_po = 0;
                                    if($program->trProgresProgramPOMany)
                                    {
                                        $data_tr_po = $program->trProgresProgramPOMany->where('status', 1);

                                        if($model['tanggal_cut_off'])
                                        {
                                            $data_tr_po = $data_tr_po->where('po_tanggal', '<', Carbon\Carbon::parse($model['tanggal_cut_off'])->subDays(182));
                                        }                 

                                        $nominal_po = $data_tr_po->sum('pr_nominal');
                                    }

                                    $nominal_gr = 0;
                                    if($program->trProgresProgramGRMany)
                                    {
                                        $nominal_gr = $program->trProgresProgramGRMany->where('status', 1)->sum('gr_nominal');
                                    }
                                    $persentase_gr = ( $nominal_gr / $program->nominal ) * 100;

                                    $nominal_prognosa = $nominal_pr + $nominal_po + $nominal_gr;
                                    $persentase_prognosa = ( $nominal_prognosa / $program->nominal ) * 100;

                                    $nominal_sisaanggaran = $program->nominal - $nominal_prognosa;
                                    $persentase_sisa = ( $nominal_sisaanggaran / $program->nominal ) * 100;
                                @endphp

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
                                    <div class="d-flex flex-column">                    
                                        <a href="#" class="text-gray-800 text-hover-primary mb-1 fw-bolder fs-5">{{ number_format($nominal_gr,0,',','.') }}</a>
                                        <small>{{ number_format($persentase_gr,2,',','.') }} %</small>
                                        <hr>
                                    </div>
                                </td>
                                <td class="text-end">
                                    <div class="d-flex flex-column">                    
                                        <a href="#" class="text-gray-800 text-hover-primary mb-1 fw-bolder fs-5">{{ number_format($nominal_prognosa,0,',','.') }}</a>
                                        <small>{{ number_format($persentase_prognosa,2,',','.') }} %</small>
                                        <hr>
                                    </div>
                                </td>
                                <td class="text-end">
                                    <div class="d-flex flex-column">                    
                                        <a href="#" class="text-gray-800 text-hover-primary mb-1 fw-bolder fs-5">{{ number_format($nominal_sisaanggaran,0,',','.') }}</a>
                                        <small>{{ number_format($persentase_sisa,2,',','.') }} %</small>
                                        <hr>
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
        let tanggal_cut_off = "{{ $model['tanggal_cut_off'] }}";

        $("#form_filter_tanggal_cutoff").flatpickr({
            defaultDate: [tanggal_cut_off]
        });

        let total_program_prognosa = {{ $total_prognosa }};
        let total_program_anggaran_sisa = {{ $sisa_anggaran }};

    </script>

    <script src="{{ URL::asset('js/pages/dashboard_program_prognosa.js?version=') }}{{uniqid()}}"></script>

@endsection