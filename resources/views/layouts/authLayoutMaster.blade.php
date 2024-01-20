
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
		<script>
            // Frame-busting to prevent site from being loaded within a frame without permission (click-jacking) if (window.top != window.self) { window.top.location.replace(window.self.location.href); }
        </script>

        <script src='https://www.google.com/recaptcha/api.js'></script>

        <!-- Base URL Java Script -->
        <script>
            let BaseURL = "{{ url('/') }}";
            var authData = null;
        </script>

        {{-- Page Styles --}}
        @yield('page-style')
	</head>
	<!--end::Head-->

	<!--begin::Body-->
	<body id="kt_body" class="app-blank">
		<!--begin::Theme mode setup on page load-->
		<script>
            var defaultThemeMode = "light"; 
            var themeMode; if ( document.documentElement ) { 
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
			<!--begin::Authentication - Sign-in -->
			<div class="d-flex flex-column flex-lg-row flex-column-fluid">
				<!--begin::Body-->
				<div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-10 order-2 order-lg-1">
					
                    {{-- Include Auth Content --}}
                    @yield('content')
					
                    <!--begin::Footer-->
					<div class="w-lg-500px w-sm-100 w-100 d-flex flex-stack mx-auto">						
						<!--begin::Links-->
						<div class="fw-bold text-primary text-center w-100">
							<p> {!! env('APP_VERSION') !!}</p>
						</div>
						<!--end::Links-->
					</div>
					<!--end::Footer-->
				</div>
				<!--end::Body-->
				
                <!--begin::Aside-->
				<div class="d-flex flex-lg-row-fluid w-lg-50 bgi-size-cover bgi-position-center order-1 order-lg-2" style="background-image: url({{ asset('media/misc/auth-bg.png') }})">
					<!--begin::Content-->
					<div class="d-flex flex-column flex-center py-7 py-lg-15 px-5 px-md-15 w-100">
						<!--begin::Logo-->
						<a href="index.html" class="mb-0 mb-lg-12">
							<img alt="Logo" src="{{ asset('images/pupuk-indonesia-putih.png') }}" class="h-100px h-lg-120px" />
						</a>
						<!--end::Logo-->
						<!--begin::Image-->
						<img class="d-none d-lg-block mx-auto w-275px w-md-50 w-xl-500px mb-10 mb-lg-20" src="{{ asset('images/kujang-asset.png') }}" alt="" />
						<!--end::Image-->
						<!--begin::Title-->
						<h1 class="d-none d-lg-block text-white fs-2qx fw-bolder text-center mb-7">Fast, Efficient and Productive</h1>
						<!--end::Title-->
						<!--begin::Text-->
						<div class="d-none d-lg-block text-white fs-base text-center">In this kind of post, 
						<a href="#" class="opacity-75-hover text-warning fw-bold me-1">the blogger</a>introduces a person they’ve interviewed 
						<br />and provides some background information about 
						<a href="#" class="opacity-75-hover text-warning fw-bold me-1">the interviewee</a>and their 
						<br />work following this is a transcript of the interview.</div>
						<!--end::Text-->
					</div>
					<!--end::Content-->
				</div>
				<!--end::Aside-->

			</div>
			<!--end::Authentication - Sign-in-->
		</div>
		<!--end::Root-->
		
        <!--begin::Javascript-->
		<script>
            var hostUrl = "";
        </script>
		
        <!--begin::Global Javascript Bundle(mandatory for all pages)-->
		<script src="{{ asset('plugins/global/plugins.bundle.js') }}"></script>
		<script src="{{ asset('js/scripts.bundle.js') }}"></script>
		<script src="{{ URL::asset('js/pages/main_page.js?version=') }}{{uniqid()}}"></script>
		<!--end::Global Javascript Bundle-->

        {{-- page script --}}
        @yield('page-script')
        {{-- page script --}}

		<!--end::Javascript-->
	</body>
	<!--end::Body-->
</html>
