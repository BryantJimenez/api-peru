@extends('layouts.admin')

@section('title', 'Perfil de Usuario')

@section('links')
<link href="{{ asset('/admins/css/users/user-profile.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{{ asset('/admins/vendor/touchspin/jquery.bootstrap-touchspin.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('/admins/vendor/table/datatable/datatables.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('/admins/vendor/table/datatable/custom_dt_html5.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('/admins/vendor/table/datatable/dt-global_style.css') }}">
<link href="{{ asset('/admins/vendor/sweetalerts/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('/admins/vendor/sweetalerts/sweetalert.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('/admins/css/components/custom-sweetalert.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{{ asset('/admins/vendor/lobibox/Lobibox.min.css') }}">
@endsection

@section('content')

<div class="row">
	<div class="col-xl-4 col-lg-6 col-md-5 col-12 layout-top-spacing">

		<div class="user-profile layout-spacing">
			<div class="widget-content widget-content-area">
				<div class="d-flex justify-content-between">
					<h3 class="">Datos Personales</h3>
					@can('users.edit')
					<a href="{{ route('usuarios.edit', ['user' => $user->slug]) }}" class="mt-2 edit-profile"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg></a>
					@endcan
				</div>
				<div class="text-center user-info">
					<img src="{{ image_exist('/admins/img/users/', $user->photo, true) }}" width="90" height="90" alt="Foto de perfil" title="{{ $user->name." ".$user->lastname }}">
					<p class="mb-0">{{ $user->name." ".$user->lastname }}</p>
				</div>
				<div class="user-info-list">

					<div class="">
						<ul class="contacts-block list-unstyled">
							<li class="contacts-block__item">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-coffee"><path d="M18 8h1a4 4 0 0 1 0 8h-1"></path><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"></path><line x1="6" y1="1" x2="6" y2="4"></line><line x1="10" y1="1" x2="10" y2="4"></line><line x1="14" y1="1" x2="14" y2="4"></line></svg>{!! roleUser($user) !!}
							</li>
							<li class="contacts-block__item">
								<a href="mailto:{{ $user->email }}" class="text-break"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>{{ $user->email }}</a>
							</li>
							<li class="contacts-block__item">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-phone"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>@if(!is_null($user->phone)){{ $user->phone }}@else{{ "No Ingresado" }}@endif
							</li>
							<li class="contacts-block__item">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-square"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>{!! state($user->state) !!}
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
								<span class="h6 text-black"><b>Fecha de Registro:</b> {{ $user->created_at->format("d-m-Y H:i a") }}</span>
							</li>
							<li class="contacts-block__item">
								<span class="h6 text-black"><b>Empresa:</b> @if(!is_null($user->company)){{ $user->company }}@else{{ 'No Ingresado' }}@endif</span>
							</li>
							<li class="contacts-block__item">
								<span class="h6 text-black"><b>DOI:</b> @if(!is_null($user->doi)){{ $user->doi }}@else{{ 'No Ingresado' }}@endif</span>
							</li>
							<li class="contacts-block__item">
								<span class="h6 text-black"><b>Dirección:</b> @if(!is_null($user->address)){{ $user->address }}@else{{ 'No Ingresado' }}@endif</span>
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
								<span class="h6 text-black"><b>Límite de Consultas Restante:</b> @if($codes->where('state', '1')->where('limit', '!=', NULL)->sum('limit')-$codes->where('state', '1')->where('limit', '!=', NULL)->sum('queries')>0){{ $codes->where('state', '1')->where('limit', '!=', NULL)->sum('limit')-$codes->where('state', '1')->where('limit', '!=', NULL)->sum('queries') }}@else{{ '0' }}@endif</span>
							</li>
							<li class="contacts-block__item">
								<a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Volver</a>
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
							@can('codes.create')
							<div class="text-right">
								<button type="button" class="btn btn-primary" onclick="addCode()">Agregar</button>
							</div>
							@endcan

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
											<th>MACs</th>
											<th>Estado</th>
											@if(auth()->user()->can('codes.edit') || auth()->user()->can('codes.active') || auth()->user()->can('codes.deactive') || auth()->user()->can('codes.revert') || auth()->user()->can('codes.delete'))
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
											<td>{{ $code['macs']->count().'/'.$code->qty_mac }}</td>
											<td>{!! state($code->state) !!}</td>
											@if(auth()->user()->can('codes.edit') || auth()->user()->can('codes.active') || auth()->user()->can('codes.deactive') || auth()->user()->can('codes.revert') || auth()->user()->can('codes.delete'))
											<td>
												<div class="btn-group" role="group">
													@can('codes.edit')
													<button type="button" class="btn btn-info btn-sm bs-tooltip" title="Editar" onclick="editCode('{{ $code->code }}', '{{ $code->name }}', '{{ $code->limit }}', @if(is_null($code->limit)){{ 'true' }}@else{{ 'false' }}@endif, {{ $code->qty_mac }})"><i class="fa fa-edit"></i></button>
													@endcan
													@if($code->state==1)
													@can('codes.deactive')
													<button type="button" class="btn btn-warning btn-sm bs-tooltip" title="Desactivar" onclick="deactiveCode('{{ $code->code }}')"><i class="fa fa-power-off"></i></button>
													@endcan
													@else
													@can('codes.active')
													<button type="button" class="btn btn-success btn-sm bs-tooltip" title="Activar" onclick="activeCode('{{ $code->code }}')"><i class="fa fa-check"></i></button>
													@endcan
													@endif
													@if($code['macs']->count()>0)
													@can('codes.revert')
													<button type="button" class="btn btn-warning btn-sm bs-tooltip" title="Revertir MAC" onclick="revertCode('{{ $code->code }}')"><i class="fas fa-history"></i></button>
													@endcan
													@endif
													@can('codes.delete')
													<button type="button" class="btn btn-danger btn-sm bs-tooltip" title="Eliminar" onclick="deleteCode('{{ $code->code }}')"><i class="fa fa-trash"></i></button>
													@endcan
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

