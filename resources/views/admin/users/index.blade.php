@extends('layouts.admin')

@section('title', 'Lista de Usuarios')

@section('links')
<link rel="stylesheet" type="text/css" href="{{ asset('/admins/vendor/table/datatable/datatables.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('/admins/vendor/table/datatable/custom_dt_html5.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('/admins/vendor/table/datatable/dt-global_style.css') }}">
<link href="{{ asset('/admins/vendor/sweetalerts/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('/admins/vendor/sweetalerts/sweetalert.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('/admins/css/components/custom-sweetalert.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{{ asset('/admins/vendor/lobibox/Lobibox.min.css') }}">
@endsection

@section('content')

<div class="row layout-top-spacing">

	<div class="col-12 layout-spacing">
		<div class="statbox widget box box-shadow">
			<div class="widget-header">
				<div class="row">
					<div class="col-xl-12 col-md-12 col-sm-12 col-12">
						<h4>Lista de Usuarios</h4>
					</div>                 
				</div>
			</div>
			<div class="widget-content widget-content-area shadow-none">

				<div class="row">
					<div class="col-12">
						@can('users.create')
						<div class="text-right">
							<a href="{{ route('usuarios.create') }}" class="btn btn-primary">Agregar</a>
						</div>
						@endcan

						<div class="table-responsive mb-4 mt-4">
							<table class="table table-hover table-export">
								<thead>
									<tr>
										<th>#</th>
										<th>Nombre Completo</th>
										<th>Correo</th>
										<th>Teléfono</th>
										<th>Tipo</th>
										<th>Estado</th>
										@if(auth()->user()->can('users.show') || auth()->user()->can('users.edit') || auth()->user()->can('users.active') || auth()->user()->can('users.deactive') || auth()->user()->can('users.delete'))
										<th>Acciones</th>
										@endif
									</tr>
								</thead>
								<tbody>
									@foreach($users as $user)
									<tr>
										<td>{{ $loop->iteration }}</td>
										<td class="d-flex">
											<img src="{{ image_exist('/admins/img/users/', $user->photo, true) }}" class="rounded-circle mr-2" width="45" height="45" alt="{{ $user->name." ".$user->lastname }}" title="{{ $user->name." ".$user->lastname }}"> {{ $user->name." ".$user->lastname }}
										</td>
										<td>{{ $user->email }}</td>
										<td>{{ $user->phone }}</td>
										<td>{!! roleUser($user) !!}</td>
										<td>{!! state($user->state) !!}</td>
										@if(auth()->user()->can('users.show') || auth()->user()->can('users.edit') || auth()->user()->can('users.active') || auth()->user()->can('users.deactive') || auth()->user()->can('users.delete'))
										<td>
											<div class="btn-group" role="group">
												@can('users.show')
												<a href="{{ route('usuarios.show', ['user' => $user->slug]) }}" class="btn btn-primary btn-sm bs-tooltip" title="Perfil"><i class="fa fa-user"></i></a>
												@endcan
												@can('users.edit')
												<a href="{{ route('usuarios.edit', ['user' => $user->slug]) }}" class="btn btn-info btn-sm bs-tooltip" title="Editar"><i class="fa fa-edit"></i></a>
												@endcan
												@if(Auth::user()->id!=$user->id)
												@if($user->state==1)
												@can('users.deactive')
												<button type="button" class="btn btn-warning btn-sm bs-tooltip" title="Desactivar" onclick="deactiveUser('{{ $user->slug }}')"><i class="fa fa-power-off"></i></button>
												@endcan
												@else
												@can('users.active')
												<button type="button" class="btn btn-success btn-sm bs-tooltip" title="Activar" onclick="activeUser('{{ $user->slug }}')"><i class="fa fa-check"></i></button>
												@endcan
												@endif
												@can('users.delete')
												@if(!$user->hasRole('Super Admin') || ($user->hasRole('Super Admin') && Auth::user()->hasRole('Super Admin')))
												<button type="button" class="btn btn-danger btn-sm bs-tooltip" title="Eliminar" onclick="deleteUser('{{ $user->slug }}')"><i class="fa fa-trash"></i></button>
												@endif
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

@can('users.deactive')
<div class="modal fade" id="deactiveUser" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">¿Estás seguro de que quieres desactivar este usuario?</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn" data-dismiss="modal">Cancelar</button>
				<form action="#" method="POST" id="formDeactiveUser">
					@csrf
					@method('PUT')
					<button type="submit" class="btn btn-primary">Desactivar</button>
				</form>
			</div>
		</div>
	</div>
</div>
@endcan

@can('users.active')
<div class="modal fade" id="activeUser" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">¿Estás seguro de que quieres activar este usuario?</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn" data-dismiss="modal">Cancelar</button>
				<form action="#" method="POST" id="formActiveUser">
					@csrf
					@method('PUT')
					<button type="submit" class="btn btn-primary">Activar</button>
				</form>
			</div>
		</div>
	</div>
</div>
@endcan

@can('users.delete')
<div class="modal fade" id="deleteUser" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">¿Estás seguro de que quieres eliminar este usuario?</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn" data-dismiss="modal">Cancelar</button>
				<form action="#" method="POST" id="formDeleteUser">
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
<script src="{{ asset('/admins/vendor/table/datatable/datatables.js') }}"></script>
<script src="{{ asset('/admins/vendor/table/datatable/button-ext/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('/admins/vendor/table/datatable/button-ext/jszip.min.js') }}"></script>    
<script src="{{ asset('/admins/vendor/table/datatable/button-ext/buttons.html5.min.js') }}"></script>
<script src="{{ asset('/admins/vendor/table/datatable/button-ext/buttons.print.min.js') }}"></script>
<script src="{{ asset('/admins/vendor/sweetalerts/sweetalert2.min.js') }}"></script>
<script src="{{ asset('/admins/vendor/sweetalerts/custom-sweetalert.js') }}"></script>
<script src="{{ asset('/admins/vendor/lobibox/Lobibox.js') }}"></script>
@endsection