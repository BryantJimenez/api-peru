@extends('layouts.error')

@section('title', 'Error 419')

@section('content')

<div class="container-fluid error-content">
	<div class="">
		<h1 class="error-number">419</h1>
		<p class="mini-text">Sesión expirada!</p>
		<p class="error-text mb-4 mt-1">Tu sesión ha expirado!</p>
		<a href="{{ route('admin') }}" class="btn btn-primary mt-5">Volver al Inicio</a>
	</div>
</div>

@endsection