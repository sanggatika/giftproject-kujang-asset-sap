@extends('layouts/adminLayoutMaster')

@section('title', '- Transaksi Progres Program - Good Receipt (GR) - Realisasi')

@section('page-style')
    <!-- Current Page CSS Costum -->
    <style>
        .dataContenFormPR {
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
            <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Transaksi Progres Program - Good Receipt (GR) - Realisasi</h1>
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
                <li class="breadcrumb-item text-muted">Progres Program - Good Receipt (GR) - Realisasi</li>
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
            <button type="button" class="btn btn-sm fw-bold btn-primary" onclick="btn_tambahMasterdata()">
                <i class="bi bi-clipboard-plus fs-4 me-2"></i>
                Tambah Good Receipt (GR)
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

            <div class="col-12 col-lg-12 col-md-12">

            </div>                       

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
                                        <th class="text-center">Purchase Requisition</th>
                                        <th class="text-center">Purchase Order</th>                                        
                                        <th class="text-center">Good Receipt</th>
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

<div class="modal fade" id="modal-masterdata-program" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" data-bs-focus="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Data Form Progres Program - Good Receipt (GR) - Realisasi</h5>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <span class="svg-icon svg-icon-2x"></span>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body">
                <form id="form-masterdata-progra" class="form" action="#" method="POST" enctype="multipart/form-data" autocomplete="off">
                    <div class="row">
                        <div class="col-md-12 mb-10 mt-5">
                            <div class="separator separator-dotted separator-content border-success my-2">
                                <img src="{{ asset('images/pupuk-indonesia-hitam.png') }}" style="max-height: 75px;" class="img-fluid" alt="logo-pssi">
                            </div>
                        </div>  
                        <div class="col-md-6">
                            <div class="form-group mb-1">
                                <!--begin::Label-->
                                <label class="form-label fw-bold">Nomor Purchase Order (PO) :</label>
                                <!--end::Label-->
        
                                <!--begin::Input group-->                                
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="input-group mb-2">
                                            <span class="input-group-text" id="basic-addon1">
                                                <i class="bi bi-stickies fs-1"></i>
                                            </span>
                                            <input type="text" class="form-control" name="form_masterdata_program_po_nomor" id="form_masterdata_program_po_nomor" placeholder="Nomor Purchase Order (PO)" aria-label="Nomor Purchase Order (PO)" value="" aria-describedby="basic-addon1"/>
                                        </div>                                            
                                    </div>
                                    <div class="col-md-4">
                                        <a href="#" class="btn btn-primary" id="btn_syncMasterData" onclick="sync_masterdata()"><i class="bi bi-chat-square-text-fill fs-4 me-2"></i> Sync</a>
                                    </div>
                                </div>  
                                <!--end::Input group-->        
                            </div>

                            <div class="form-group mb-3">
                                <!--begin::Label-->
                                <label class="form-label fw-bold">Program Jenis CCK : </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select class="form-select mb-2" name="form_masterdata_program_jenis" id="form_masterdata_program_jenis"  data-control="select2" data-placeholder="Select an option" data-dropdown-parent="#modal-masterdata-program" disabled>
                                    <option value="-">-- Program Jenis CCK -- </option> 
                                    @foreach ($model['ms_program_jenis_cck'] as $program_jenis_cck)
                                        <option value="{{$program_jenis_cck->uuid}}">{{$program_jenis_cck->name}}</option>
                                    @endforeach                             
                                </select>
                                <!--end::Input-->
                            </div>  

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="required fs-6 fw-bold mb-2">Tanggal PO</label>
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
                                            <input class="form-control ps-12" placeholder="Select a date" value="{{date('Y-m-d')}}" placeholder="{{date('Y-m-d')}}" id="form_masterdata_program_po_tanggal" name="form_masterdata_program_po_tanggal" disabled/>
                                            <!--end::Datepicker-->
                                        </div>
                                        <!--end::Input-->
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="required fs-6 fw-bold mb-2">Tanggal Estimasi</label>
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
                                            <input class="form-control ps-12" placeholder="Select a date" value="{{date('Y-m-d')}}" placeholder="{{date('Y-m-d')}}" id="form_masterdata_program_po_tanggal_estimasi" name="form_masterdata_program_po_tanggal_estimasi" disabled/>
                                            <!--end::Datepicker-->
                                        </div>
                                        <!--end::Input-->
                                    </div>
                                </div>
                            </div>
                            

                        </div>  
                        
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <!--begin::Label-->
                                <label class="form-label fw-bold">Nama Program :</label>
                                <!--end::Label-->
        
                                <!--begin::Input group-->
                                <div class="input-group mb-2">
                                    <span class="input-group-text" id="basic-addon1">
                                        <i class="bi bi-boxes fs-1"></i>
                                    </span>
                                    <input type="text" class="form-control" name="form_masterdata_program_nama" id="form_masterdata_program_nama" placeholder="Nama Program" aria-label="Nama Program" value="" aria-describedby="basic-addon1" disabled/>
                                    <input type="hidden" class="form-control" name="form_masterdata_program_po_uuid" id="form_masterdata_program_po_uuid" value="" aria-describedby="basic-addon1"/>
                                </div>
                                <!--end::Input group-->        
                            </div>                               
                            
                            <div class="form-group mb-3">
                                <!--begin::Label-->
                                <label class="form-label fw-bold">Program Lokasi CC : </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select class="form-select mb-2" name="form_masterdata_program_lokasi" id="form_masterdata_program_lokasi"  data-control="select2" data-placeholder="Select an option" data-dropdown-parent="#modal-masterdata-program" disabled>
                                    <option value="-">-- Program Lokasi CC -- </option> 
                                    @foreach ($model['ms_program_lokasi_cc'] as $program_lokasi_cc)
                                        <option value="{{$program_lokasi_cc->uuid}}">{{$program_lokasi_cc->name}}</option>
                                    @endforeach                             
                                </select>
                                <!--end::Input-->
                            </div>

                            <div class="form-group mb-3">
                                <!--begin::Label-->
                                <label class="form-label fw-bold">Anggaran Purchase Order (PO)</label>
                                <!--end::Label-->

                                <!--begin::Input group-->
                                <div class="input-group mb-2">
                                    <span class="input-group-text fw-bold" id="basic-addon1">
                                        Rp.
                                    </span>
                                    <input type="number" class="form-control" name="form_masterdata_program_po_nominal" id="form_masterdata_program_po_nominal" placeholder="Anggaran Purchase Order (PO)" aria-label="Anggaran Purchase Order (PO)" value="" aria-describedby="basic-addon1" disabled/>
                                </div>
                                <!--end::Input group-->
                            </div>
                        </div>

                        <div class="col-md-12">
                            <hr>
                        </div>

                        <div class="col-md-4 dataContenFormPR">
                            <div class="form-group mb-3">
                                <label class="required fs-6 fw-bold mb-2">Tanggal Good Receipt (GR)</label>
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
                                    <input class="form-control ps-12" placeholder="Select a date" value="{{date('Y-m-d')}}" placeholder="{{date('Y-m-d')}}" id="form_masterdata_program_gr_tanggal" name="form_masterdata_program_gr_tanggal"/>
                                    <!--end::Datepicker-->
                                </div>
                                <!--end::Input-->
                            </div>
                        </div>

                        <div class="col-md-4 dataContenFormPR">
                            <div class="form-group mb-3">
                                <div class="form-group mb-3">
                                    <!--begin::Label-->
                                    <label class="form-label fw-bold">Nomor Good Receipt (GR) :</label>
                                    <!--end::Label-->
            
                                    <!--begin::Input group-->
                                    <div class="input-group mb-2">
                                        <span class="input-group-text" id="basic-addon1">
                                            <i class="bi bi-grid fs-1"></i>
                                        </span>
                                        <input type="text" class="form-control" name="form_masterdata_program_gr_nomor" id="form_masterdata_program_gr_nomor" placeholder="Nomor Good Receipt (GR)" aria-label="Nomor Good Receipt (GR)" value="" aria-describedby="basic-addon1"/>
                                    </div>
                                    <!--end::Input group-->        
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 dataContenFormPR">
                            <div class="form-group mb-3">
                                <!--begin::Label-->
                                <label class="form-label fw-bold">Anggaran Good Receipt (GR):</label>
                                <!--end::Label-->

                                <!--begin::Input group-->
                                <div class="input-group mb-2">
                                    <span class="input-group-text fw-bold" id="basic-addon1">
                                        Rp.
                                    </span>
                                    <input type="number" class="form-control" name="form_masterdata_program_gr_anggaran" id="form_masterdata_program_gr_anggaran" placeholder="Anggaran Good Receipt (GR)" aria-label="Anggaran Good Receipt (GR)" value="" aria-describedby="basic-addon1"/>
                                </div>
                                <!--end::Input group-->
                            </div>
                        </div>
                                               

                        <div class="col-md-12">
                            <div class="d-flex float-md-end">
                                <button type="button" class="btn btn-primary mt-2" id="btnTambahMasterdata" onclick="act_submitTambahData()">
                                    <span class="indicator-label"><i class="bi bi-clipboard-plus fs-2 me-2"></i> Tambah Good Receipt (GR)</span>
                                </button>

                                <button type="button" class="btn btn-primary mt-2" id="btnUpdateMasterdata" onclick="act_sumbitUpdateData()">
                                    <span class="indicator-label"><i class="bi bi-clipboard-check fs-2 me-2"></i> Update Progres</span>
                                </button>
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

    <script>
        var data_tr_program_progres_po = null;
    </script>
    
    <script src="{{ URL::asset('js/pages/tr_progres_program_gr.js?version=') }}{{uniqid()}}"></script>

@endsection