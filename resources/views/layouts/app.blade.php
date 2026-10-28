
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#283845">

    <title>@yield('title','Primera Comunión') · Sistema de Registro</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body class="{{ auth()->check() ? 'authenticated' : 'guest' }}">

<header class="top">
    <div class="top-inner">

        <a class="brand" href="{{ auth()->check() ? route('dashboard') : route('login') }}">
            <span>
                <strong>Primera Comunión</strong>
                <small>Sistema de registro</small>
            </span>
        </a>

        @auth

        <nav aria-label="Navegación principal">

            <a class="{{ request()->routeIs('dashboard') ? 'active' : '' }}"
               href="{{ route('dashboard') }}">
                Inicio
            </a>

            <a class="{{ request()->routeIs('aspirantes.*') ? 'active' : '' }}"
               href="{{ route('aspirantes.index') }}">
                Aspirantes
            </a>

            @if(auth()->user()->rol !== 'catequista')

                <a href="{{ route('catalogos.index','grupos') }}">
                    Grupos
                </a>

                <a href="{{ route('catalogos.index','catequistas') }}">
                    Catequistas
                </a>

            @endif

            @if(auth()->user()->rol === 'administrador')

                <a href="{{ route('catalogos.index','documentos') }}">
                    Documentos
                </a>

                <a href="{{ route('usuarios.index') }}">
                    Usuarios
                </a>

            @endif

        </nav>

        <div class="user-actions">

            <span class="user-chip">

                <span class="user-avatar">
                    {{ mb_strtoupper(mb_substr(auth()->user()->name,0,1)) }}
                </span>

                <span class="user-name">
                    {{ auth()->user()->name }}
                </span>

            </span>

            <form action="{{ route('logout') }}" method="post">
                @csrf

                <button type="submit" class="light">
                    Salir
                </button>
            </form>

        </div>

        @endauth

    </div>
</header>

<main class="container">

    @if(session('ok'))
        <div class="alert success">
            {{ session('ok') }}
        </div>
    @endif

    @if($errors->any())

        <div class="alert danger">

            <strong>Revisa la información:</strong>

            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>

    @endif

    @yield('content')

</main>

</body>
</html>
