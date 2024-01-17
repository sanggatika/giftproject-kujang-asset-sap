@extends('layouts/adminLayoutMaster')

@section('title', 'Management Menu')

@section('page-style')
    <!-- Current Page CSS Costum -->
    <script src="https://unpkg.com/@yaireo/tagify"></script>
    <script src="https://unpkg.com/@yaireo/tagify@3.1.0/dist/tagify.polyfills.min.js"></script>
    <link href="https://unpkg.com/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')

<!--begin::Content-->
<div id="kt_app_content" class="app-content flex-column-fluid mt-5">
    <!--begin::Content container-->
    <div id="kt_app_content_container" class="app-container container-fluid">
        
        <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed mb-5 p-6">
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
                    <h4 class="text-gray-900 fw-bold">Data Management Menu</h4>
                    <div class="fs-6 text-gray-700">Keterangan : Menu yang dijadikan parent menjadi menu drop down tidak dapat di klik.</div>
                </div>
                <!--end::Content-->
            </div>
            <!--end::Wrapper-->
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="mb-5">
                    <div class="d-flex flex-stack">
                        <div class="fw-bolder fs-4">Tambah Data Menu
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
                <div class="card shadow-sm">
                    <div class="card-body">
                        <!--begin::Alert-->
                        <div id="card_alert_informasi" style="display:none">
                            <div class="alert alert-danger d-flex align-items-center p-2">
                                <!--begin::Icon-->
                                <span class="svg-icon svg-icon-2hx svg-icon-danger me-3">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.3" d="M20.5543 4.37824L12.1798 2.02473C12.0626 1.99176 11.9376 1.99176 11.8203 2.02473L3.44572 4.37824C3.18118 4.45258 3 4.6807 3 4.93945V13.569C3 14.6914 3.48509 15.8404 4.4417 16.984C5.17231 17.8575 6.18314 18.7345 7.446 19.5909C9.56752 21.0295 11.6566 21.912 11.7445 21.9488C11.8258 21.9829 11.9129 22 12.0001 22C12.0872 22 12.1744 21.983 12.2557 21.9488C12.3435 21.912 14.4326 21.0295 16.5541 19.5909C17.8169 18.7345 18.8277 17.8575 19.5584 16.984C20.515 15.8404 21 14.6914 21 13.569V4.93945C21 4.6807 20.8189 4.45258 20.5543 4.37824Z" fill="currentColor"/>
                                        <rect x="9" y="13.0283" width="7.3536" height="1.2256" rx="0.6128" transform="rotate(-45 9 13.0283)" fill="currentColor"/>
                                        <rect x="9.86664" y="7.93359" width="7.3536" height="1.2256" rx="0.6128" transform="rotate(45 9.86664 7.93359)" fill="currentColor"/>
                                    </svg>
                                </span>
                                <!--end::Icon-->
                
                                <!--begin::Wrapper-->
                                <div class="d-flex flex-column">
                                    <!--begin::Title-->
                                    <h4 class="mb-1 text-dark">This is an alert</h4>
                                    <!--end::Title-->
                                    <!--begin::Content-->
                                    <span id="alert_informasi">The alert component can be used to highlight</span>
                                    <!--end::Content-->
                                </div>
                                <!--end::Wrapper-->
                            </div>
                        </div>            
                        <!--end::Alert-->

                        <form id="form_management_menu" class="form" action="#" method="POST" enctype="multipart/form-data" autocomplete="off">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="w-100">
                                        <!--begin::Label-->
                                        <label class="required form-label">Grup Menu</label>
                                        <!--end::Label-->
                                        <!--begin::Select2-->
                                        <select class="form-select mb-2" name="form_menu_grup" id="form_menu_grup" data-control="select2" data-placeholder="Select an option">
                                            <option value="-">-- Pilih Grup Menu -- </option>
                                            @foreach ($model['MsMenuGrup'] as $grup_menu)
                                                <option value="{{$grup_menu->uuid}}">{{$grup_menu->nama}}</option>
                                            @endforeach      
                                        </select>
                                        <!--end::Select2-->
                                        <!--begin::Description-->
                                        {{-- <div class="text-muted fs-7">Set the product tax class.</div> --}}
                                        <!--end::Description-->
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="w-100">
                                        <!--begin::Label-->
                                        <label class="form-label">Parent Menu</label>
                                        <!--end::Label-->
                                        <!--begin::Select2-->
                                        <select class="form-select mb-2" name="form_menu_parent" id="form_menu_parent" data-control="select2" data-placeholder="Select an option">
                                            <option value="-">-- Pilih Parent Menu -- </option>
                                            @foreach ($model['MsMenu']->where('menu_parent', 0) as $menu)
                                                <option value="{{$menu->menu_uuid}}">{{$menu->menu_title}}</option>
                                            @endforeach
                                        </select>
                                        <!--end::Select2-->
                                        <!--begin::Description-->
                                        {{-- <div class="text-muted fs-7">Set the product tax class.</div> --}}
                                        <!--end::Description-->
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-2 fv-row">
                                        <!--begin::Label-->
                                        <label class="required form-label">Nama Menu</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" name="form_menu_nama" id="form_menu_nama" class="form-control mb-2" placeholder="Nama Menu" value="" />
                                        <!--end::Input-->
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-2 fv-row">
                                        <!--begin::Label-->
                                        <label class="form-label">Icon Menu <a href="https://icons.getbootstrap.com/" target="_blank">Get Bootstrap Icons</a></label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" name="form_menu_icon" id="form_menu_icon" class="form-control mb-2" placeholder="Icon Menu" value="" />
                                        <!--end::Input-->
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-2 fv-row">
                                        <!--begin::Label-->
                                        <label class="required form-label">URI Menu</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" name="form_menu_uri" id="form_menu_uri" class="form-control mb-2" placeholder="URI Menu" value="" />
                                        <!--end::Input-->
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-2 fv-row">
                                        <!--begin::Label-->
                                        <label class="required form-label">Route Name Menu <small> (Dapat Lebih Dari Satu)</small> </label>
                                        <!--end::Label-->

                                        <!--begin::Input group-->
                                        <div class="input-group mb-2">
                                            <span class="input-group-text" id="basic-addon1">
                                                <i class="bi bi-hash fs-1"></i>
                                            </span>
                                            <input type="text" class="form-control" name="form_menu_routename" id="form_menu_routename" placeholder="Route Name Menu" aria-label="Route Name Menu" value="" aria-describedby="basic-addon1"/>
                                        </div>
                                        <!--end::Input group-->   
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <!--end::Input group=-->
                                    <div class="fv-row mb-3">
                                        <strong>ReCaptcha:</strong>
                                        <div class="g-recaptcha" data-sitekey="{{ env('GOOGLE_RECAPTCHA_KEY') }}"></div>
                                        @if ($errors->has('g-recaptcha-response'))
                                            <span class="text-danger">{{ $errors->first('g-recaptcha-response') }}</span>
                                        @endif
                                    </div>
                                    <!--end::Input group=-->
                                </div>

                                <div class="col-md-12">
                                    <div class="d-flex justify-content-end mt-5">
                                        <!--begin::Submit button-->
                                        <div class="d-grid mb-10">
                                            <button type="submit" id="btnSubmitTambahData" class="btn btn-primary">
                                                <!--begin::Indicator label-->
                                                <span class="indicator-label"><i class="bi bi-check2-all fs-4 me-2"></i> Kirim Data</span>
                                                <!--end::Indicator label-->
                                                <!--begin::Indicator progress-->
                                                <span class="indicator-progress">Please wait...
                                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                <!--end::Indicator progress-->
                                            </button>
                                        </div>
                                        <!--end::Submit button-->
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <!--begin::Title-->
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bold text-dark">Show Data List Menu</span>
                            <span class="text-gray-400 mt-1 fw-semibold fs-6">Tampilan Menu Aplikasi</span>
                        </h3>
                        <!--end::Title-->                            
                    </div>
                    <div class="card-body">
                        
                        @if ($model['MsMenu'])
                            @foreach ($model['MsMenu']->groupBy('menu_grup_id') as $grup_menu)
                                <!--begin:Menu item-->
                                <div class="menu-item pt-2">
                                    <!--begin:Menu content-->
                                    <div class="menu-content">
                                        <span class="menu-heading fw-bold text-uppercase text-warning fs-6">{{ $grup_menu[0]->menu_grup_nama }}</span>
                                    </div>
                                    <!--end:Menu content-->
                                </div>
                                <!--end:Menu item-->

                                
                                @foreach ($model['MsMenu']->where('menu_parent', 0)->where('menu_grup_id',$grup_menu[0]->menu_grup_id)->sortBy('menu_sort') as $menu)
                                <ul class="list-group list-group-bordered my-2">
                                    <li class="list-group-item d-flex align-items-center justify-content-between active">
                                        <div>
                                            <span class="menu-icon">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen019.svg-->
                                                <span class="svg-icon svg-icon-2">
                                                    {!!$menu->menu_icon!!}
                                                </span>
                                                <!--end::Svg Icon-->
                                            </span>
                                            &nbsp; <b @if ($menu->menu_status == 0) class="text-danger" @endif>{{ $menu->menu_title }} {{ $menu->menu_status == 0 ? '(In-Aktif)' : '' }}</b>
                                        </div>
                                        <div>
                                            <button class="btn btn-sm bg-white rounded-full" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-dark" data-bs-placement="top" title="Edit Menu" onclick="editManagementMenu('{{ $menu->menu_uuid }}')">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm bg-white rounded-full" onclick="aktifManagementMenu('{{ $menu->menu_uuid }}','{{ $menu->menu_status }}')" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-dark" data-bs-placement="top" title="{{ $menu->menu_status == 0 ? 'Aktif Menu' : 'In-Aktif Menu' }}">
                                                <i class="fa {{ $menu->menu_status == 0 ? 'fa-eye text-info' : 'fa-eye-slash text-danger' }}"></i>
                                            </button>
                                            <button {{ $loop->first ? 'disabled' : '' }} class="btn btn-sm bg-white rounded-full changePos" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-dark" data-bs-placement="top" title="Up menu" onclick="sortManagementMenu('{{ $menu->menu_uuid }}','up')">
                                                <i class="fa fa-chevron-up text-warning"></i>
                                            </button>
                                            <button {{ $loop->last ? 'disabled' : '' }} class="btn btn-sm bg-white rounded-full changePos" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-dark" data-bs-placement="top" title="Down menu" onclick="sortManagementMenu('{{ $menu->menu_uuid }}','down')">
                                                <i class="fa fa-chevron-down text-warning"></i>
                                            </button>
                                        </div>
                                    </li>
                                    @foreach ($model['MsMenu']->where('menu_parent', $menu->id)->sortBy('menu_sort') as $submenu)                                                
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center">
                                                <div class="me-3 ms-10">
                                                    <h1><i class="fa fa-long-arrow-alt-right"></i></h1>
                                                </div>
                                                <div>
                                                    <p>
                                                        <b @if ($submenu->menu_status == 0) class="text-danger" @endif>{{ $submenu->menu_title }} {{ $submenu->menu_status == 0 ? '(In-Aktif)' : '' }}</b>
                                                        <br>
                                                        Path : <b class="text-muted">{{ $submenu->menu_url }}</b>
                                                    </p>
                                                </div>
                                            </div>
                                            <div>
                                                <button class="btn btn-sm btn-success rounded-full" title="Edit Menu" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-dark" data-bs-placement="top" onclick="editManagementMenu('{{ $submenu->menu_uuid }}')">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm {{ $submenu->menu_status == 0 ? 'btn-info' : 'btn-danger' }} rounded-full" onclick="aktifManagementMenu('{{ $submenu->menu_uuid }}','{{ $submenu->menu_status }}')" title="{{ $submenu->menu_status == 0 ? 'Aktif Menu' : 'In-Aktif Menu' }}" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-dark" data-bs-placement="top">
                                                    <i class="fa {{ $submenu->menu_status == 0 ? 'fa-eye' : 'fa-eye-slash' }}"></i>
                                                </button>
                                                <button {{ $loop->first ? 'disabled' : '' }} class="btn btn-sm btn-primary rounded-full" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-dark" data-bs-placement="top" title="Up sub-menu" onclick="sortManagementMenu('{{ $submenu->menu_uuid }}','up')">
                                                    <i class="fa fa-chevron-up text-warning"></i>
                                                </button>
                                                <button {{ $loop->last ? 'disabled' : '' }} class="btn btn-sm btn-primary rounded-full" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-dark" data-bs-placement="top" title="Down sub-menu" onclick="sortManagementMenu('{{ $submenu->menu_uuid }}','down')">
                                                    <i class="fa fa-chevron-down text-warning"></i>
                                                </button>
                                            </div>
                                        </li>
                                    @endforeach 
                                </ul>
                                @endforeach
                                
                            @endforeach
                        @endif
                        

                        <!--begin:Menu item-->
                        <div class="menu-item pt-2">
                            <!--begin:Menu content-->
                            <div class="menu-content">
                                <span class="menu-heading fw-bold text-uppercase text-warning fs-6">LAINNYA</span>
                            </div>
                            <!--end:Menu content-->
                        </div>
                        <!--end:Menu item-->

                        <ul class="list-group list-group-bordered my-3">
                            <li class="list-group-item d-flex align-items-center justify-content-between active">
                                <div>
                                    <span class="menu-icon">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen019.svg-->
                                        <span class="svg-icon svg-icon-2">
                                            <i class="bi bi-person-circle text-white fs-3 me-2"></i>
                                        </span>
                                        <!--end::Svg Icon-->
                                    </span>
                                    <b>Pengaturan Akun</b>
                                </div>
                                <div>
                                    <button class="btn btn-sm bg-white rounded-full" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-dark" data-bs-placement="top" title="" data-bs-original-title="Pengaturan Akun">
                                        &nbsp;
                                    </button>
                                </div>
                            </li>
                        </ul>

                        <ul class="list-group list-group-bordered my-3">
                            <li class="list-group-item d-flex align-items-center justify-content-between active">
                                <div>
                                    <span class="menu-icon">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen019.svg-->
                                        <span class="svg-icon svg-icon-2">
                                            <i class="bi bi-box-arrow-left text-white fs-3 me-2"></i>
                                        </span>
                                        <!--end::Svg Icon-->
                                    </span>
                                    <b>Sign-Out</b>
                                </div>
                                <div>
                                    <button class="btn btn-sm bg-white rounded-full" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-dark" data-bs-placement="top" title="" data-bs-original-title="Sign-Out">
                                        &nbsp;
                                    </button>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!--end::Content container-->
