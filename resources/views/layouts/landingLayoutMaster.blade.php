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

        <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
        <link href="{{ asset('plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
        <!--end::Global Stylesheets Bundle-->

        <script>// Frame-busting to prevent site from being loaded within a frame without permission (click-jacking) if (window.top != window.self) { window.top.location.replace(window.self.location.href); }</script>

        <script>
            let BaseURL = "{{ url('/') }}";
            var authData = null;
        </script>

        {{-- Page Styles --}}
        @yield('page-style')
    </head>
    <!--end::Head-->

    <!--begin::Body-->
    <body id="kt_body" data-bs-spy="scroll" data-bs-target="#kt_landing_menu" class="bg-body position-relative app-blank">
        <!--begin::Theme mode setup on page load-->
		<script>
            var defaultThemeMode = "light"; 
            var themeMode; 
            if ( document.documentElement ) { 
                if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { 
                    themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); 
                } else { 
                    if ( localStorage.getItem("data-bs-theme") !== null ) { 
                        themeMode = localStorage.getItem("data-bs-theme"); 
                    } else { 
                        themeMode = defaultThemeMode; 
                    } 
                } 
                
                if (themeMode === "system") { 
                    themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; 
                } 
                document.documentElement.setAttribute("data-bs-theme", themeMode); 
            } 
        </script>
		<!--end::Theme mode setup on page load-->

        <!--begin::Root-->
		<div class="d-flex flex-column flex-root" id="kt_app_root">
			
            <!--begin::Header Section-->
            @include('panels/publik/v_header')
            <!--end::Header Section-->			
			
			{{-- Include Startkit Content --}}
            @yield('content')
            <!--end::Content Section-->
			
			<!--begin::Footer Section-->
			<div class="mb-0">
				<!--begin::Curve top-->
				<div class="landing-curve landing-dark-color">
					<svg viewBox="15 -1 1470 48" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M1 48C4.93573 47.6644 8.85984 47.3311 12.7725 47H1489.16C1493.1 47.3311 1497.04 47.6644 1501 48V47H1489.16C914.668 -1.34764 587.282 -1.61174 12.7725 47H1V48Z" fill="currentColor"></path>
					</svg>
				</div>
				<!--end::Curve top-->

				<!--begin::Wrapper-->
				@include('panels/publik/v_footer')
				<!--end::Wrapper-->
			</div>
			<!--end::Footer Section-->

			<!--begin::Scrolltop-->
			<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
				<i class="ki-duotone ki-arrow-up">
					<span class="path1"></span>
					<span class="path2"></span>
				</i>
			</div>
			<!--end::Scrolltop-->
		</div>
		<!--end::Root-->

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
            var hostUrl = "/";
        </script>
		
        <!--begin::Global Javascript Bundle(mandatory for all pages)-->
		<script src="{{ asset('plugins/global/plugins.bundle.js') }}"></script>
		<script src="{{ asset('js/scripts.bundle.js') }}"></script>
		<!--end::Global Javascript Bundle-->

		<!--begin::Vendors Javascript(used for this page only)-->
		<script src="{{ asset('plugins/custom/fslightbox/fslightbox.bundle.js') }}"></script>
		<script src="{{ asset('plugins/custom/typedjs/typedjs.bundle.js') }}"></script>
		<!--end::Vendors Javascript-->

		<!--begin::Custom Javascript(used for this page only)-->
		<script src="{{ asset('js/custom/landing.js') }}"></script>
		<script src="{{ asset('js/custom/pages/pricing/general.js') }}"></script>
		<!--end::Custom Javascript-->

        @yield('page-script')

		<!--end::Javascript-->
    </body>
    <!--end::Body-->
</html>
