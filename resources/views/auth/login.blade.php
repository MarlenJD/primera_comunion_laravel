
@extends('layouts.app')
@section('title','Iniciar sesión')

@section('content')
<div class="login-shell">
    <div class="login-intro">
        <div class="eyebrow">PLATAFORMA DE ADMINISTRACIÓN</div>
        <div class="login-symbol">✦</div>

        <h1>Organización y seguimiento de cada inscripción.</h1>

        <p>
            Una plataforma diseñada para administrar aspirantes,
            documentos y grupos de catequesis con claridad y seguridad.
        </p>

        <div class="login-intro-foot">
            SISTEMA DE REGISTRO · PRIMERA COMUNIÓN
        </div>
    </div>

    <div class="login-panel">
        <div class="login card">
            <div class="eyebrow">ACCESO AL SISTEMA</div>
            <h2>Iniciar sesión</h2>
            <p>Ingresa tus credenciales para continuar.</p>

            <form method="post" action="{{ route('login') }}">
                @csrf

                <label>
                    Correo electrónico
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="correo@ejemplo.com"
                        autocomplete="username"
                        required
                        autofocus
                    >
                </label>

                <label>
                    Contraseña
                    <input
                        type="password"
                        name="password"
                        placeholder="Ingresa tu contraseña"
                        autocomplete="current-password"
                        required
                    >
                </label>

                <button type="submit">
                    Ingresar al sistema <span>→</span>
                </button>
            </form>

            <div class="login-note">
                Acceso exclusivo para personal autorizado.
            </div>
        </div>
    </div>
</div>
@endsection
