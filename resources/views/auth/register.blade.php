@extends('layouts.auth')

@section('title', 'Registro de Usuario')

@section('content')

<div class="form-container outer bg-primary">
    <div class="form-form">
        <div class="form-form-wrap">
            <div class="form-container">
                <div class="form-content">

                    <h1 class="">Registro de Usuario</h1>

                    <form class="text-left" action="{{ route('register') }}" method="POST" id="formRegister">
                        {{ csrf_field() }}

                        @include('admin.partials.errors')
                        
                        <div class="form">
                            <div class="field-wrapper input">
                                <label for="username">NOMBRE</label>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                <input id="username" name="name" type="text" class="form-control @error('name') is-invalid @enderror" required placeholder="Carlos" value="{{ old('name') }}" minlength="2" maxlength="191">
                            </div>

                            <div class="field-wrapper input">
                                <label for="lastname">APELLIDO</label>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                <input id="lastname" name="lastname" type="text" class="form-control @error('lastname') is-invalid @enderror" required placeholder="García" value="{{ old('lastname') }}" minlength="2" maxlength="191">
                            </div>

                            <div id="username-field" class="field-wrapper input">
                                <label for="email">CORREO</label>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" required placeholder="{{ 'correo@gmail.com' }}" value="{{ old('email') }}" minlength="5" maxlength="191">
                            </div>

                            <div id="password-field" class="field-wrapper input mb-2">
                                <label for="password">CONTRASEÑA</label>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                                <input id="password" name="password" type="password" class="form-control @error('password') is-invalid @enderror" required placeholder="********" minlength="8" maxlength="40">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" id="toggle-password" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                            </div>
                            <div class="form-group mb-2">
                                <input type="checkbox" name="terms" required id="terms-conditions">
                                <label class="text-body small mb-0" for="terms-conditions">Acepto <a href="javascript:void(0);" class="text-primary" data-dismiss="modal" data-toggle="modal" data-target="#modal-terms">Términos y condiciones</a></label>
                            </div>
                            <div class="d-sm-flex justify-content-between">
                                <div class="field-wrapper">
                                    <button type="submit" class="btn btn-primary font-weight-bold" action="register">Registrate</button>
                                </div>
                            </div>

                            <div class="d-sm-flex justify-content-center mt-3">
                                <div class="field-wrapper">
                                    <p class="text-center">Deseas ingresar? <a href="{{ route('login') }}" class="text-primary m-l-5"><b>Ingresa</b></a></p>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>                    
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-terms" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Términos y Condiciones</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="height: 70vh; overflow-y: scroll;">
                <div class="row">
                    <div class="col-12">
                        {{-- {!! $setting->terms !!} --}}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger rounded" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

@endsection