@can('codes.create')
<div class="modal fade" id="createCode" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<form action="{{ route('codigos.store', ['user' => $user->slug]) }}" method="POST" class="modal-content" id="formCreateCodeModal">
			@csrf
			<div class="modal-header">
				<h5 class="modal-title">Agregar Código</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<h6 class="card-subtitle">Campos obligatorios (<b class="text-danger">*</b>)</h6>
				<div class="row">
					<div class="form-group col-12">
						<label class="col-form-label">Nombre<b class="text-danger">*</b></label>
						<input type="text" class="form-control @error('name') is-invalid @enderror" name="name" required placeholder="Introduzca el nombre">
					</div>

					<div class="form-group col-12">
						<label class="col-form-label">Límite<b class="text-danger">*</b> <button type="button" class="btn btn-sm btn-primary ml-2 px-2 py-1" id="limitInfinity"><i class="fa fa-infinity"></i></button></label>

						<div id="limitCreate">
							<input type="text" class="form-control number int @error('limit') is-invalid @enderror" name="limit" required placeholder="Introduzca el límite de consultas" value="1000">
						</div>

						<input type="text" class="form-control d-none" disabled value="Ilimitadas" id="infinityCreate">
					</div>

					<div class="form-group col-12">
						<label class="col-form-label">Cantidad de MACs<b class="text-danger">*</b></label>
						<input class="form-control min-int @error('qty_mac') is-invalid @enderror" type="text" name="qty_mac" required placeholder="Introduzca la cantidad de macs" value="1">
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="sumit" class="btn btn-primary" action="code">Guardar</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
			</div>
		</form>
	</div>
</div>
@endcan

