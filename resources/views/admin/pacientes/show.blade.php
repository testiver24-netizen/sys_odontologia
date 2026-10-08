@extends('tablar::page')

@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">Administración</div>
                    <h2 class="page-title">Ficha del Paciente</h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('pacientes.index') }}" class="btn btn-outline-secondary">
                            <i class="ti ti-arrow-left"></i> Volver
                        </a>
                        @can('Ver formulario de edicion de pacientes')
                            <a href="{{ route('pacientes.edit', $paciente->id) }}" class="btn btn-success">
                                <i class="ti ti-edit"></i> Editar
                            </a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <div class="row row-cards">

                {{-- ========== COLUMNA IZQUIERDA ========== --}}
                <div class="col-lg-4">

                    {{-- Perfil --}}
                    <div class="card mb-3">
                        <div class="card-body text-center">
                            <span class="avatar avatar-xl rounded-circle mb-3"
                                style="background-image: url(https://ui-avatars.com/api/?name={{ urlencode($paciente->nombres) }}+{{ urlencode($paciente->apellidos) }}&size=128&background=206bc4&color=fff)">
                            </span>
                            <h3 class="m-0 mb-1">{{ $paciente->nombres }} {{ $paciente->apellidos }}</h3>
                            <div class="text-muted">{{ $paciente->tipo_documento }}: {{ $paciente->numero_documento }}</div>

                            <div class="mt-3">
                                <span class="badge {{ $paciente->user?->estado === 'activo' ? 'bg-green-lt' : 'bg-red-lt' }}">
                                    {{ $paciente->user?->estado === 'activo' ? 'Activo' : 'Inactivo' }}
                                </span>
                                <span class="badge {{ $paciente->genero === 'M' ? 'bg-blue-lt' : 'bg-pink-lt' }}">
                                    {{ $paciente->genero === 'M' ? 'Masculino' : 'Femenino' }}
                                </span>
                            </div>
                        </div>

                        <div class="list-group list-group-flush">
                            <div class="list-group-item d-flex align-items-center">
                                <i class="ti ti-calendar text-muted fs-2 me-3"></i>
                                <div>
                                    <div class="text-muted small">Nacimiento</div>
                                    {{ \Carbon\Carbon::parse($paciente->fecha_nacimiento)->format('d/m/Y') }}
                                    <span class="text-muted">({{ \Carbon\Carbon::parse($paciente->fecha_nacimiento)->age }} años)</span>
                                </div>
                            </div>
                            <div class="list-group-item d-flex align-items-center">
                                <i class="ti ti-phone text-muted fs-2 me-3"></i>
                                <div>
                                    <div class="text-muted small">Teléfono</div>
                                    {{ $paciente->telefono ?: '—' }}
                                </div>
                            </div>
                            <div class="list-group-item d-flex align-items-center">
                                <i class="ti ti-mail text-muted fs-2 me-3"></i>
                                <div>
                                    <div class="text-muted small">Email</div>
                                    {{ $paciente->user->email ?? '—' }}
                                </div>
                            </div>
                            <div class="list-group-item d-flex align-items-center">
                                <i class="ti ti-map-pin text-muted fs-2 me-3"></i>
                                <div>
                                    <div class="text-muted small">Dirección</div>
                                    {{ $paciente->direccion ?: '—' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Emergencia --}}
                    <div class="card border-start border-warning border-3">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="ti ti-alert-circle text-warning me-2"></i> Contacto de emergencia
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="fw-bold">{{ $paciente->contacto_emergencia ?: '—' }}</div>
                            <div class="text-muted">
                                <i class="ti ti-phone me-1"></i>{{ $paciente->telefono_emergencia ?: '—' }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ========== COLUMNA DERECHA ========== --}}
                <div class="col-lg-8">

                    {{-- Resumen rápido --}}
                    <div class="row row-cards mb-3">
                        <div class="col-md-4">
                            <div class="card border-start border-danger border-3 h-100">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <span class="avatar bg-red-lt me-3"><i class="ti ti-droplet fs-2"></i></span>
                                        <div>
                                            <div class="text-muted small">Grupo sanguíneo</div>
                                            <div class="h2 m-0 text-danger">{{ $paciente->grupo_sanguineo ?: '—' }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card border-start border-warning border-3 h-100">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <span class="avatar bg-yellow-lt me-3"><i class="ti ti-allergy fs-2"></i></span>
                                        <div>
                                            <div class="text-muted small">Alergias</div>
                                            <div class="fw-bold {{ $paciente->alergias ? 'text-warning' : 'text-muted' }}">
                                                {{ $paciente->alergias ?: 'Ninguna' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card border-start border-info border-3 h-100">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <span class="avatar bg-azure-lt me-3"><i class="ti ti-pill fs-2"></i></span>
                                        <div>
                                            <div class="text-muted small">Medicamentos</div>
                                            <div class="fw-bold {{ $paciente->medicamentos ? 'text-info' : 'text-muted' }}">
                                                {{ $paciente->medicamentos ?: 'Ninguno' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Historial médico --}}
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="ti ti-heartbeat text-danger me-2"></i> Historial médico
                            </h3>
                        </div>
                        <div class="list-group list-group-flush">

                            <div class="list-group-item">
                                <div class="text-muted small mb-2">
                                    <i class="ti ti-virus me-1"></i> Enfermedades
                                </div>
                                @if ($paciente->enfermedades)
                                    <p class="mb-0">{{ $paciente->enfermedades }}</p>
                                @else
                                    <span class="text-muted">Sin registro</span>
                                @endif
                            </div>

                            <div class="list-group-item">
                                <div class="text-muted small mb-2">
                                    <i class="ti ti-clipboard-heart me-1"></i> Antecedentes médicos
                                </div>
                                @if ($paciente->antecedentes)
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach (explode(', ', $paciente->antecedentes) as $ant)
                                            <span class="badge bg-red-lt">{{ $ant }}</span>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-muted">Sin registro</span>
                                @endif
                            </div>

                            <div class="list-group-item">
                                <div class="text-muted small mb-2">
                                    <i class="ti ti-mood-smile me-1"></i> Hábitos
                                </div>
                                @if ($paciente->habitos)
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach (explode(', ', $paciente->habitos) as $habito)
                                            <span class="badge bg-orange-lt">{{ $habito }}</span>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-muted">Sin registro</span>
                                @endif
                            </div>

                            <div class="list-group-item">
                                <div class="text-muted small mb-2">
                                    <i class="ti ti-notes me-1"></i> Observaciones
                                </div>
                                @if ($paciente->observaciones)
                                    <p class="mb-0">{{ $paciente->observaciones }}</p>
                                @else
                                    <span class="text-muted">Sin observaciones</span>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection