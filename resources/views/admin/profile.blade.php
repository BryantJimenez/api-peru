@extends('layouts.admin')

@section('title', 'Perfil de Usuario')

@section('links')
<link href="{{ asset('/admins/css/users/user-profile.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

<div class="row">
	<div class="col-xl-4 col-lg-6 col-md-5 col-sm-12 layout-top-spacing">

		<div class="user-profile layout-spacing">
			<div class="widget-content widget-content-area">
				<div class="d-flex justify-content-between">
					<h3 class="">Datos Personales</h3>
					<a href="{{ route('profile.edit') }}" class="mt-2 edit-profile"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg></a>
				</div>
				<div class="text-center user-info">
					<img src="{{ image_exist('/admins/img/users/', Auth::user()->photo, true) }}" width="90" height="90" alt="Foto de perfil" title="{{ Auth::user()->name." ".Auth::user()->lastname }}">
					<p class="">{{ Auth::user()->name." ".Auth::user()->lastname }}</p>
				</div>
				<div class="user-info-list">

					<div class="">
						<ul class="contacts-block list-unstyled">
							<li class="contacts-block__item">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-coffee"><path d="M18 8h1a4 4 0 0 1 0 8h-1"></path><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"></path><line x1="6" y1="1" x2="6" y2="4"></line><line x1="10" y1="1" x2="10" y2="4"></line><line x1="14" y1="1" x2="14" y2="4"></line></svg>{!! roleUser(Auth::user()) !!}
							</li>
							<li class="contacts-block__item">
								<a href="mailto:{{ Auth::user()->email }}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>{{ Auth::user()->email }}</a>
							</li>
							<li class="contacts-block__item">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-phone"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>{{ Auth::user()->phone }}
							</li>
							<li class="contacts-block__item">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-square"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>{!! state(Auth::user()->state) !!}
							</li>
						</ul>
					</div>                                    
				</div>
			</div>
		</div>
	</div>

	<div class="col-xl-8 col-lg-6 col-md-7 col-12 layout-top-spacing">

		<div class="user-profile layout-spacing">
			<div class="widget-content widget-content-area">
				<div class="d-flex justify-content-between">
					<h3 class="pb-3">Datos Adicionales</h3>
				</div>
				<div class="user-info-list">

					<div class="">
						<ul class="contacts-block list-unstyled mw-100 mx-2">
							<li class="contacts-block__item">
								<span class="h6 text-black"><b>Fecha de Registro:</b> {{ Auth::user()->created_at->format("d-m-Y H:i a") }}</span>
							</li>
							<li class="contacts-block__item">
								<span class="h6 text-black"><b>Empresa:</b> @if(!is_null(Auth::user()->company)){{ Auth::user()->company }}@else{{ 'No Ingresado' }}@endif</span>
							</li>
							<li class="contacts-block__item">
								<span class="h6 text-black"><b>DOI:</b> @if(!is_null(Auth::user()->doi)){{ Auth::user()->doi }}@else{{ 'No Ingresado' }}@endif</span>
							</li>
							<li class="contacts-block__item">
								<span class="h6 text-black"><b>Dirección:</b> @if(!is_null(Auth::user()->address)){{ Auth::user()->address }}@else{{ 'No Ingresado' }}@endif</span>
							</li>
							<li class="contacts-block__item">
								<span class="h6 text-black"><b>Total de Códigos:</b> {{ $codes->count() }}</span>
							</li>
							<li class="contacts-block__item">
								<span class="h6 text-black"><b>Total de Códigos Activos:</b> {{ $codes->where('state', '1')->count() }}</span>
							</li>
							<li class="contacts-block__item">
								<span class="h6 text-black"><b>Total de Códigos Inactivos:</b> {{ $codes->where('state', '0')->count() }}</span>
							</li>
							<li class="contacts-block__item">
								<span class="h6 text-black"><b>Total de Consultas:</b> {{ $codes->sum('queries') }}</span>
							</li>
							<li class="contacts-block__item">
								<span class="h6 text-black"><b>Límite de Consultas Restante:</b> {{ $codes->where('state', '1')->sum('limit')-$codes->where('state', '1')->sum('queries') }}</span>
							</li>
						</ul>
					</div>                                    
				</div>
			</div>
		</div>
	</div>

	<div class="col-12 layout-top-spacing">
		<div class="user-profile layout-spacing">
			<div class="widget-content widget-content-area">
				<div class="d-flex justify-content-between">
					<h3 class="pb-3">Lista de Códigos</h3>
				</div>
				<div class="user-info-list">

					<div class="row">
						<div class="col-12">
							<div class="table-responsive mb-4 mt-4">
								<table class="table table-hover table-export">
									<thead>
										<tr>
											<th>#</th>
											<th>Nombre</th>
											<th>Código</th>
											<th>DNI</th>
											<th>RUC</th>
											<th>Total</th>
											<th>Límite</th>
											<th>Estado</th>
											@if(auth()->user()->can('codes.revert'))
											<th>Acciones</th>
											@endif
										</tr>
									</thead>
									<tbody>
										@foreach($codes->sortDesc() as $code)
										<tr>
											<td>{{ $loop->iteration }}</td>
											<td>{{ $code->name }}</td>
											<td>{{ $code->code }}</td>
											<td>{{ $code->inquiries->where('type', '1')->first()->queries }}</td>
											<td>{{ $code->inquiries->where('type', '2')->first()->queries }}</td>
											<td>{{ $code->queries }}</td>
											<td>@if(is_null($code->limit)){{ 'Ilimitadas' }}@else{{ $code->limit }}@endif</td>
											<td>{!! state($code->state) !!}</td>
											@if(auth()->user()->can('codes.revert'))
											<td>
												<div class="btn-group" role="group">
													@if(!is_null($code->mac))
													@can('codes.revert')
													<button type="button" class="btn btn-warning btn-sm bs-tooltip" title="Revertir MAC" onclick="revertCode('{{ $code->code }}')"><i class="fas fa-history"></i></button>
													@endcan
													@endif
												</div>
											</td>
											@endif
										</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>                                        
					</div>

				</div>
			</div>
		</div>
	</div>
</div>

@can('codes.revert')
<div class="modal fade" id="revertCode" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">¿Estás seguro de que quieres revertir la MAC de este código?</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn" data-dismiss="modal">Cancelar</button>
				<form action="#" method="POST" id="formRevertCode">
					@csrf
					@method('PUT')
					<button type="submit" class="btn btn-primary">Revertir</button>
				</form>
			</div>
		</div>
	</div>
</div>
@endcan

@endsection