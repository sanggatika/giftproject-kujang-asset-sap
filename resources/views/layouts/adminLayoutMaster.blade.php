
<!DOCTYPE html>
<html lang="id">
	<!--begin::Head-->
	<head>
		<meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Mobile Metas -->
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, shrink-to-fit=no">

        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="csrf-key" content="{{ env('APP_KEY') }}">

        <!-- Title -->
        <title>GIFT PROJECT @yield('title')</title>

        <!-- Meta Tag -->
		<meta name="keywords" content="Aplikasi Asset Inventori, Aplikasi, Aset, Inventori, giftproject.id, Gift Project, CV Gift Project, Gift,Project, Web Development, Karawang, Kabupaten Karawang" />
        <meta name="description" content="App Asset Inventory by GIFTPROJECT.ID Specialized in Web Developer, System Analyst and Fullstack Developer">
        <meta name="author" content="Giri Sanggatika">

		<meta property="og:locale" content="id_ID" />
		<meta property="og:type" content="website" />
		<meta property="og:title" content="App Asset Inventory by GIFTPROJECT.ID Specialized in Web Developer, System Analyst and Fullstack Developer" />
		<meta property="og:url" content="{{ url('') }}" />
		<meta property="og:site_name" content="App Asset Inventory by GIFTPROJECT.ID Specialized in Web Developer, System Analyst and Fullstack Developer" />
		
        <meta property="og:image" content="@yield('imageURL', asset('images/logo_giftproject_titile.png'))">

        <!-- Favicon -->
        <link rel="shortcut icon" href="@yield('imageURL', asset('images/logo_giftproject_titile.png'))" type="image/x-icon" />
        <link rel="apple-touch-icon" href="@yield('imageURL', asset('images/logo_giftproject_titile.png'))">
		
        <!--begin::Fonts(mandatory for all pages)-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
		<!--end::Fonts-->
		
        <!--begin::Vendor Stylesheets(used for this page only)-->
		<link href="{{ asset('plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
		<!--end::Vendor Stylesheets-->
		
        <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
		<link href="{{ asset('plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('css/placeholder-loading.min.css') }}" rel="stylesheet" type="text/css" />
		<!--end::Global Stylesheets Bundle-->
		
        <script>// Frame-busting to prevent site from being loaded within a frame without permission (click-jacking) if (window.top != window.self) { window.top.location.replace(window.self.location.href); }</script>
        
		<script src='https://www.google.com/recaptcha/api.js'></script>
		
        <!-- Base URL Java Script -->
        <script>
            let BaseURL = "{{ url('/') }}";
            var authData = null;
        </script>
    
        @if (Auth::check())    
        <script>
            authData = true;
        </script>
        @endif
    
        {{-- Page Styles --}}
        @yield('page-style')
    </head>
	<!--end::Head-->

	<!--begin::Body-->
	<body id="kt_app_body" data-kt-app-layout="dark-sidebar" data-kt-app-header-fixed="true" data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true" @if (Route::currentRouteName() == 'dash.progres_realisasi')  data-kt-app-sidebar-minimize="on" @endif data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" class="app-default">
		<!--begin::Theme mode setup on page load-->
		<script>
            var defaultThemeMode = "light"; 
            var themeMode; if ( document.documentElement ) { 
                if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { 
                    themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); 
                } else { 
                    if ( localStorage.getItem("data-bs-theme") !== null ) { 
                        themeMode = localStorage.getItem("data-bs-theme"); 
                    } else { themeMode = defaultThemeMode; } 
                } 
                if (themeMode === "system") { 
                    themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; 
                } 
                document.documentElement.setAttribute("data-bs-theme", themeMode); 
            }
        </script>        
		<!--end::Theme mode setup on page load-->

		<!--begin::App-->
		<div class="d-flex flex-column flex-root app-root" id="kt_app_root">
			<!--begin::Page-->
			<div class="app-page flex-column flex-column-fluid" id="kt_app_page">
				
                <!--begin::Header-->
				@include('panels/admin/v_header')
				<!--end::Header-->

				<!--begin::Wrapper-->
				<div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
					
                    <!--begin::Sidebar-->
					@include('panels/admin/v_sidebar_menu')
					<!--end::Sidebar-->

					<!--begin::Main-->
					<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
						<!--begin::Content wrapper-->
						<div class="d-flex flex-column flex-column-fluid">
							
                            <!--begin::Conten Page-->
                            @yield('content')
                            <!--end::Conten Page-->
							
						</div>
						<!--end::Content wrapper-->
						
                        <!--begin::Footer-->
                        @include('panels/admin/v_footer')						
						<!--end::Footer-->

					</div>
					<!--end:::Main-->
				</div>
				<!--end::Wrapper-->
			</div>
			<!--end::Page-->
		</div>
		<!--end::App-->
        
		<!--begin::Drawers-->

            <!--begin::Activities drawer-->
            @include('panels/admin/drawers/v_drawer_activities_log')
            <!--end::Activities drawer-->

            <!--begin::Chat drawer-->
            @include('panels/admin/drawers/v_drawer_chat')
            <!--end::Chat drawer-->
		
		<!--end::Drawers-->

		<!--begin::Scrolltop-->
		<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
			<i class="ki-duotone ki-arrow-up">
				<span class="path1"></span>
				<span class="path2"></span>
			</i>
		</div>
		<!--end::Scrolltop-->
        
        <!--begin::Javascript-->
		<script>
            var hostUrl = "assets/";
        </script>
		
        <!--begin::Global Javascript Bundle(mandatory for all pages)-->
		<script src="{{ asset('plugins/global/plugins.bundle.js') }}"></script>
		<script src="{{ asset('js/scripts.bundle.js') }}"></script>
		<script src="{{ asset('js/crypto-js.min.js?version=') }}{{uniqid()}}"></script>
		<script src="{{ asset('js/pages/main_page.js?version=') }}{{uniqid()}}"></script>
		<!--end::Global Javascript Bundle-->

		<!--begin::Vendors Javascript(used for this page only)-->
		<script src="{{ asset('plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>
		<script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>
		<!--end::Vendors Javascript-->

		<!--begin::Custom Javascript(used for this page only)-->
		<script src="{{ asset('js/widgets.bundle.js') }}"></script>
		<script src="{{ asset('js/custom/widgets.js') }}"></script>
		<script src="{{ asset('js/custom/apps/chat/chat.js') }}"></script>
		<!--end::Custom Javascript-->

		@yield('page-script')

		<!--end::Javascript-->
	</body>
	<!--end::Body-->
</html>
