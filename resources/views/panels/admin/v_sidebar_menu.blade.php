<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
    
    <!--begin::Logo-->
    <div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
        <!--begin::Logo image-->
        <a href="index.html">
            <img alt="Logo" src="{{ asset('images/pupuk-indonesia-putih.png') }}" class="h-80px app-sidebar-logo-default" />
            <img alt="Logo" src="{{ asset('images/pupuk-indonesia-title.png') }}" class="h-50px app-sidebar-logo-minimize" style="margin-left: -10px;" />
        </a>
        <!--end::Logo image-->
        <!--begin::Sidebar toggle-->
        <!--begin::Minimized sidebar setup:
            if (isset($_COOKIE["sidebar_minimize_state"]) && $_COOKIE["sidebar_minimize_state"] === "on") { 
                1. "src/js/layout/sidebar.js" adds "sidebar_minimize_state" cookie value to save the sidebar minimize state.
                2. Set data-kt-app-sidebar-minimize="on" attribute for body tag.
                3. Set data-kt-toggle-state="active" attribute to the toggle element with "kt_app_sidebar_toggle" id.
                4. Add "active" class to to sidebar toggle element with "kt_app_sidebar_toggle" id.
            }
        -->
        <div id="kt_app_sidebar_toggle" class="app-sidebar-toggle btn btn-icon btn-shadow btn-sm btn-color-muted btn-active-color-primary h-30px w-30px position-absolute top-50 start-100 translate-middle rotate" data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body" data-kt-toggle-name="app-sidebar-minimize">
            <i class="ki-duotone ki-black-left-line fs-3 rotate-180">
                <span class="path1"></span>
                <span class="path2"></span>
            </i>
        </div>
        <!--end::Sidebar toggle-->
    </div>
    <!--end::Logo-->

    @php
        $routeLive = Route::currentRouteName();
        $ms_menu_authhorization = $menuData[0]['ms_menu_authhorization']; 
        
        if($menuData[0]['data_key'])
        {
            if($menuData[0]['data_key']['app_access'] == false)
            {
                abort( 404 );
            }            
        }else{
            abort( 404 );
        }
        // dd($routeLive);
    @endphp
    
    <!--begin::sidebar menu-->
    <div class="app-sidebar-menu overflow-hidden flex-column-fluid">
        <!--begin::Menu wrapper-->
        <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper">
            <!--begin::Scroll wrapper-->
            <div id="kt_app_sidebar_menu_scroll" class="scroll-y my-5 mx-3" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer" data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true">
                <!--begin::Menu-->
                <div class="menu menu-column menu-rounded menu-sub-indention fw-semibold fs-6" id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">
                    
                    <!--begin::Section-->
                    <div class="d-flex mb-5 @if (Route::currentRouteName() == 'dash.progres_realisasi') d-none @endif">
                        <!--begin::Info-->
                        <div class="flex-grow-1 me-2">
                            <!--begin::Username-->
                            <a href="#" class="text-white text-hover-primary fs-6 fw-bold">{{Auth::user()->name}}</a>
                            <!--end::Username-->
                            <!--begin::Description-->
                            <span class="text-gray-600 fw-semibold d-block fs-8 mb-1">{{Auth::user()->email}}</span>
                            <!--end::Description-->
                            <!--begin::Label-->
                            <div class="d-flex align-items-center text-success fs-9">
                                <span class="bullet bullet-dot bg-success me-1"></span>online
                            </div>
                            <!--end::Label-->
                        </div>
                        <!--end::Info-->                
                    </div>
                    <!--end::Section-->

                    @if ($ms_menu_authhorization != null)
                        @foreach ($ms_menu_authhorization->groupBy('menu_grup_id') as $grup_menu)

                            <!--begin:Menu item-->
                            <div class="menu-item pt-2 @if ($grup_menu[0]->menu_grup_nama == "DASHBOARD") d-none @endif">
                                <!--begin:Menu content-->
                                <div class="menu-content">
                                    <span class="menu-heading fw-bold text-uppercase fs-7 text-warning">{{ $grup_menu[0]->menu_grup_nama }}</span>
                                </div>
                                <!--end:Menu content-->
                            </div>
                            <!--end:Menu item-->

                            @foreach ($ms_menu_authhorization->where('menu_parent', 0)->where('menu_grup_id',$grup_menu[0]->menu_grup_id) as $menu)
                                @if ($menu->menu_parent_status == 0)
                                    @php
                                        $menu_route = json_decode($menu->menu_routename);
                                    @endphp

                                    <!--begin:Menu item-->
                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <a class="menu-link @if (in_array($routeLive, $menu_route)) active @endif" href="{{url($menu->menu_url)}}">
                                            <span class="menu-icon">
                                                {!! $menu->menu_icon !!}
                                            </span>
                                            <span class="menu-title">{{ $menu->menu_title }}</span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
                                    <!--end:Menu item-->
                                @else
                                    @php
                                        $urlSubMenu = null;                   
                                    @endphp
                                    @foreach ($ms_menu_authhorization as $submenu)
                                        @if($submenu->menu_parent == $menu->id_menu)
                                            @if (request()->is(substr($submenu->menu_url,1)))
                                                @php
                                                    $urlSubMenu = 'active';
                                                    break;
                                                @endphp
                                            @endif
                                        @endif
                                    @endforeach

                                    @if (in_array($routeLive, json_decode($menu->menu_routename)))
                                        @php
                                            $urlSubMenu = 'active';
                                        @endphp
                                    @endif

                                    <!--begin:Menu item-->
                                    <div data-kt-menu-trigger="click" class="menu-item {{ $urlSubMenu == 'active' ? 'here show' : '' }} menu-accordion">
                                        <!--begin:Menu link-->
                                        <span class="menu-link">
                                            <span class="menu-icon">
                                                {!! $menu->menu_icon !!}
                                            </span>
                                            <span class="menu-title">{{ $menu->menu_title }}</span>
                                            <span class="menu-arrow"></span>
                                        </span>
                                        <!--end:Menu link-->
                                        <!--begin:Menu sub-->
                                        <div class="menu-sub menu-sub-accordion">
                                            @foreach ($ms_menu_authhorization->where('menu_parent', $menu->id_menu)->sortBy('menu_sort') as $submenu)
                                                @php
                                                    $submenu_route = json_decode($submenu->menu_routename);
                                                @endphp
                                                <!--begin:Menu item-->
                                                <div class="menu-item">
                                                    <!--begin:Menu link-->
                                                    <a class="menu-link @if (in_array($routeLive, $submenu_route)) active @endif" href="{{url($submenu->menu_url)}}">
                                                        <span class="menu-bullet">
                                                            <span class="bullet bullet-dot"></span>
                                                        </span>
                                                        <span class="menu-title">{{ $submenu->menu_title }}</span>
                                                    </a>
                                                    <!--end:Menu link-->
                                                </div>
                                                <!--end:Menu item-->
                                            @endforeach                                           
                                        </div>
                                        <!--end:Menu sub-->
                                    </div>
                                    <!--end:Menu item-->

                                @endif
                            @endforeach

                        @endforeach
                    @endif
                    

                    <!--begin:Menu item-->
                    <div class="menu-item pt-2">
                        <!--begin:Menu content-->
                        <div class="menu-content">
                            <span class="menu-heading fw-bold text-uppercase fs-7 text-warning">LAINNYA</span>
                        </div>
                        <!--end:Menu content-->
                    </div>
                    <!--end:Menu item-->
                    
                    <!--begin:Menu item-->
                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link @if (in_array($routeLive, ['management.account'])) active @endif" href="{{url('/management/account')}}">
                            <span class="menu-icon">
                                <i class="bi bi-person-circle fs-3"></i>
                            </span>
                            <span class="menu-title">Pengaturan Akun</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                    <!--end:Menu item-->

                    <!--begin:Menu item-->
                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link" href="{{url('/auth/logout')}}">
                            <span class="menu-icon">
                                <i class="bi bi-box-arrow-left fs-3"></i>
                            </span>
                            <span class="menu-title">Sign-Out</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                    <!--end:Menu item-->

                </div>
                <!--end::Menu-->
            </div>
            <!--end::Scroll wrapper-->
        </div>
        <!--end::Menu wrapper-->
    </div>
    <!--end::sidebar menu-->
    <!--begin::Footer-->
    <div class="app-sidebar-footer flex-column-auto pt-2 pb-6 px-6" id="kt_app_sidebar_footer">
        <a href="https://preview.keenthemes.com/html/metronic/docs" class="btn btn-flex flex-center btn-custom btn-primary overflow-hidden text-nowrap px-0 h-40px w-100" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss-="click" title="200+ in-house components and 3rd-party plugins">
            <span class="btn-label">Docs & Components</span>
            <i class="ki-duotone ki-document btn-icon fs-2 m-0">
                <span class="path1"></span>
                <span class="path2"></span>
            </i>
        </a>
    </div>
    <!--end::Footer-->
</div>