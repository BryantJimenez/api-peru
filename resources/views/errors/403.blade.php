@extends('layouts.error')

@section('title', 'Error 403')

@section('content')

<div class="container-fluid error-content">
	<div class="">
		<h1 class="error-number">403</h1>
		<p class="mini-text">Error de prohibición!</p>
		<p class="error-text mb-4 mt-1">No tienes permiso para acceder a este sitio!</p>
		<a href="{{ route('admin') }}" class="btn btn-primary mt-5">Volver al Inicio</a>
	</div>
</div>

@endsection