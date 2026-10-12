@extends('tablar::page')

@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">Administración</div>
                    <h2 class="page-title">Ficha del Doctor</h2>
                </div>
                <div class="col-12 col-md-auto ms-auto d-print-none">
                    <div class="btn-list">
                        @can('Ver formulario de edicion de doctores')
                            <a href="{{ url('admin/doctores/' . $doctor->id . '/edit') }}" class="btn btn-success">
                                <i class="ti ti-edit"></i> Editar
                            </a>
                        @endcan
                        <a href="{{ route('doctores.index') }}" class="btn btn-outline-secondary">
                            <i class="ti ti-arrow-left"></i> Volver
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">

            {{-- Header Personal --}}
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            @if ($doctor->fotografia)
                                <span class="avatar avatar-xl rounded"
                                    style="background-image: url('{{ asset('storage/' . $doctor->fotografia) }}')"></span>
                            @else
                                <span class="avatar avatar-xl rounded bg-primary text-white" style="font-size: 1.5rem;">
                                    {{ strtoupper(substr($doctor->nombres, 0, 1) . substr($doctor->apellidos, 0, 1)) }}
                                </span>
                            @endif
                        </div>
                        <div class="col">
                            <h2 class="mb-0">{{ $doctor->nombres }} {{ $doctor->apellidos }}</h2>
                            <div class="text-muted">
                                <i class="ti ti-id"></i> {{ $doctor->tipo_documento }}: {{ $doctor->numero_documento }}
                                &nbsp;|&nbsp;
                                <i class="ti ti-calendar"></i>
                                {{ \Carbon\Carbon::parse($doctor->fecha_nacimiento)->format('d/m/Y') }}
                                ({{ \Carbon\Carbon::parse($doctor->fecha_nacimiento)->age }} años)
                                &nbsp;|&nbsp;
                                <span
                                    class="badge {{ $doctor->genero === 'M' ? 'bg-blue text-white' : 'bg-pink text-white' }}">
                                    {{ $doctor->genero === 'M' ? 'Masculino' : 'Femenino' }}
                                </span>
                            </div>
                        </div>
                        <div class="col-auto ms-auto">
                            <span
                                class="badge {{ $doctor->user?->estado === 'activo' ? 'bg-success text-white' : 'bg-danger text-white' }} fs-5 px-3 py-2">
                                {{ $doctor->user?->estado === 'activo' ? 'Activo' : 'Inactivo' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row row-cards">
                {{-- Especialidad --}}
                <div class="col-md-4">
                    <div class="card text-center">
                        <div class="card-body py-4">
                            <i class="ti ti-heart-rate-monitor text-primary mb-2" style="font-size: 2rem;"></i>
                            <div class="text-muted mb-1">Especialidad</div>
                            <div class="fs-3 fw-bold text-primary">{{ $doctor->especialidad?->nombre ?: '—' }}</div>
                        </div>
                    </div>
                </div>

                {{-- Colegiatura --}}
                <div class="col-md-4">
                    <div class="card text-center">
                        <div class="card-body py-4">
                            <i class="ti ti-certificate text-success mb-2" style="font-size: 2rem;"></i>
                            <div class="text-muted mb-1">N° Colegiatura</div>
                            <div class="fs-3 fw-bold text-success">{{ $doctor->colegiatura ?: '—' }}</div>
                        </div>
                    </div>
                </div>

                {{-- Email Acceso --}}
                <div class="col-md-4">
                    <div class="card text-center">
                        <div class="card-body py-4">
                            <i class="ti ti-mail text-info mb-2" style="font-size: 2rem;"></i>
                            <div class="text-muted mb-1">Email de Acceso</div>
                            <div class="fs-4 fw-bold text-info text-break">{{ $doctor->user->email ?? '—' }}</div>
                        </div>
                    </div>
                </div>

                {{-- Contacto --}}
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="ti ti-map-pin text-primary me-2"></i> Contacto</h3>
                        </div>
                        <div class="card-body">
                            <dl class="row mb-0">
                                <dt class="col-4 text-muted fw-normal">Dirección</dt>
                                <dd class="col-8">{{ $doctor->direccion ?: '—' }}</dd>

                                <dt class="col-4 text-muted fw-normal border-top pt-2 mt-2">Teléfono</dt>
                                <dd class="col-8 border-top pt-2 mt-2">{{ $doctor->telefono ?: '—' }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>

                {{-- Fotografía --}}
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="ti ti-photo text-success me-2"></i> Fotografía</h3>
                        </div>
                        <div class="card-body">
                            @if ($doctor->fotografia)
                                <div class="text-center">
                                    <img src="{{ asset('storage/' . $doctor->fotografia) }}" alt="Fotografía del doctor"
                                        class="img-thumbnail" style="max-height: 240px;">
                                </div>
                            @else
                                <div class="text-center text-muted py-4">
                                    <i class="ti ti-photo" style="font-size: 3rem;"></i>
                                    <p class="mb-0 mt-2">Sin fotografía registrada</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Descripción --}}
                @if ($doctor->descripcion)
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-header">
                                <h3 class="card-title"><i class="ti ti-notes text-primary me-2"></i> Descripción</h3>
                            </div>
                            <div class="card-body">
                                <p class="mb-0">{{ $doctor->descripcion }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Observaciones --}}
                @if ($doctor->observaciones)
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-header">
                                <h3 class="card-title"><i class="ti ti-alert-circle text-warning me-2"></i> Observaciones
                                </h3>
                            </div>
                            <div class="card-body">
                                <p class="mb-0">{{ $doctor->observaciones }}</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection