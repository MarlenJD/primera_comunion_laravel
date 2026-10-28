
@extends('layouts.app')

@section('title', $item->exists ? 'Editar aspirante' : 'Nuevo aspirante')

@section('content')

<div class="heading page-heading">
    <div>
        <div class="eyebrow">GESTIÓN DE INSCRIPCIONES</div>

        <h1>
            {{ $item->exists ? 'Editar' : 'Registrar' }} aspirante
        </h1>

        <p>
            Completa la información por secciones.
            Los campos marcados con * son obligatorios.
        </p>
    </div>

    <a class="button secondary" href="{{ route('aspirantes.index') }}">
        Volver a aspirantes
    </a>
</div>

<form
    method="post"
    action="{{ $item->exists ? route('aspirantes.update', $item) : route('aspirantes.store') }}"
    class="form-sections"
>
    @csrf

    @if($item->exists)
        @method('PUT')
    @endif

    <section class="card form-section">
        <div class="section-heading">
            <span class="step-number">01</span>

            <div>
                <h2>Datos personales</h2>
                <p>Información general del niño o niña.</p>
            </div>
        </div>

        <div class="fields">
            <label>
                Nombre completo *
                <input
                    name="nombre"
                    value="{{ old('nombre', $item->nombre) }}"
                    required
                >
            </label>

            <label>
                Fecha de nacimiento *
                <input
                    type="date"
                    name="fecha_nacimiento"
                    value="{{ old('fecha_nacimiento', $item->fecha_nacimiento) }}"
                    required
                >
            </label>

            <label class="wide">
                Domicilio *
                <input
                    name="domicilio"
                    value="{{ old('domicilio', $item->domicilio) }}"
                    required
                >
            </label>
        </div>
    </section>

    <section class="card form-section">
        <div class="section-heading">
            <span class="step-number">02</span>

            <div>
                <h2>Padre, madre o tutor</h2>
                <p>Datos de contacto del responsable.</p>
            </div>
        </div>

        <div class="fields">
            <label>
                Nombre completo *
                <input
                    name="tutor_nombre"
                    value="{{ old('tutor_nombre', $item->tutor?->nombre) }}"
                    required
                >
            </label>

            <label>
                Parentesco *
                <select name="parentesco" required>
                    @foreach(['padre', 'madre', 'tutor'] as $parentesco)
                        <option
                            value="{{ $parentesco }}"
                            @selected(old('parentesco', $item->tutor?->parentesco) === $parentesco)
                        >
                            {{ ucfirst($parentesco) }}
                        </option>
                    @endforeach
                </select>
            </label>

            <label>
                Teléfono *
                <input
                    name="telefono"
                    value="{{ old('telefono', $item->tutor?->telefono) }}"
                    required
                >
            </label>

            <label>
                Domicilio del tutor
                <input
                    name="tutor_domicilio"
                    value="{{ old('tutor_domicilio', $item->tutor?->domicilio) }}"
                >
            </label>
        </div>
    </section>

    <section class="card form-section">
        <div class="section-heading">
            <span class="step-number">03</span>

            <div>
                <h2>Bautismo y catequesis</h2>
                <p>Información sacramental y grupo asignado.</p>
            </div>
        </div>

        <div class="fields">
            <label>
                Información del bautismo
                <input
                    name="bautismo"
                    value="{{ old('bautismo', $item->bautismo) }}"
                >
            </label>

            <label>
                Grupo
                <select name="grupo_id">
                    <option value="">Sin asignar</option>

                    @foreach($grupos as $grupo)
                        <option
                            value="{{ $grupo->id }}"
                            @selected(old('grupo_id', $item->grupo_id) == $grupo->id)
                        >
                            {{ $grupo->nombre }}
                        </option>
                    @endforeach
                </select>
            </label>

            <label class="wide">
                Observaciones
                <textarea name="observaciones" rows="4">{{ old('observaciones', $item->observaciones) }}</textarea>
            </label>
        </div>
    </section>

    <section class="card form-section">
        <div class="section-heading">
            <span class="step-number">04</span>

            <div>
                <h2>Documentación</h2>
                <p>Selecciona únicamente los documentos que ya se recibieron.</p>
            </div>
        </div>

        <div class="checks">
            @foreach($documentos as $documento)
                <label class="check-item">
                    <input
                        type="checkbox"
                        name="documentos[]"
                        value="{{ $documento->id }}"
                        @checked(in_array(
                            $documento->id,
                            old(
                                'documentos',
                                $item->exists
                                    ? $item->documentos->pluck('id')->all()
                                    : []
                            )
                        ))
                    >

                    <span>
                        {{ $documento->nombre }}

                        @if($documento->obligatorio)
                            <small class="required-label">
                                Obligatorio
                            </small>
                        @endif
                    </span>
                </label>
            @endforeach
        </div>
    </section>

    <div class="form-bottom-actions">
        <a class="button secondary" href="{{ route('aspirantes.index') }}">
            Cancelar
        </a>

        <button type="submit">
            Guardar aspirante
        </button>
    </div>
</form>

@endsection
