@extends('tablar::page')

@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">Administración</div>
                    <h2 class="page-title">Editar Paciente</h2>
                </div>
                <div class="col-12 col-md-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('pacientes.index') }}" class="btn btn-outline-secondary">
                            <i class="ti ti-x"></i> Cancelar
                        </a>
                        {{-- @can('Actualizar pacientes') --}}
                            <button type="submit" form="form-paciente-edit" class="btn btn-success">
                                <i class="ti ti-device-floppy"></i> Guardar Cambios
                            </button>
                        {{-- @endcan --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <form id="form-paciente-edit" action="{{ route('pacientes.update',$paciente->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="row row-cards">

                    {{-- Datos Personales --}}
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-header bg-primary">
                                <h3 class="card-title text-white">
                                    <i class="ti ti-user"></i> Datos Personales
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Nombres <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="ti ti-user"></i></span>
                                            <input type="text"
                                                class="form-control @error('nombres') is-invalid @enderror" name="nombres"
                                                value="{{ old('nombres', $paciente->nombres) }}" placeholder="Nombres">
                                        </div>
                                        @error('nombres')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Apellidos <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="ti ti-user"></i></span>
                                            <input type="text"
                                                class="form-control @error('apellidos') is-invalid @enderror"
                                                name="apellidos" value="{{ old('apellidos', $paciente->apellidos) }}"
                                                placeholder="Apellidos">
                                        </div>
                                        @error('apellidos')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Tipo Documento <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="ti ti-id-badge"></i></span>
                                            <select class="form-select @error('tipo_documento') is-invalid @enderror"
                                                name="tipo_documento">
                                                <option value="">Seleccionar</option>
                                                <option value="CI"
                                                    {{ old('tipo_documento', $paciente->tipo_documento) === 'CI' ? 'selected' : '' }}>
                                                    CI</option>
                                                <option value="CE"
                                                    {{ old('tipo_documento', $paciente->tipo_documento) === 'CE' ? 'selected' : '' }}>
                                                    CE</option>
                                                <option value="Pasaporte"
                                                    {{ old('tipo_documento', $paciente->tipo_documento) === 'PASAPORTE' ? 'selected' : '' }}>
                                                    Pasaporte</option>
                                            </select>
                                        </div>
                                        @error('tipo_documento')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">N° Documento <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="ti ti-id"></i></span>
                                            <input type="text"
                                                class="form-control @error('numero_documento') is-invalid @enderror"
                                                name="numero_documento"
                                                value="{{ old('numero_documento', $paciente->numero_documento) }}"
                                                placeholder="Número de documento">
                                        </div>
                                        @error('numero_documento')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Será usado como contraseña de acceso</small>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Fecha Nacimiento <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="ti ti-calendar"></i></span>
                                            <input type="date"
                                                class="form-control @error('fecha_nacimiento') is-invalid @enderror"
                                                name="fecha_nacimiento"
                                                value="{{ old('fecha_nacimiento', $paciente->fecha_nacimiento) }}">
                                        </div>
                                        @error('fecha_nacimiento')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Género <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="ti ti-gender-bigender"></i></span>
                                            <select class="form-select @error('genero') is-invalid @enderror"
                                                name="genero">
                                                <option value="">Seleccionar</option>
                                                <option value="M"
                                                    {{ old('genero', $paciente->genero) === 'M' ? 'selected' : '' }}>
                                                    Masculino</option>
                                                <option value="F"
                                                    {{ old('genero', $paciente->genero) === 'F' ? 'selected' : '' }}>
                                                    Femenino</option>
                                            </select>
                                        </div>
                                        @error('genero')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Contacto --}}
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-header bg-primary">
                                <h3 class="card-title text-white">
                                    <i class="ti ti-phone"></i> Contacto
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">Dirección <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="ti ti-map-pin"></i></span>
                                        <input type="text"
                                            class="form-control @error('direccion') is-invalid @enderror" name="direccion"
                                            value="{{ old('direccion', $paciente->direccion) }}"
                                            placeholder="Dirección completa">
                                    </div>
                                    @error('direccion')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Teléfono <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="ti ti-phone"></i></span>
                                            <input type="text"
                                                class="form-control @error('telefono') is-invalid @enderror"
                                                name="telefono" value="{{ old('telefono', $paciente->telefono) }}"
                                                placeholder="Teléfono">
                                        </div>
                                        @error('telefono')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Email <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="ti ti-mail"></i></span>
                                            <input type="email"
                                                class="form-control @error('email') is-invalid @enderror" name="email"
                                                value="{{ old('email', $paciente->user->email ?? '') }}"
                                                placeholder="Correo electrónico" required>
                                        </div>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Será usado para ingreso al sistema</small>
                                    </div>
                                </div>
                                <hr class="my-3">
                                <h4 class="mb-3"><i class="ti ti-alert-circle"></i> Contacto de Emergencia</h4>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Nombre Completo</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="ti ti-user"></i></span>
                                            <input type="text"
                                                class="form-control @error('contacto_emergencia') is-invalid @enderror"
                                                name="contacto_emergencia"
                                                value="{{ old('contacto_emergencia', $paciente->contacto_emergencia) }}"
                                                placeholder="Nombre del contacto">
                                        </div>
                                        @error('contacto_emergencia')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Teléfono</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="ti ti-phone"></i></span>
                                            <input type="text"
                                                class="form-control @error('telefono_emergencia') is-invalid @enderror"
                                                name="telefono_emergencia"
                                                value="{{ old('telefono_emergencia', $paciente->telefono_emergencia) }}"
                                                placeholder="Teléfono de emergencia">
                                        </div>
                                        @error('telefono_emergencia')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Datos Médicos --}}
                    <div class="col-12">
                        <div class="card h-100">
                            <div class="card-header bg-success">
                                <h3 class="card-title text-white">
                                    <i class="ti ti-heart-rate-monitor"></i> Datos Médicos
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-3">
                                        <label class="form-label">Grupo Sanguíneo</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="ti ti-droplet"></i></span>
                                            <select class="form-select @error('grupo_sanguineo') is-invalid @enderror"
                                                name="grupo_sanguineo">
                                                <option value="">Seleccionar</option>
                                                @foreach (['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $gs)
                                                    <option value="{{ $gs }}"
                                                        {{ old('grupo_sanguineo', $paciente->grupo_sanguineo) === $gs ? 'selected' : '' }}>
                                                        {{ $gs }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('grupo_sanguineo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-9">
                                        <label class="form-label">Alergias</label>
                                        <textarea class="form-control @error('alergias') is-invalid @enderror" name="alergias" rows="2"
                                            placeholder="Alergias conocidas">{{ old('alergias', $paciente->alergias) }}</textarea>
                                        @error('alergias')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Enfermedades</label>
                                        <textarea class="form-control @error('enfermedades') is-invalid @enderror" name="enfermedades" rows="2"
                                            placeholder="Enfermedades preexistentes">{{ old('enfermedades', $paciente->enfermedades) }}</textarea>
                                        @error('enfermedades')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Medicamentos</label>
                                        <textarea class="form-control @error('medicamentos') is-invalid @enderror" name="medicamentos" rows="2"
                                            placeholder="Medicamentos actuales">{{ old('medicamentos', $paciente->medicamentos) }}</textarea>
                                        @error('medicamentos')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Hábitos</label>
                                        <div class="row g-2">
                                            @php
                                                $habitosCheck = old(
                                                    'habitos',
                                                    $paciente->habitos ? explode(', ', $paciente->habitos) : [],
                                                );
                                                $habitos = [
                                                    'Fuma',
                                                    'Bebe alcohol',
                                                    'Consume drogas',
                                                    'Bruxismo',
                                                    'Muerde objetos',
                                                    'Consumo de café/té',
                                                    'Higiene bucal deficiente',
                                                ];
                                            @endphp
                                            @foreach ($habitos as $habito)
                                                <div class="col-6">
                                                    <label class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="habitos[]"
                                                            value="{{ $habito }}"
                                                            {{ in_array($habito, $habitosCheck) ? 'checked' : '' }}>
                                                        <span class="form-check-label">{{ $habito }}</span>
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Antecedentes Médicos</label>
                                        <small class="text-muted d-block mb-2">Marca las condiciones que apliquen al
                                            paciente</small>
                                        <div class="row g-2">
                                            @php
                                                $antecedentesCheck = old(
                                                    'antecedentes',
                                                    $paciente->antecedentes
                                                        ? explode(', ', $paciente->antecedentes)
                                                        : [],
                                                );
                                                $checks = [
                                                    'Diabetes',
                                                    'Hipertensión',
                                                    'Cardiopatía',
                                                    'Asma',
                                                    'Epilepsia',
                                                    'Hepatitis',
                                                    'VIH',
                                                    'Problemas de coagulación',
                                                    'Toma anticoagulantes',
                                                    'Enfermedad renal',
                                                    'Tiroides',
                                                    'Cáncer',
                                                    'Osteoporosis',
                                                    'Embarazo',
                                                ];
                                            @endphp
                                            @foreach ($checks as $check)
                                                <div class="col-4">
                                                    <label class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="antecedentes[]" value="{{ $check }}"
                                                            {{ in_array($check, $antecedentesCheck) ? 'checked' : '' }}>
                                                        <span class="form-check-label">{{ $check }}</span>
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Observaciones --}}
                    <div class="col-12">
                        <div class="card h-100">
                            <div class="card-header bg-warning">
                                <h3 class="card-title text-white">
                                    <i class="ti ti-notes"></i> Observaciones
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="ti ti-notes"></i></span>
                                    <textarea class="form-control @error('observaciones') is-invalid @enderror" name="observaciones" rows="3"
                                        placeholder="Observaciones adicionales">{{ old('observaciones', $paciente->observaciones) }}</textarea>
                                </div>
                                @error('observaciones')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
@endsection