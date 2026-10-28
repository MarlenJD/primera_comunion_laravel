
@extends('layouts.app')

@section('title', $titulo)

@section('content')

@php
    $columnas = array_keys($rules);

    $etiquetas = [
        'nombre' => 'Nombre',
        'horario' => 'Horario',
        'lugar' => 'Lugar',
        'catequista_id' => 'Catequista',
        'telefono' => 'Teléfono',
        'correo' => 'Correo electrónico',
        'obligatorio' => 'Obligatorio'
    ];
@endphp

<div class="heading page-heading">
    <div>
        <div class="eyebrow">ADMINISTRACIÓN DE CATÁLOGOS</div>
        <h1>{{ $titulo }}</h1>
        <p>Consulta y administra los registros de {{ strtolower($titulo) }}.</p>
    </div>

    <button type="button" data-open-modal="nuevo-registro">
        + Nuevo registro
    </button>
</div>

<div class="card list-card">

    <div class="list-toolbar">
        <div>
            <h2>Registros existentes</h2>
            <p>{{ $items->total() }} registros en total</p>
        </div>

        <label class="search-box">
            Buscar
            <input
                type="search"
                data-table-search="catalogos-tabla"
                placeholder="Buscar en esta página..."
            >
        </label>
    </div>

    <div class="scroll">
        <table id="catalogos-tabla">
            <thead>
                <tr>
                    @foreach($columnas as $campo)
                        <th>
                            {{ $etiquetas[$campo] ?? ucfirst(str_replace('_', ' ', $campo)) }}
                        </th>
                    @endforeach

                    <th class="actions-column">Acciones</th>
                </tr>
            </thead>

            <tbody>
                @forelse($items as $item)
                    <tr>
                        @foreach($columnas as $campo)
                            <td>
                                @if($campo === 'catequista_id')
                                    {{ $catequistas->firstWhere('id', $item->catequista_id)?->nombre ?? 'Sin asignar' }}
                                @elseif($campo === 'obligatorio')
                                    <span class="tag {{ $item->obligatorio ? 'status-confirmada' : 'status-pendiente' }}">
                                        {{ $item->obligatorio ? 'Sí' : 'No' }}
                                    </span>
                                @else
                                    {{ $item->$campo ?: '—' }}
                                @endif
                            </td>
                        @endforeach

                        <td>
                            <div class="table-actions">
                                <button
                                    type="button"
                                    class="button secondary small-button"
                                    data-open-modal="editar-{{ $item->id }}"
                                >
                                    Editar
                                </button>

                                <form
                                    action="{{ route('catalogos.destroy', [$tipo, $item->id]) }}"
                                    method="post"
                                    onsubmit="return confirm('¿Eliminar este registro?')"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="danger-button small-button">
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ count($columnas) + 1 }}" class="empty-state">
                            Todavía no hay registros.
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

<div class="modal-backdrop" id="nuevo-registro" hidden>
    <div class="modal-panel" role="dialog" aria-modal="true" aria-labelledby="nuevo-titulo">

        <div class="modal-heading">
            <div>
                <div class="eyebrow">{{ $titulo }}</div>
                <h2 id="nuevo-titulo">Agregar registro</h2>
            </div>

            <button type="button" class="icon-button" data-close-modal aria-label="Cerrar">
                ×
            </button>
        </div>

        <form method="post" action="{{ route('catalogos.store', $tipo) }}">
            @csrf

            <div class="fields">
                @foreach($rules as $campo => $regla)
                    <label>
                        {{ $etiquetas[$campo] ?? ucfirst(str_replace('_', ' ', $campo)) }}
                        @if(str_contains($regla, 'required')) * @endif

                        @if($campo === 'catequista_id')
                            <select name="catequista_id">
                                <option value="">Sin asignar</option>

                                @foreach($catequistas as $c)
                                    <option
                                        value="{{ $c->id }}"
                                        @selected(old('catequista_id') == $c->id)
                                    >
                                        {{ $c->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        @elseif($campo === 'obligatorio')
                            <select name="obligatorio">
                                <option value="1" @selected(old('obligatorio', '1') == '1')>
                                    Sí
                                </option>
                                <option value="0" @selected(old('obligatorio') === '0')>
                                    No
                                </option>
                            </select>
                        @else
                            <input
                                name="{{ $campo }}"
                                type="{{ $campo === 'correo' ? 'email' : 'text' }}"
                                value="{{ old($campo) }}"
                                @if(str_contains($regla, 'required')) required @endif
                            >
                        @endif
                    </label>
                @endforeach
            </div>

            <div class="modal-actions">
                <button type="button" class="button secondary" data-close-modal>
                    Cancelar
                </button>

                <button type="submit">Guardar registro</button>
            </div>
        </form>
    </div>
</div>

@foreach($items as $item)
    <div class="modal-backdrop" id="editar-{{ $item->id }}" hidden>
        <div class="modal-panel" role="dialog" aria-modal="true" aria-labelledby="editar-titulo-{{ $item->id }}">

            <div class="modal-heading">
                <div>
                    <div class="eyebrow">{{ $titulo }}</div>
                    <h2 id="editar-titulo-{{ $item->id }}">Editar registro</h2>
                </div>

                <button type="button" class="icon-button" data-close-modal aria-label="Cerrar">
                    ×
                </button>
            </div>

            <form method="post" action="{{ route('catalogos.update', [$tipo, $item->id]) }}">
                @csrf
                @method('PUT')

                <div class="fields">
                    @foreach($rules as $campo => $regla)
                        <label>
                            {{ $etiquetas[$campo] ?? ucfirst(str_replace('_', ' ', $campo)) }}
                            @if(str_contains($regla, 'required')) * @endif

                            @if($campo === 'catequista_id')
                                <select name="catequista_id">
                                    <option value="">Sin asignar</option>

                                    @foreach($catequistas as $c)
                                        <option
                                            value="{{ $c->id }}"
                                            @selected($item->catequista_id == $c->id)
                                        >
                                            {{ $c->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            @elseif($campo === 'obligatorio')
                                <select name="obligatorio">
                                    <option value="1" @selected($item->obligatorio)>
                                        Sí
                                    </option>
                                    <option value="0" @selected(!$item->obligatorio)>
                                        No
                                    </option>
                                </select>
                            @else
                                <input
                                    name="{{ $campo }}"
                                    type="{{ $campo === 'correo' ? 'email' : 'text' }}"
                                    value="{{ $item->$campo }}"
                                    @if(str_contains($regla, 'required')) required @endif
                                >
                            @endif
                        </label>
                    @endforeach
                </div>

                <div class="modal-actions">
                    <button type="button" class="button secondary" data-close-modal>
                        Cancelar
                    </button>

                    <button type="submit">Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>
@endforeach

@include('partials.admin-ui')

@endsection