@can('codes.edit')
<div class="modal fade" id="editCode" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<form action="#" method="POST" class="modal-content" id="formEditCodeModal">
			@csrf
			@method('PUT')
			<div class="modal-header">
				<h5 class="modal-title">Editar Código</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<h6 class="card-subtitle">Campos obligatorios (<b class="text-danger">*</b>)</h6>
				<div class="row">
					<div class="form-group col-12">
						<label class="col-form-label">Código<b class="text-danger">*</b></label>
						<input type="text" class="form-control" name="code" disabled placeholder="Código">
					</div>

					<div class="form-group col-12">
						<label class="col-form-label">Nombre<b class="text-danger">*</b></label>
						<input type="text" class="form-control @error('name') is-invalid @enderror" name="name" required placeholder="Introduzca el nombre">
					</div>

					<div class="form-group col-12">
						<label class="col-form-label">Límite<b class="text-danger">*</b> <button type="button" class="btn btn-sm btn-primary ml-2 px-2 py-1" id="limitInfinityEdit"><i class="fa fa-infinity"></i></button></label>

						<div id="limitEdit">
							<input type="text" class="form-control number int @error('limit') is-invalid @enderror" name="limit" placeholder="Introduzca el límite de consultas" value="1000">
						</div>

						<input type="text" class="form-control d-none" disabled value="Ilimitadas" id="infinityEdit">
					</div>

					<div class="form-group col-12">
						<label class="col-form-label">Cantidad de MACs<b class="text-danger">*</b></label>
						<input class="form-control min-int @error('qty_mac') is-invalid @enderror" type="text" name="qty_mac" required placeholder="Introduzca la cantidad de macs" value="1">
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="sumit" class="btn btn-primary" action="code">Actualizar</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
			</div>
		</form>
	</div>
</div>
@endcan

@can('codes.deactive')
<div class="modal fade" id="deactiveCode" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">¿Estás seguro de que quieres desactivar este código?</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn" data-dismiss="modal">Cancelar</button>
				<form action="#" method="POST" id="formDeactiveCode">
					@csrf
					@method('PUT')
					<button type="submit" class="btn btn-primary">Desactivar</button>
				</form>
			</div>
		</div>
	</div>
</div>
@endcan

@can('codes.active')
<div class="modal fade" id="activeCode" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">¿Estás seguro de que quieres activar este código?</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn" data-dismiss="modal">Cancelar</button>
				<form action="#" method="POST" id="formActiveCode">
					@csrf
					@method('PUT')
					<button type="submit" class="btn btn-primary">Activar</button>
				</form>
			</div>
		</div>
	</div>
</div>
@endcan

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

@can('codes.delete')
<div class="modal fade" id="deleteCode" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">¿Estás seguro de que quieres eliminar este código?</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn" data-dismiss="modal">Cancelar</button>
				<form action="#" method="POST" id="formDeleteCode">
					@csrf
					@method('DELETE')
					<button type="submit" class="btn btn-primary">Eliminar</button>
				</form>
			</div>
		</div>
	</div>
</div>
@endcan

@endsection

@section('scripts')
<script src="{{ asset('/admins/vendor/touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>
<script src="{{ asset('/admins/vendor/table/datatable/datatables.js') }}"></script>
<script src="{{ asset('/admins/vendor/table/datatable/button-ext/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('/admins/vendor/table/datatable/button-ext/jszip.min.js') }}"></script>    
<script src="{{ asset('/admins/vendor/table/datatable/button-ext/buttons.html5.min.js') }}"></script>
<script src="{{ asset('/admins/vendor/table/datatable/button-ext/buttons.print.min.js') }}"></script>
<script src="{{ asset('/admins/vendor/validate/jquery.validate.js') }}"></script>
<script src="{{ asset('/admins/vendor/validate/additional-methods.js') }}"></script>
<script src="{{ asset('/admins/vendor/validate/messages_es.js') }}"></script>
<script src="{{ asset('/admins/js/validate.js') }}"></script>
<script src="{{ asset('/admins/vendor/sweetalerts/sweetalert2.min.js') }}"></script>
<script src="{{ asset('/admins/vendor/sweetalerts/custom-sweetalert.js') }}"></script>
<script src="{{ asset('/admins/vendor/lobibox/Lobibox.js') }}"></script>
@endsection