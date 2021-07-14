<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>@yield('title')</title>
	<link rel="icon" type="image/x-icon" href="{{ asset('/admins/img/logo.png') }}"/>
	<!-- BEGIN GLOBAL MANDATORY STYLES -->
	<link rel="dns-prefetch" href="//fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&display=swap" rel="stylesheet">
	<link href="{{ asset('/admins/css/bootstrap/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('/admins/css/plugins.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('/admins/css/fontawesome/all.min.css') }}" rel="stylesheet" type="text/css" />
	{{-- <link href="{{ asset('/admins/css/elements/breadcrumb.css') }}" rel="stylesheet" type="text/css" /> --}}
	<!-- END GLOBAL MANDATORY STYLES -->

	<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
	@yield('links')
	<!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->

</head>
<body class="sidebar-noneoverflow">

	<!--  BEGIN NAVBAR  -->
	@include('admin.partials.header')
	<!--  END NAVBAR  -->

	<!--  BEGIN MAIN CONTAINER  -->
	<div class="main-container" id="container">

		<div class="overlay"></div>
		<div class="search-overlay"></div>

		<!--  BEGIN SIDEBAR  -->
		@include('admin.partials.sidebar')
		<!--  END SIDEBAR  -->

		<!--  BEGIN CONTENT AREA  -->
		<div id="content" class="main-content">
			<div class="layout-px-spacing">

				{{-- <nav class="breadcrumb-one float-right mt-2" aria-label="breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="{{ route('admin') }}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg> Inicio</a></li>
						
						@yield('breadcrumb')
					</ol>
				</nav> --}}

				<!-- CONTENT AREA -->
				@yield('content')
				<!-- CONTENT AREA -->

			</div>
			@include('admin.partials.footer')
		</div>
		<!--  END CONTENT AREA  -->

	</div>
	<!-- END MAIN CONTAINER -->

	<!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
	<script src="{{ asset('/admins/js/libs/jquery-3.1.1.min.js') }}"></script>
	<script src="{{ asset('/admins/js/bootstrap/popper.min.js') }}"></script>
	<script src="{{ asset('/admins/js/bootstrap/bootstrap.min.js') }}"></script>
	<script src="{{ asset('/admins/vendor/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
	<script src="{{ asset('/admins/js/app.js') }}"></script>
	<!-- END GLOBAL MANDATORY SCRIPTS -->

	<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
	@yield('scripts')
	<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->

	<script src="{{ asset('/admins/js/custom.js') }}"></script>
	@include('admin.partials.notifications')
</body>
</html>