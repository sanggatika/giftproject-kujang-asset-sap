@extends('layouts/adminLayoutMaster')

@section('title', 'Management Role User')

@section('page-style')
    <!-- Current Page CSS Costum -->

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
                    <h4 class="text-gray-900 fw-bold">Data Management Role</h4>
                    <div class="fs-6 text-gray-700">Keterangan : Penambahan Role User belum menentukan konfigurasi akses data pada role user, harus dilakukan konfigurasi terlebih dahulu.</div>
                </div>
                <!--end::Content-->
            </div>
            <!--end::Wrapper-->
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="mb-5">
                    <div class="d-flex flex-stack">
                        <div class="fw-bolder fs-4">Tambah Data Role User
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

                        <form id="form_management_role" class="form" action="#" method="POST" enctype="multipart/form-data" autocomplete="off">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-2 fv-row">
                                        <!--begin::Label-->
                                        <label class="required form-label">Nama Role User</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" name="form_role_nama" id="form_role_nama" class="form-control mb-2" placeholder="Nama Role User" value="" />
                                        <!--end::Input-->
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-2 fv-row">
                                        <!--begin::Label-->
                                        <label class="form-label">Deskripsi Role User</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <textarea class="form-control" name="form_role_deskripsi" id="form_role_deskripsi" rows="3"></textarea>
                                        <!--end::Input-->
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
                                        <div class="d-grid">
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
                            <span class="card-label fw-bold text-dark">Show Data List Role User</span>
                            <span class="text-gray-400 mt-1 fw-semibold fs-6">Users from all channels</span>
                        </h3>
                        <!--end::Title-->                            
                    </div>
                    <div class="card-body">                           

                        <table id="kt_datatable_zero_configuration" class="table table-row-bordered table-responsive table-striped table-hover">
                            <thead>
                                <tr class="fw-semibold fs-6 text-muted">
                                    <th>No &nbsp; &nbsp;</th>
                                    <th>Role User</th>
                                    <th>Status</th>
                                    <th>Konfigurasi</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($model['msrole'] as $role)
                                <tr>
                                    <td class="text-center">
                                        <div class="position-relative py-2">
                                            <div class="position-absolute start-0 top-0 w-4px h-100 rounded-2 bg-success"></div>
                                            <a href="#" class="mb-1 text-dark text-hover-primary fw-bolder">{{ $loop->iteration }}</a>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <a href="#" class="text-gray-800 text-hover-primary mb-1"><b>{{ $role->name }}</b></a>
                                            <small>{{ $role->description }}</small>
                                        </div>
                                    </td>
                                    <td> 
                                        @if ($role->status == 0)
                                            <button type="button" class="btn badge-light-danger py-2">Role In-Aktif</button>
                                        @else
                                            <button type="button" class="btn badge-light-info py-2">Role Aktif</button>
                                        @endif
                                    </td>
                                    <td> 
                                        <a href="{{ route('management.role.hakakses', ['data_role' => $role->uuid])}}" class="btn btn-info py-2">
                                            <span class="indicator-label"><i class="bi bi-diagram-3 fs-4 me-2"></i> Hak Akses</span>
                                        </a>
                                    </td>
                                    <td>
                                        <a class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Aksi
                                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                            <span class="svg-icon svg-icon-5 m-0">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                        </a>
                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">                                                
                                            <div class="menu-item px-3">
                                                <a class="menu-link px-3" data-toggle="update" data-id="{{ $role->uuid }}" onclick="actDetailManagementRole(this)">Update Data</a>
                                            </div>
                                            @if ($role->status == 1)
                                            <div class=" menu-item px-3">
                                                <a data-toggle="delete" data-id="{{ $role->uuid }}" data-nama="{{ $role->name }}" data-status="nonaktif" class="menu-link px-3" onclick="actaktifManagementRole(this)">Nonaktifkan</a>
                                            </div>
                                            @else
                                            <div class=" menu-item px-3">
                                                <a data-toggle="restore" data-id="{{ $role->uuid }}" data-nama="{{ $role->name }}" data-status="aktivasi" class="menu-link px-3" onclick="actaktifManagementRole(this)">Aktifkan</a>
                                            </div>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>                           
                        
                    </div>
                </div>
            </div>                
            
        </div>

    </div>
    <!--end::Content container-->
</div>
<!--end::Content-->

<div class="modal fade" id="modal-data-role" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Data Management Role</h5>

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

                <form id="form_management_role_edit" class="form" action="#" method="POST" enctype="multipart/form-data" autocomplete="off">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-2 fv-row">
                                <!--begin::Label-->
                                <label class="required form-label">Nama Role User</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="hidden" name="formedit_role_uuid" id="formedit_role_uuid" class="form-control mb-2" placeholder="UUID Role User" value="" readonly/>
                                <input type="text" name="formedit_role_nama" id="formedit_role_nama" class="form-control mb-2" placeholder="Nama Role User" value="" />
                                <!--end::Input-->
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-2 fv-row">
                                <!--begin::Label-->
                                <label class="form-label">Deskripsi Role User</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <textarea class="form-control" name="formedit_role_deskripsi" id="formedit_role_deskripsi" rows="3"></textarea>
                                <!--end::Input-->
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="d-flex justify-content-end mt-5">
                                <!--begin::Submit button-->
                                <div class="d-grid">
                                    <button type="button" id="btnSubmitEditData" class="btn btn-primary" onclick="actUpdateManagementRole()">
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
    <script src="{{ URL::asset('js/pages/management_role.js?version=') }}{{uniqid()}}"></script>
@endsection