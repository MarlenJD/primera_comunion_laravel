
@extends('layouts.app')

@section('title', 'Ficha de aspirante')

@section('content')

<div class="heading page-heading">
    <div>
        <div class="eyebrow">EXPEDIENTE DE INSCRIPCIÓN</div>
        <h1>{{ $item->nombre }}</h1>
        <p>Información general y seguimiento del expediente.</p>

        <span class="tag status-{{ $item->estado }}">
            {{ ucfirst(str_replace('_', ' ', $item->estado)) }}
        </span>
    </div>

    <div class="actions">
        <a class="button secondary" href="{{ route('aspirantes.index') }}">
            Volver
        </a>

        @if(auth()->user()->rol !== 'catequista')
            <a class="button" href="{{ route('aspirantes.edit', $item) }}">
                Editar expediente
            </a>
        @endif
    </div>
</div>

<div class="columns detail-columns">

    <section class="card">
        <div class="section-heading">
            <span class="step-number">01</span>

            <div>
                <h2>Datos del aspirante</h2>
                <p>Información personal y catequesis</p>
            </div>
        </div>

        <dl class="detail-grid">
            <div>
                <dt>Fecha de nacimiento</dt>
                <dd>{{ $item->fecha_nacimiento }}</dd>
            </div>

            <div>
                <dt>Fecha de inscripción</dt>
                <dd>{{ $item->fecha_inscripcion }}</dd>
            </div>

            <div>
                <dt>Domicilio</dt>
                <dd>{{ $item->domicilio }}</dd>
            </div>

            <div>
                <dt>Bautismo</dt>
                <dd>{{ $item->bautismo ?: 'No especificado' }}</dd>
            </div>

            <div>
                <dt>Grupo</dt>
                <dd>{{ $item->grupo?->nombre ?? 'Sin asignar' }}</dd>
            </div>

            <div>
                <dt>Catequista</dt>
                <dd>{{ $item->grupo?->catequista?->nombre ?? 'Sin asignar' }}</dd>
            </div>

            <div class="wide">
                <dt>Observaciones</dt>
                <dd>{{ $item->observaciones ?: 'Sin observaciones' }}</dd>
            </div>
        </dl>
    </section>

    <section class="card">
        <div class="section-heading">
            <span class="step-number">02</span>

            <div>
                <h2>Responsable</h2>
                <p>Padre, madre o tutor</p>
            </div>
        </div>

        <dl class="detail-grid">
            <div>
                <dt>Nombre</dt>
                <dd>{{ $item->tutor?->nombre ?? '—' }}</dd>
            </div>

            <div>
                <dt>Parentesco</dt>
                <dd>{{ ucfirst($item->tutor?->parentesco ?? '—') }}</dd>
            </div>

            <div>
                <dt>Teléfono</dt>
                <dd>{{ $item->tutor?->telefono ?? '—' }}</dd>
            </div>

            <div>
                <dt>Domicilio</dt>
                <dd>{{ $item->tutor?->domicilio ?: 'No especificado' }}</dd>
            </div>
        </dl>

        @if(auth()->user()->rol !== 'catequista')
            <div class="status-editor">
                <h2>Estado de inscripción</h2>

                <form
                    method="post"
                    action="{{ route('aspirantes.estado', $item) }}"
                >
                    @csrf
                    @method('PATCH')

                    <label>
                        Estado actual
                        <select name="estado">
                            @foreach(['pendiente', 'en_revision', 'confirmada'] as $estado)
                                <option
                                    value="{{ $estado }}"
                                    @selected($item->estado === $estado)
                                >
                                    {{ ucfirst(str_replace('_', ' ', $estado)) }}
                                </option>
                            @endforeach
                        </select>
                    </label>

                    <button type="submit">
                        Actualizar estado
                    </button>
                </form>
            </div>
        @endif
    </section>
</div>

<section class="card">
    <div class="section-heading">
        <span class="step-number">03</span>

        <div>
            <h2>Control de documentos</h2>
            <p>Verificación de los requisitos documentales.</p>
        </div>
    </div>

    <div class="scroll">
        <table>
            <thead>
                <tr>
                    <th>Documento</th>
                    <th>Obligatorio</th>
                    <th>Estado</th>
                    <th>Fecha de entrega</th>
                </tr>
            </thead>

            <tbody>
                @foreach($documentos as $documento)
                    @php
                        $entregado = $item->documentos->firstWhere('id', $documento->id);
                    @endphp

                    <tr>
                        <td>{{ $documento->nombre }}</td>

                        <td>
                            {{ $documento->obligatorio ? 'Sí' : 'No' }}
                        </td>

                        <td>
                            <span class="tag {{ $entregado ? 'status-confirmada' : 'status-pendiente' }}">
                                {{ $entregado ? 'Entregado' : 'Pendiente' }}
                            </span>
                        </td>

                        <td>
                            {{ $entregado?->pivot?->fecha_entrega ?? '—' }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>

@if(auth()->user()->rol !== 'catequista')
    <div class="form-bottom-actions">
        <form
            method="post"
            action="{{ route('aspirantes.destroy', $item) }}"
            onsubmit="return confirm('¿Eliminar permanentemente este aspirante?')"
        >
            @csrf
            @method('DELETE')

            <button type="submit" class="danger-button">
                Eliminar aspirante
            </button>
        </form>
    </div>
@endif

@endsection
