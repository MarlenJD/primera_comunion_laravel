
@extends('layouts.app')

@section('title', 'Aspirantes')

@section('content')

<div class="heading page-heading">
    <div>
        <div class="eyebrow">INSCRIPCIONES</div>

        <h1>
            {{ auth()->user()->rol === 'catequista' ? 'Mis aspirantes' : 'Aspirantes' }}
        </h1>

        <p>Consulta y seguimiento de las inscripciones a Primera Comunión.</p>
    </div>

    <div class="actions">
        @if(auth()->user()->rol !== 'catequista')
            <a class="button secondary" href="{{ route('aspirantes.reporte') }}">
                Exportar CSV
            </a>

            <a class="button" href="{{ route('aspirantes.create') }}">
                + Nuevo aspirante
            </a>
        @endif
    </div>
</div>

<form method="get" class="card filters">
    <label class="filter-field">
        Buscar por nombre
        <input
            name="buscar"
            value="{{ request('buscar') }}"
            placeholder="Nombre del aspirante"
        >
    </label>

    <label class="filter-field">
        Estado
        <select name="estado">
            <option value="">Todos los estados</option>

            @foreach(['pendiente', 'en_revision', 'confirmada'] as $estado)
                <option
                    value="{{ $estado }}"
                    @selected(request('estado') === $estado)
                >
                    {{ ucfirst(str_replace('_', ' ', $estado)) }}
                </option>
            @endforeach
        </select>
    </label>

    <button type="submit">Aplicar filtros</button>

    <a class="button secondary" href="{{ route('aspirantes.index') }}">
        Limpiar
    </a>
</form>

<div class="card list-card">

    <div class="list-toolbar">
        <div>
            <h2>Registros existentes</h2>
            <p>{{ $items->total() }} aspirantes encontrados</p>
        </div>
    </div>

    <div class="scroll">
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Nacimiento</th>
                    <th>Tutor</th>
                    <th>Grupo</th>
                    <th>Estado</th>
                    <th class="actions-column">Acciones</th>
                </tr>
            </thead>

            <tbody>
                @forelse($items as $aspirante)
                    <tr>
                        <td>
                            <strong>{{ $aspirante->nombre }}</strong>
                        </td>

                        <td>{{ $aspirante->fecha_nacimiento }}</td>

                        <td>
                            {{ $aspirante->tutor?->nombre ?? '—' }}
                        </td>

                        <td>
                            {{ $aspirante->grupo?->nombre ?? 'Sin asignar' }}
                        </td>

                        <td>
                            <span class="tag status-{{ $aspirante->estado }}">
                                {{ ucfirst(str_replace('_', ' ', $aspirante->estado)) }}
                            </span>
                        </td>

                        <td>
                            <div class="table-actions">
                                <a
                                    class="button secondary small-button"
                                    href="{{ route('aspirantes.show', $aspirante) }}"
                                >
                                    Consultar
                                </a>

                                @if(auth()->user()->rol !== 'catequista')
                                    <a
                                        class="button secondary small-button"
                                        href="{{ route('aspirantes.edit', $aspirante) }}"
                                    >
                                        Editar
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="empty-state">
                            No se encontraron aspirantes con estos filtros.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-area">
        {{ $items->links() }}
    </div>
</div>

@endsection
