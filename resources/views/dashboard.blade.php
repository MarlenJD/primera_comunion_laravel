
@extends('layouts.app')
@section('title','Panel principal')

@section('content')
<div class="welcome">
    <div>
        <div class="eyebrow">PANEL ADMINISTRATIVO · GESTIÓN DE INSCRIPCIONES</div>
        <h1>Bienvenido al sistema</h1>
        <p>Hola, {{ auth()->user()->name }}. Consulta la actividad y administra el proceso de Primera Comunión desde un solo lugar.</p>
    </div>

    @if(auth()->user()->rol !== 'catequista')
        <a class="button" href="{{ route('aspirantes.create') }}">+ Registrar aspirante</a>
    @endif
</div>

<div class="section-caption">Resumen general</div>

<div class="stats">
    <div class="card stat-card">
        <span class="stat-icon">◎</span>
        <span>Aspirantes registrados</span>
        <strong>{{ $total }}</strong>
        <small>Total de expedientes</small>
    </div>

    <div class="card stat-card">
        <span class="stat-icon">◷</span>
        <span>Inscripciones pendientes</span>
        <strong>{{ $pendientes }}</strong>
        <small>Requieren seguimiento</small>
    </div>

    <div class="card stat-card">
        <span class="stat-icon">✓</span>
        <span>Inscripciones confirmadas</span>
        <strong>{{ $confirmadas }}</strong>
        <small>Registros aprobados</small>
    </div>

    <div class="card stat-card">
        <span class="stat-icon">▦</span>
        <span>Grupos de catequesis</span>
        <strong>{{ $grupos }}</strong>
        <small>Grupos registrados</small>
    </div>

    <div class="card stat-card">
        <span class="stat-icon">♙</span>
        <span>Catequistas</span>
        <strong>{{ $catequistas }}</strong>
        <small>Personal registrado</small>
    </div>

    <div class="card stat-card">
        <span class="stat-icon">▤</span>
        <span>Tipos de documentos</span>
        <strong>{{ $documentos }}</strong>
        <small>Requisitos documentales</small>
    </div>
</div>

<div class="dashboard-bottom">
    <section class="card recent-card">
        <div class="heading">
            <div>
                <h2>Registros recientes</h2>
                <p>Últimos aspirantes registrados en el sistema.</p>
            </div>
            <a class="button secondary" href="{{ route('aspirantes.index') }}">Ver todos</a>
        </div>

        <div class="scroll">
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Grupo</th>
                        <th>Estado</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recientes as $a)
                        <tr>
                            <td><strong>{{ $a->nombre }}</strong></td>
                            <td>{{ $a->grupo?->nombre ?? 'Sin asignar' }}</td>
                            <td>
                                <span class="tag status-{{ $a->estado }}">
                                    {{ str_replace('_',' ',$a->estado) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('aspirantes.show',$a) }}">Ver ficha</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="empty-state">Todavía no hay registros.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <aside class="card quick-card">
        <h2>Accesos rápidos</h2>
        <p>Funciones de uso frecuente</p>

        <a href="{{ route('aspirantes.index') }}">Consultar aspirantes <span>↗</span></a>

        @if(auth()->user()->rol !== 'catequista')
            <a href="{{ route('catalogos.index','grupos') }}">Administrar grupos <span>↗</span></a>
            <a href="{{ route('catalogos.index','catequistas') }}">Ver catequistas <span>↗</span></a>
        @endif

        <a href="{{ route('aspirantes.reporte') }}">Descargar reporte <span>↗</span></a>
    </aside>
</div>
@endsection
