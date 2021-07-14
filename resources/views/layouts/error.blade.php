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
	<link href="{{ asset('/admins/css/pages/error/style-400.css') }}" rel="stylesheet" type="text/css" />
	<!-- END GLOBAL MANDATORY STYLES -->

</head>
<body class="error404 text-center">

	<!-- CONTENT AREA -->
	@yield('content')
	<!-- CONTENT AREA -->

	<!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
	<script src="{{ asset('/admins/js/libs/jquery-3.1.1.min.js') }}"></script>
	<script src="{{ asset('/admins/js/bootstrap/popper.min.js') }}"></script>
	<script src="{{ asset('/admins/js/bootstrap/bootstrap.min.js') }}"></script>
	<!-- END GLOBAL MANDATORY SCRIPTS -->
</body>
</html>