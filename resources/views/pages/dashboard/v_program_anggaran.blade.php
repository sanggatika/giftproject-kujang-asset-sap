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
                <label class="form-label fw-bold"> Dashboard Pendapatan - {{ Carbon\Carbon::now('Asia/Jakarta')->locale('id')->isoFormat('HH:mm:ss') }}</label>
                <!--end::Label-->
                <h2 class="fw-bold mt-2">{{ Carbon\Carbon::now('Asia/Jakarta')->locale('id')->isoFormat('dddd, D
                    MMMM Y') }}</h2>
                <h2 class="fw-bold" id="time"></h2>
            </div>
            <!--end::Col-->

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
            <div class="col-xl-6">
                <!--begin::Card widget 3-->
                <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-xl-100" style="background-color: #7239EA;background-image:url({{ URL::asset('media/svg/shapes/wave-bg-purple.svg') }})">
                        
                    <div class="card-header" style="border-bottom: 1px solid rgba(255, 255, 255, 0.3);background: rgba(0, 0, 0, 0.15);">
                        <!--begin::Progress-->
                        <div class="fw-bold text-white text-hover-dark py-2">
                            <span class="fs-1 d-block">Total Anggaran Program</span>
                            <span class="opacity-50 update_tanggal_conten">Tahun Anggaran 2024</span>
                        </div>
                        <!--end::Progress-->
                    </div>

                    <!--begin::Card body-->
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-center text-center">
                            <h1 class="text-white text-hover-dark lh-base fw-bold fs-lg-4x mb-2">
                                <b id="data_line2_total_program_anggaran">Rp. {{  number_format($model['ms_program']->sum('nominal'),0,',','.') }}</b>
                            </h1>
                        </div>
                        <div class="separator separator-dashed my-3"></div>

                    </div>
                    <!--end::Card body-->

                    <!--begin::Card footer-->
                    <div class="card-footer" style="border-top: 1px solid rgba(255, 255, 255, 0.3);background: rgba(0, 0, 0, 0.15);">
                        
                    </div>
                    <!--end::Card footer-->

                </div>
                <!--end::Card widget 3-->                            
            </div>
            <!--end::Col--> 

            <!--begin::Col-->
            <div class="col-xl-3">
                <!--begin::Card widget 3-->
                <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-xl-100">
                    <!--begin::Card body-->
                    <div class="card-body">
                        
                        <!--begin::Item-->
                        <div class="d-flex flex-stack mt-5">
                            <!--begin::Section-->
                            <a href="#" class="text-primary fw-semibold fs-6 me-2">AMMONIA 1A</a>
                            <!--end::Section-->
                            <!--begin::Action-->
                            <b class="fw-bold fs-5">{{  number_format($model['ms_program']->where('id_program_lokasi_cc', 1)->sum('nominal'),0,',','.') }}</b>
                            <!--end::Action-->
                        </div>
                        <!--end::Item-->

                        <!--begin::Separator-->
                        <div class="separator separator-dashed my-3"></div>
                        <!--end::Separator-->

                        <!--begin::Item-->
                        <div class="d-flex flex-stack">
                            <!--begin::Section-->
                            <a href="#" class="text-primary fw-semibold fs-6 me-2">AMMONIA 1B</a>
                            <!--end::Section-->
                            <!--begin::Action-->
                            <b class="fw-bold fs-5">{{  number_format($model['ms_program']->where('id_program_lokasi_cc', 2)->sum('nominal'),0,',','.') }}</b>
                            <!--end::Action-->
                        </div>
                        <!--end::Item-->

                        <!--begin::Separator-->
                        <div class="separator separator-dashed my-3"></div>
                        <!--end::Separator-->

                        <!--begin::Item-->
                        <div class="d-flex flex-stack">
                            <!--begin::Section-->
                            <a href="#" class="text-primary fw-semibold fs-6 me-2">BAGGING</a>
                            <!--end::Section-->
                            <!--begin::Action-->
                            <b class="fw-bold fs-5">{{  number_format($model['ms_program']->where('id_program_lokasi_cc', 3)->sum('nominal'),0,',','.') }}</b>
                            <!--end::Action-->
                        </div>
                        <!--end::Item-->

                        <!--begin::Separator-->
                        <div class="separator separator-dashed my-3"></div>
                        <!--end::Separator-->

                        <!--begin::Item-->
                        <div class="d-flex flex-stack">
                            <!--begin::Section-->
                            <a href="#" class="text-primary fw-semibold fs-6 me-2">LUAR PABRIK</a>
                            <!--end::Section-->
                            <!--begin::Action-->
                            <b class="fw-bold fs-5">{{  number_format($model['ms_program']->where('id_program_lokasi_cc', 4)->sum('nominal'),0,',','.') }}</b>
                            <!--end::Action-->
                        </div>
                        <!--end::Item-->

                        <!--begin::Separator-->
                        <div class="separator separator-dashed my-3"></div>
                        <!--end::Separator-->

                        <!--begin::Item-->
                        <div class="d-flex flex-stack">
                            <!--begin::Section-->
                            <a href="#" class="text-primary fw-semibold fs-6 me-2">NPKG-1</a>
                            <!--end::Section-->
                            <!--begin::Action-->
                            <b class="fw-bold fs-5">{{  number_format($model['ms_program']->where('id_program_lokasi_cc', 5)->sum('nominal'),0,',','.') }}</b>
                            <!--end::Action-->
                        </div>
                        <!--end::Item-->

                        <!--begin::Separator-->
                        <div class="separator separator-dashed my-3"></div>
                        <!--end::Separator-->

                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card widget 3-->                            
            </div>
            <!--end::Col-->

            <!--begin::Col-->
            <div class="col-xl-3">
                <!--begin::Card widget 3-->
                <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-xl-100">
                    <!--begin::Card body-->
                    <div class="card-body">
                        
                        <!--begin::Item-->
                        <div class="d-flex flex-stack mt-5">
                            <!--begin::Section-->
                            <a href="#" class="text-primary fw-semibold fs-6 me-2">NPKG-2</a>
                            <!--end::Section-->
                            <!--begin::Action-->
                            <b class="fw-bold fs-5">{{  number_format($model['ms_program']->where('id_program_lokasi_cc', 6)->sum('nominal'),0,',','.') }}</b>
                            <!--end::Action-->
                        </div>
                        <!--end::Item-->

                        <!--begin::Separator-->
                        <div class="separator separator-dashed my-3"></div>
                        <!--end::Separator-->

                        <!--begin::Item-->
                        <div class="d-flex flex-stack">
                            <!--begin::Section-->
                            <a href="#" class="text-primary fw-semibold fs-6 me-2">UREA 1A</a>
                            <!--end::Section-->
                            <!--begin::Action-->
                            <b class="fw-bold fs-5">{{  number_format($model['ms_program']->where('id_program_lokasi_cc', 7)->sum('nominal'),0,',','.') }}</b>
                            <!--end::Action-->
                        </div>
                        <!--end::Item-->

                        <!--begin::Separator-->
                        <div class="separator separator-dashed my-3"></div>
                        <!--end::Separator-->

                        <!--begin::Item-->
                        <div class="d-flex flex-stack">
                            <!--begin::Section-->
                            <a href="#" class="text-primary fw-semibold fs-6 me-2">UREA 1B</a>
                            <!--end::Section-->
                            <!--begin::Action-->
                            <b class="fw-bold fs-5">{{  number_format($model['ms_program']->where('id_program_lokasi_cc', 8)->sum('nominal'),0,',','.') }}</b>
                            <!--end::Action-->
                        </div>
                        <!--end::Item-->

                        <!--begin::Separator-->
                        <div class="separator separator-dashed my-3"></div>
                        <!--end::Separator-->

                        <!--begin::Item-->
                        <div class="d-flex flex-stack">
                            <!--begin::Section-->
                            <a href="#" class="text-primary fw-semibold fs-6 me-2">UTILITY 1A</a>
                            <!--end::Section-->
                            <!--begin::Action-->
                            <b class="fw-bold fs-5">{{  number_format($model['ms_program']->where('id_program_lokasi_cc', 9)->sum('nominal'),0,',','.') }}</b>
                            <!--end::Action-->
                        </div>
                        <!--end::Item-->

                        <!--begin::Separator-->
                        <div class="separator separator-dashed my-3"></div>
                        <!--end::Separator-->

                        <!--begin::Item-->
                        <div class="d-flex flex-stack">
                            <!--begin::Section-->
                            <a href="#" class="text-primary fw-semibold fs-6 me-2">UTILITY 1B</a>
                            <!--end::Section-->
                            <!--begin::Action-->
                            <b class="fw-bold fs-5">{{  number_format($model['ms_program']->where('id_program_lokasi_cc', 10)->sum('nominal'),0,',','.') }}</b>
                            <!--end::Action-->
                        </div>
                        <!--end::Item-->

                        <!--begin::Separator-->
                        <div class="separator separator-dashed my-3"></div>
                        <!--end::Separator-->

                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card widget 3-->                            
            </div>
            <!--end::Col-->

            <!--begin::Col-->
            <div class="col-xl-12">
                <div class="table-responsive">
                    <!--begin::Table-->
                    <table class="table table-striped table-hover align-middle table-row-dashed fs-6 gy-5" id="tabel_master_data">
                        <!--begin::Table head-->
                        <thead>
                            <!--begin::Table row-->
                            <tr class="text-center text-dark fw-bolder fs-7 text-uppercase gs-0">                                
                                <th>No.</th>
                                <th>Fund Number</th>
                                <th>Program</th>
                                <th>Jenis</th>
                                <th>Lokasi</th>
                                <th>Priority</th>
                                <th>Nominal</th>
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
                                    <div class="d-flex flex-column text-center">
                                        <a href="#" class="text-gray-800 text-hover-primary mb-1 fw-bold">{{ $program->fund_number  }}</a>
                                    </div>
                                </td>
                                <td class="text-start">
                                    <div class="d-flex flex-column">
                                        <a href="#" class="text-gray-800 text-hover-primary mb-1 fw-bolder fs-5">{{ $program->name }}</a>
                                        <small>{{ $program->code }}</small>
                                        <hr>
                                    </div>
                                </td>
                                <td class="text-start">
                                    <div class="d-flex flex-column">
                                        <a href="#" class="text-gray-800 text-hover-primary mb-1 fw-bolder fs-5">{{ $program->name_program_jenis_cck }}</a>
                                        <small>{{ $program->fund_center }}</small>
                                        <hr>
                                    </div>
                                </td>
                                <td class="text-start">
                                    <div class="d-flex flex-column">
                                        <a href="#" class="text-gray-800 text-hover-primary mb-1 fw-bold">{{ $program->name_program_lokasi_cc  }}</a>
                                    </div>
                                </td>
                                <td class="text-start">
                                    <div class="d-flex flex-column text-center">
                                        <a href="#" class="text-gray-800 text-hover-primary mb-1 fw-bold">{{ strtoupper($program->priority)  }}</a>
                                    </div>
                                </td>
                                <td class="text-start">
                                    <div class="d-flex flex-column text-end">
                                        <a href="#" class="text-gray-800 text-hover-primary mb-1 fw-bold">{{ number_format($program->nominal,0,',','.')  }} &nbsp;</a>
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
            <div class="col-xl-8">
                <div class="mb-5">
                    <div class="d-flex flex-stack">
                        <div class="fw-bolder fs-4">Chart Garafik Program Jenis CCK
                            <span class="fs-6 text-gray-400 ms-2"></span>
                        </div>
                        <!--begin::Menu-->
                        <div>
                            <button type="button" class="btn btn-sm btn-icon btn-color-light-dark btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                <!--begin::Svg Icon | path: icons/duotune/general/gen024.svg-->
                                <span class="svg-icon svg-icon-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="5" y="5" width="5" height="5" rx="1" fill="#000000"></rect>
                                            <rect x="14" y="5" width="5" height="5" rx="1" fill="#000000" opacity="0.3"></rect>
                                            <rect x="5" y="14" width="5" height="5" rx="1" fill="#000000" opacity="0.3"></rect>
                                            <rect x="14" y="14" width="5" height="5" rx="1" fill="#000000" opacity="0.3"></rect>
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

                <div id="line4_grafik_program_jenis"></div>  

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
                                <th>Nominal</th>
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
                                        <hr>
                                    </div>
                                </td>
                                <td class="text-start">
                                    <div class="d-flex flex-column text-end">
                                        <a href="#" class="text-gray-800 text-hover-primary mb-1 fw-bold"> {{ number_format($program_jenis->sum('nominal'),0,',','.')  }} &nbsp;</a>
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
        let program_jenis_name = ["A2B","BENGKEL","DRB","GUDANG","HAP","INSPEKSI","INSPEKSI + MEK 1A","INSPEKSI + MEK 1B","INSTRUMEN","LAB","LISTRIK","MEK 1A","MEK 1B","MEK PNPK","PEMASARAN","RANCANG BANGUN","RISET","TEKBANG","TIK","UMUM","WLI"];

        var program_jenis_nominal = [
            {{ $model['ms_program']->where('id_program_jenis_cck', 1)->sum('nominal') }},
            {{ $model['ms_program']->where('id_program_jenis_cck', 2)->sum('nominal') }},
            {{ $model['ms_program']->where('id_program_jenis_cck', 3)->sum('nominal') }},
            {{ $model['ms_program']->where('id_program_jenis_cck', 4)->sum('nominal') }},
            {{ $model['ms_program']->where('id_program_jenis_cck', 5)->sum('nominal') }},
            {{ $model['ms_program']->where('id_program_jenis_cck', 6)->sum('nominal') }},
            {{ $model['ms_program']->where('id_program_jenis_cck', 7)->sum('nominal') }},
            {{ $model['ms_program']->where('id_program_jenis_cck', 8)->sum('nominal') }},
            {{ $model['ms_program']->where('id_program_jenis_cck', 9)->sum('nominal') }},
            {{ $model['ms_program']->where('id_program_jenis_cck', 10)->sum('nominal') }},
            {{ $model['ms_program']->where('id_program_jenis_cck', 11)->sum('nominal') }},
            {{ $model['ms_program']->where('id_program_jenis_cck', 12)->sum('nominal') }},
            {{ $model['ms_program']->where('id_program_jenis_cck', 13)->sum('nominal') }},
            {{ $model['ms_program']->where('id_program_jenis_cck', 14)->sum('nominal') }},
            {{ $model['ms_program']->where('id_program_jenis_cck', 15)->sum('nominal') }},
            {{ $model['ms_program']->where('id_program_jenis_cck', 16)->sum('nominal') }},
            {{ $model['ms_program']->where('id_program_jenis_cck', 17)->sum('nominal') }},
            {{ $model['ms_program']->where('id_program_jenis_cck', 18)->sum('nominal') }},
            {{ $model['ms_program']->where('id_program_jenis_cck', 19)->sum('nominal') }},
            {{ $model['ms_program']->where('id_program_jenis_cck', 20)->sum('nominal') }},
            {{ $model['ms_program']->where('id_program_jenis_cck', 21)->sum('nominal') }}
        ];

    </script>
    <script src="{{ URL::asset('js/pages/dashboard_program_anggaran.js?version=') }}{{uniqid()}}"></script>

@endsection