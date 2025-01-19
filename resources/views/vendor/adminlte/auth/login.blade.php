@extends('adminlte::auth.auth-page', ['auth_type' => 'login'])

@section('adminlte_css_pre')
    <link rel="stylesheet" href="{{ asset('vendor/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    {{-- Adição de estilos personalizados para deixar o login mais moderno --}}
    <style>
        body {
            background: url('/images/fundo-login.png') no-repeat center center fixed;
            background-size: cover;
            position: relative;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }


        .card {
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .login-logo a {
            color: #fafafa;
            font-size: 28px;
            font-weight: bold;
        }

        .input-group-text {
            background-color: #f0f0f0;
        }

        .form-control {
            border-radius: 0;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .icheck-primary>input:first-child:checked~label::before {
            background-color: #007bff;
            border-color: #007bff;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            color: #0056b3;
        }
    </style>
@stop

@php($login_url = View::getSection('login_url') ?? config('adminlte.login_url', 'login'))
@php($register_url = View::getSection('register_url') ?? config('adminlte.register_url', 'register'))
@php($password_reset_url = View::getSection('password_reset_url') ?? config('adminlte.password_reset_url', 'password/reset'))

@if (config('adminlte.use_route_url', false))
    @php($login_url = $login_url ? route($login_url) : '')
    @php($register_url = $register_url ? route($register_url) : '')
    @php($password_reset_url = $password_reset_url ? route($password_reset_url) : '')
@else
    @php($login_url = $login_url ? url($login_url) : '')
    @php($register_url = $register_url ? url($register_url) : '')
    @php($password_reset_url = $password_reset_url ? url($password_reset_url) : '')
@endif

@section('auth_header', 'Entre para iniciar uma nova sessão')

@section('auth_body')
    <form action="{{ $login_url }}" method="post">
        @csrf

        {{-- Campo de email --}}
        <div class="input-group mb-3">
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email') }}" placeholder="Email" autofocus>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope {{ config('adminlte.classes_auth_icon', '') }}"></span>
                </div>
            </div>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        {{-- Campo de senha --}}
        <div class="input-group mb-3">
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                placeholder="Senha">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>
                </div>
            </div>
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        {{-- Lembrar-me e botão de login --}}
        <div class="row">
            <div class="col-7">
                <div class="icheck-primary" title="{{ __('adminlte::adminlte.remember_me_hint') }}">
                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label for="remember">
                        Lembrar-me
                    </label>
                </div>
            </div>
            <div class="col-5">
                <button type="submit"
                    class="btn btn-block {{ config('adminlte.classes_auth_btn', 'btn-flat btn-primary') }}">
                    <span class="fas fa-sign-in-alt"></span> Entrar
                </button>
            </div>
        </div>
    </form>
@stop

@section('auth_footer')
    {{-- Link para recuperar senha --}}
    @if ($password_reset_url)
        <p class="my-0">
            <a href="{{ $password_reset_url }}">
                Esqueci minha senha
            </a>
        </p>
    @endif

    {{-- Link para registro --}}
    @if ($register_url)
        <p class="my-0">
            <a href="{{ $register_url }}">
                Registrar um novo membro
            </a>
        </p>
    @endif
@stop
