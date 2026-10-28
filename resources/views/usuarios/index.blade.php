
@extends('layouts.app')

@section('title', 'Usuarios')

@section('content')

<div class="heading page-heading">
    <div>
        <div class="eyebrow">ADMINISTRACIÓN</div>
        <h1>Usuarios del sistema</h1>
        <p>Gestiona las cuentas y los roles de acceso.</p>
    </div>

    <button type="button" data-open-modal="nuevo-usuario">
        + Nuevo usuario
    </button>
</div>

<div class="card list-card">
    <div class="list-toolbar">
        <div>
            <h2>Usuarios registrados</h2>
            <p>{{ $items->count() }} cuentas registradas</p>
        </div>

        <label class="search-box">
            Buscar
            <input
                type="search"
                data-table-search="usuarios-tabla"
                placeholder="Nombre, correo o rol..."
            >
        </label>
    </div>

    <div class="scroll">
        <table id="usuarios-tabla">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Correo electrónico</th>
                    <th>Rol</th>
                    <th class="actions-column">Acciones</th>
                </tr>
            </thead>

            <tbody>
                @forelse($items as $u)
                    <tr>
                        <td><strong>{{ $u->name }}</strong></td>
                        <td>{{ $u->email }}</td>

                        <td>
                            <span class="tag">
                                {{ ucfirst($u->rol) }}
                            </span>
                        </td>

                        <td>
                            @if($u->id !== auth()->id())
                                <form
                                    method="post"
                                    action="{{ route('usuarios.destroy', $u) }}"
                                    onsubmit="return confirm('¿Eliminar esta cuenta?')"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="danger-button small-button">
                                        Eliminar
                                    </button>
                                </form>
                            @else
                                <span class="tag status-confirmada">
                                    Tu cuenta
                                </span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="empty-state">
                            No hay usuarios registrados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="modal-backdrop" id="nuevo-usuario" hidden>
    <div class="modal-panel" role="dialog" aria-modal="true" aria-labelledby="titulo-usuario">

        <div class="modal-heading">
            <div>
                <div class="eyebrow">ACCESO AL SISTEMA</div>
                <h2 id="titulo-usuario">Crear usuario</h2>
            </div>

            <button type="button" class="icon-button" data-close-modal aria-label="Cerrar">
                ×
            </button>
        </div>

        <form method="post" action="{{ route('usuarios.store') }}">
            @csrf

            <div class="fields">
                <label>
                    Nombre completo *
                    <input
                        name="name"
                        value="{{ old('name') }}"
                        required
                    >
                </label>

                <label>
                    Correo electrónico *
                    <input
                        name="email"
                        type="email"
                        value="{{ old('email') }}"
                        required
                    >
                </label>

                <label>
                    Contraseña *
                    <input
                        name="password"
                        type="password"
                        minlength="10"
                        required
                    >
                </label>

                <label>
                    Rol *
                    <select name="rol" required>
                        @foreach(['administrador', 'encargado', 'coordinador', 'catequista'] as $rol)
                            <option
                                value="{{ $rol }}"
                                @selected(old('rol') === $rol)
                            >
                                {{ ucfirst($rol) }}
                            </option>
                        @endforeach
                    </select>
                </label>

                @if(isset($catequistas))
                    <label class="wide" id="vinculo-catequista">
                        Catequista vinculada
                        <select name="catequista_id" id="catequista_id">
                            <option value="">Seleccionar catequista</option>

                            @foreach($catequistas as $c)
                                <option
                                    value="{{ $c->id }}"
                                    @selected(old('catequista_id') == $c->id)
                                >
                                    {{ $c->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </label>
                @endif
            </div>

            <div class="modal-actions">
                <button type="button" class="button secondary" data-close-modal>
                    Cancelar
                </button>

                <button type="submit">
                    Crear usuario
                </button>
            </div>
        </form>
    </div>
</div>

@include('partials.admin-ui')

@endsection