</div>
<!--end::Content-->


<div class="modal fade" id="modal-data-menu" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Data Management Menu</h5>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <span class="svg-icon svg-icon-2x"></span>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body">
                <!--begin::Alert-->
                <div id="card_alert_informasi_edit" style="display:none">
                    <div class="alert alert-danger d-flex align-items-center p-2">
                        <!--begin::Icon-->
                        <span class="svg-icon svg-icon-2hx svg-icon-danger me-3">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path opacity="0.3" d="M20.5543 4.37824L12.1798 2.02473C12.0626 1.99176 11.9376 1.99176 11.8203 2.02473L3.44572 4.37824C3.18118 4.45258 3 4.6807 3 4.93945V13.569C3 14.6914 3.48509 15.8404 4.4417 16.984C5.17231 17.8575 6.18314 18.7345 7.446 19.5909C9.56752 21.0295 11.6566 21.912 11.7445 21.9488C11.8258 21.9829 11.9129 22 12.0001 22C12.0872 22 12.1744 21.983 12.2557 21.9488C12.3435 21.912 14.4326 21.0295 16.5541 19.5909C17.8169 18.7345 18.8277 17.8575 19.5584 16.984C20.515 15.8404 21 14.6914 21 13.569V4.93945C21 4.6807 20.8189 4.45258 20.5543 4.37824Z" fill="currentColor"/>
                                <rect x="9" y="13.0283" width="7.3536" height="1.2256" rx="0.6128" transform="rotate(-45 9 13.0283)" fill="currentColor"/>
                                <rect x="9.86664" y="7.93359" width="7.3536" height="1.2256" rx="0.6128" transform="rotate(45 9.86664 7.93359)" fill="currentColor"/>
                            </svg>
                        </span>
                        <!--end::Icon-->
        
                        <!--begin::Wrapper-->
                        <div class="d-flex flex-column">
                            <!--begin::Title-->
                            <h4 class="mb-1 text-dark">This is an alert</h4>
                            <!--end::Title-->
                            <!--begin::Content-->
                            <span id="alert_informasi_edit">The alert component can be used to highlight</span>
                            <!--end::Content-->
                        </div>
                        <!--end::Wrapper-->
                    </div>
                </div>            
                <!--end::Alert-->

                <form id="form_management_menu_edit" class="form d-flex flex-column flex-lg-row" action="#" method="POST" enctype="multipart/form-data" autocomplete="off">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="w-100">
                                <!--begin::Label-->
                                <label class="required form-label">Grup Menu</label>
                                <!--end::Label-->
                                <!--begin::Select2-->
                                <select class="form-select mb-2" name="formedit_menu_grup" id="formedit_menu_grup" data-control="select2" data-placeholder="Select an option">                                        
                                    @foreach ($model['MsMenuGrup'] as $grup_menu)
                                        <option value="{{$grup_menu->uuid}}">{{$grup_menu->nama}}</option>
                                    @endforeach 
                                </select>
                                <!--end::Select2-->
                                <!--begin::Description-->
                                {{-- <div class="text-muted fs-7">Set the product tax class.</div> --}}
                                <!--end::Description-->
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="w-100">
                                <!--begin::Label-->
                                <label class="form-label">Parent Menu</label>
                                <!--end::Label-->
                                <!--begin::Select2-->
                                <select class="form-select mb-2" name="formedit_menu_parent" id="formedit_menu_parent" data-control="select2" data-placeholder="Select an option">
                                    <option value="-">-- Parent Menu -- </option>                                       
                                    @foreach ($model['MsMenu']->where('menu_parent', 0) as $menu)
                                        <option value="{{$menu->menu_uuid}}">{{$menu->menu_title}}</option>
                                    @endforeach
                                </select>
                                <!--end::Select2-->
                                <!--begin::Description-->
                                {{-- <div class="text-muted fs-7">Set the product tax class.</div> --}}
                                <!--end::Description-->
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-2 fv-row">
                                <!--begin::Label-->
                                <label class="required form-label">Nama Menu</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="formedit_menu_nama" id="formedit_menu_nama" class="form-control mb-2" placeholder="Nama Menu" value="" />
                                <input type="hidden" name="formedit_menu_uuid" id="formedit_menu_uuid" class="form-control mb-2" placeholder="Uuid Menu" value="" readonly/>
                                <!--end::Input-->
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-2 fv-row">
                                <!--begin::Label-->
                                <label class="form-label">Icon Menu <a href="https://icons.getbootstrap.com/">Get Bootstrap Icons</a></label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="formedit_menu_icon" id="formedit_menu_icon" class="form-control mb-2" placeholder="Icon Menu" value="" />
                                <!--end::Input-->
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-2 fv-row">
                                <!--begin::Label-->
                                <label class="required form-label">URI Menu</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="formedit_menu_uri" id="formedit_menu_uri" class="form-control mb-2" placeholder="URI Menu" value="" />
                                <!--end::Input-->
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-2 fv-row">
                                <!--begin::Label-->
                                <label class="required form-label">Route Name Menu</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="formedit_menu_routename" id="formedit_menu_routename" class="form-control mb-2" placeholder="Route Name Menu" value="" />
                                <!--end::Input-->
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="d-flex justify-content-end mt-5">
                                <!--begin::Submit button-->
                                <div class="d-grid">
                                    <button type="submit" id="btnSubmitEditData" class="btn btn-primary">
                                        <!--begin::Indicator label-->
                                        <span class="indicator-label"><i class="bi bi-check2-all fs-4 me-2"></i> Kirim Data</span>
                                        <!--end::Indicator label-->
                                        <!--begin::Indicator progress-->
                                        <span class="indicator-progress">Please wait...
                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                        <!--end::Indicator progress-->
                                    </button>
                                </div>
                                <!--end::Submit button-->
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
        // The DOM element you wish to replace with Tagify
        var form_tambah_hastag = document.querySelector('input[name=form_menu_routename]');

        // initialize Tagify on the above input node reference
        new Tagify(form_tambah_hastag)
    </script>

    <script src="{{ URL::asset('js/pages/management_menu.js?version=') }}{{uniqid()}}"></script>
@endsection