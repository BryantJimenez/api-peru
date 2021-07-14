@extends('layouts.auth')

@section('title', 'Restaurar Contraseña')

@section('content')

<div class="form-container bg-primary outer">
    <div class="form-form">
        <div class="form-form-wrap">
            <div class="form-container">
                <div class="form-content">

                    <h1 class="">Restaurar Contraseña</h1>

                    <form class="text-left" action="{{ route('password.update') }}" method="POST" id="formReset">
                        {{ csrf_field() }}

                        @include('admin.partials.errors')

                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="form">

                            <div id="username-field" class="field-wrapper input">
                                <label for="email">CORREO</label>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="{{ 'correo@gmail.com' }}" autocomplete="email" autofocus value="{{ old('email') }}" minlength="5" maxlength="191">
                            </div>

                            <div id="password-field" class="field-wrapper input mb-2">
                                <div class="d-flex justify-content-between">
                                    <label for="password">NUEVA CONTRASEÑA</label>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                                <input id="password" name="password" type="password" class="form-control  @error('password') is-invalid @enderror" placeholder="********" autocomplete="new-password" minlength="8" maxlength="40">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" id="toggle-password" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                            </div>

                            <div class="field-wrapper input mb-2">
                                <div class="d-flex justify-content-between">
                                    <label for="password_confirm">CONFIRMAR CONTRASEÑA</label>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="********" autocomplete="new-password" minlength="8" maxlength="40">
                            </div>

                            <div class="d-sm-flex justify-content-between">
                                <div class="field-wrapper">
                                    <button type="submit" class="btn btn-primary" action="reset">Enviar</button>
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

@endsection