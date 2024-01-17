@extends('layouts/adminLayoutMaster')

@section('title', 'Management Role User - Konfigurasi Hak Akses')

@section('page-style')
    <!-- Current Page CSS Costum -->

@endsection

@section('content')

<!--begin::Content-->
<div id="kt_app_content" class="app-content flex-column-fluid mt-5">
    <!--begin::Content container-->
    <div id="kt_app_content_container" class="app-container container-fluid">

        <div class="row">
            <div class="col-md-4">
                <div class="mb-5">
                    <div class="d-flex flex-stack">
                        <div class="fw-bolder fs-4">Data Role User
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
                        <div class="mb-2 fv-row w-100">
                            <!--begin::Label-->
                            <label class="form-label">Nama Role User : </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="hidden" name="form_role_uuid" id="form_role_uuid" class="form-control mb-2" placeholder="UUID Role User" value="{{$model['msrole']->uuid}}" readonly/>
                            <input type="text" name="form_role_nama" id="form_role_nama" class="form-control mb-2" placeholder="Nama Role User" value="{{$model['msrole']->name}}" disabled/>
                            <!--end::Input-->
                        </div>

                        <div class="mb-2 fv-row  w-100">
                            <!--begin::Label-->
                            <label class="form-label">Deskripsi Role User</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <textarea class="form-control" name="form_role_deskripsi" id="form_role_deskripsi" rows="3" disabled>{!!$model['msrole']->description!!}</textarea>
                            <!--end::Input-->
                        </div>

                        <div class="mb-2 fv-row w-100">
                            <!--begin::Label-->
                            <label class="form-label">Status Role User : </label>
                            <!--end::Label-->
                            @if ($model['msrole']->status == 0)
                                <button type="button" class="btn btn-danger py-2 w-100"><i class="bi bi-exclamation-octagon fs-4 me-2"></i>Role User In-Aktif</button>
                            @else
                                <button type="button" class="btn btn-info py-2 w-100"><i class="bi bi-patch-check fs-4 me-2"></i>Role User Aktif</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <!--begin::Title-->
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bold text-dark">Konfigurasi Hak Akses Role User</span>
                            <span class="text-gray-400 mt-1 fw-semibold fs-6">Users from all channels</span>
                        </h3>
                        <!--end::Title-->                            
                    </div>
                    <div class="card-body">

                        {{-- Start Menu Seting --}}
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
                                    @php
                                        $dataAuth = $model['MsAuthhorization']->where('id_menu', $menu->id)->first();
                                        $viewAuth = null;
                                        if(isset($dataAuth->authorization_view))
                                        {
                                            $viewAuth = $dataAuth->authorization_view;
                                        }
                                        $createAuth = null;
                                        if(isset($dataAuth->authorization_create))
                                        {
                                            $createAuth = $dataAuth->authorization_create;
                                        }
                                        $updateAuth = null;
                                        if(isset($dataAuth->authorization_update))
                                        {
                                            $updateAuth = $dataAuth->authorization_update;
                                        }
                                        $deleteAuth = null;
                                        if(isset($dataAuth->authorization_delete))
                                        {
                                            $deleteAuth = $dataAuth->authorization_delete;
                                        }
                                    @endphp
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
                                        <div class="d-flex flex-row">
                                            <div class="shadow-sm form-check form-check-custom form-check-success form-check-solid me-10" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-dark" data-bs-placement="top" title="" data-bs-original-title="View">
                                                <input class="form-check-input h-30px w-30px" type="checkbox" id="aksesmenu_view_{{$menu->menu_kode}}" data-auth="auth_view" data-menu="{{$menu->menu_uuid}}" onchange="changeRoleAksesMenu(this)" @if ($viewAuth == 1) checked @endif/>                                                    
                                            </div>
                                            <div class="shadow-sm form-check form-check-custom form-check-success form-check-solid me-10" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-dark" data-bs-placement="top" title="" data-bs-original-title="Create">
                                                <input class="form-check-input h-30px w-30px" type="checkbox" id="aksesmenu_create_{{$menu->menu_kode}}" data-auth="auth_create" data-menu="{{$menu->menu_uuid}}" onchange="changeRoleAksesMenu(this)" @if ($createAuth == 1) checked @endif/>                                                    
                                            </div>
                                            <div class="shadow-sm form-check form-check-custom form-check-success form-check-solid me-10" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-dark" data-bs-placement="top" title="" data-bs-original-title="Update">
                                                <input class="form-check-input h-30px w-30px" type="checkbox" id="aksesmenu_update_{{$menu->menu_kode}}" data-auth="auth_update" data-menu="{{$menu->menu_uuid}}" onchange="changeRoleAksesMenu(this)" @if ($updateAuth == 1) checked @endif/>                                                    
                                            </div>
                                            <div class="shadow-sm form-check form-check-custom form-check-success form-check-solid me-10" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-dark" data-bs-placement="top" title="" data-bs-original-title="Delete">
                                                <input class="form-check-input h-30px w-30px" type="checkbox" id="aksesmenu_delete_{{$menu->menu_kode}}" data-auth="auth_delete" data-menu="{{$menu->menu_uuid}}" onchange="changeRoleAksesMenu(this)" @if ($deleteAuth == 1) checked @endif/>                                                    
                                            </div>
                                        </div>
                                    </li>
                                    @foreach ($model['MsMenu']->where('menu_parent', $menu->id)->sortBy('menu_sort') as $submenu)                                                
                                        @php
                                            $dataAuth = $model['MsAuthhorization']->where('id_menu', $submenu->id)->first();
                                            $viewAuth = null;
                                            if(isset($dataAuth->authorization_view))
                                            {
                                                $viewAuth = $dataAuth->authorization_view;
                                            }
                                            $createAuth = null;
                                            if(isset($dataAuth->authorization_create))
                                            {
                                                $createAuth = $dataAuth->authorization_create;
                                            }
                                            $updateAuth = null;
                                            if(isset($dataAuth->authorization_update))
                                            {
                                                $updateAuth = $dataAuth->authorization_update;
                                            }
                                            $deleteAuth = null;
                                            if(isset($dataAuth->authorization_delete))
                                            {
                                                $deleteAuth = $dataAuth->authorization_delete;
                                            }
                                        @endphp
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
                                            <div class="d-flex flex-row">
                                                <div class="shadow-sm form-check form-check-custom form-check-success form-check-solid me-10" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-dark" data-bs-placement="top" title="" data-bs-original-title="View">
                                                    <input class="form-check-input h-30px w-30px" type="checkbox" id="aksesmenu_view_{{$submenu->menu_kode}}" data-auth="auth_view" data-menu="{{$submenu->menu_uuid}}" onchange="changeRoleAksesMenu(this)" @if ($viewAuth == 1) checked @endif/>                                                    
                                                </div>
                                                <div class="shadow-sm form-check form-check-custom form-check-success form-check-solid me-10" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-dark" data-bs-placement="top" title="" data-bs-original-title="Create">
                                                    <input class="form-check-input h-30px w-30px" type="checkbox" id="aksesmenu_create_{{$submenu->menu_kode}}" data-auth="auth_create" data-menu="{{$submenu->menu_uuid}}" onchange="changeRoleAksesMenu(this)" @if ($createAuth == 1) checked @endif/>                                                    
                                                </div>
                                                <div class="shadow-sm form-check form-check-custom form-check-success form-check-solid me-10" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-dark" data-bs-placement="top" title="" data-bs-original-title="Update">
                                                    <input class="form-check-input h-30px w-30px" type="checkbox" id="aksesmenu_update_{{$submenu->menu_kode}}" data-auth="auth_update" data-menu="{{$submenu->menu_uuid}}" onchange="changeRoleAksesMenu(this)" @if ($updateAuth == 1) checked @endif/>                                                    
                                                </div>
                                                <div class="shadow-sm form-check form-check-custom form-check-success form-check-solid me-10" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-dark" data-bs-placement="top" title="" data-bs-original-title="Delete">
                                                    <input class="form-check-input h-30px w-30px" type="checkbox" id="aksesmenu_delete_{{$submenu->menu_kode}}" data-auth="auth_delete" data-menu="{{$submenu->menu_uuid}}" onchange="changeRoleAksesMenu(this)" @if ($deleteAuth == 1) checked @endif/>                                                    
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach 
                                </ul>
                                @endforeach


                            @endforeach
                        @endif
                        {{-- End Menu Seting --}}

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

@endsection

@section('page-script')
    <!-- Current Page JS Costum -->
    <script src="{{ URL::asset('js/pages/management_role_hakakses.js?version=') }}{{uniqid()}}"></script>
@endsection