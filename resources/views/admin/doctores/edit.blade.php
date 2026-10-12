@extends('tablar::page')

@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">Administración</div>
                    <h2 class="page-title">Editar Doctor</h2>
                </div>
                <div class="col-12 col-md-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('doctores.index') }}" class="btn btn-outline-secondary">
                            <i class="ti ti-x"></i> Cancelar
                        </a>
                        {{-- @can('Actualizar doctores') --}}
                            <button type="submit" form="form-doctor-edit" class="btn btn-success">
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
            <form id="form-doctor-edit" action="{{ route('doctores.update',$doctor->id)}}" method="post"
                enctype="multipart/form-data">
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
                                                value="{{ old('nombres', $doctor->nombres) }}" placeholder="Nombres">
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
                                                name="apellidos" value="{{ old('apellidos', $doctor->apellidos) }}"
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
                                                    {{ old('tipo_documento', $doctor->tipo_documento) === 'CI' ? 'selected' : '' }}>
                                                    CI</option>
                                                <option value="CE"
                                                    {{ old('tipo_documento', $doctor->tipo_documento) === 'CE' ? 'selected' : '' }}>
                                                    CE</option>
                                                <option value="Pasaporte"
                                                    {{ old('tipo_documento', $doctor->tipo_documento) === 'Pasaporte' ? 'selected' : '' }}>
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
                                                value="{{ old('numero_documento', $doctor->numero_documento) }}"
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
                                                value="{{ old('fecha_nacimiento', $doctor->fecha_nacimiento) }}">
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
                                                    {{ old('genero', $doctor->genero) === 'M' ? 'selected' : '' }}>
                                                    Masculino</option>
                                                <option value="F"
                                                    {{ old('genero', $doctor->genero) === 'F' ? 'selected' : '' }}>Femenino
                                                </option>
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

                    {{-- Datos Profesionales y Contacto --}}
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-header bg-primary">
                                <h3 class="card-title text-white">
                                    <i class="ti ti-stethoscope"></i> Datos Profesionales
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <label class="form-label">Especialidad <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="ti ti-heart-rate-monitor"></i></span>
                                            <select class="form-select @error('especialidad_id') is-invalid @enderror"
                                                name="especialidad_id" required>
                                                <option value="">Seleccionar especialidad</option>
                                                @foreach ($especialidades as $especialidad)
                                                    <option value="{{ $especialidad->id }}"
                                                        {{ old('especialidad_id', $doctor->especialidad_id) == $especialidad->id ? 'selected' : '' }}>
                                                        {{ $especialidad->nombre }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('especialidad_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">N° Colegiatura <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="ti ti-certificate"></i></span>
                                            <input type="text"
                                                class="form-control @error('colegiatura') is-invalid @enderror"
                                                name="colegiatura" value="{{ old('colegiatura', $doctor->colegiatura) }}"
                                                placeholder="Ej: CMP-12345">
                                        </div>
                                        @error('colegiatura')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Teléfono <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="ti ti-phone"></i></span>
                                            <input type="text"
                                                class="form-control @error('telefono') is-invalid @enderror"
                                                name="telefono" value="{{ old('telefono', $doctor->telefono) }}"
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
                                                value="{{ old('email', $doctor->user->email ?? '') }}"
                                                placeholder="Correo electrónico">
                                        </div>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Será usado para ingreso al sistema</small>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">Dirección <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="ti ti-map-pin"></i></span>
                                            <input type="text"
                                                class="form-control @error('direccion') is-invalid @enderror"
                                                name="direccion" value="{{ old('direccion', $doctor->direccion) }}"
                                                placeholder="Dirección completa">
                                        </div>
                                        @error('direccion')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Información Adicional --}}
                    <div class="col-12">
                        <div class="card h-100">
                            <div class="card-header bg-success">
                                <h3 class="card-title text-white">
                                    <i class="ti ti-notes"></i> Información Adicional
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label">Descripción</label>
                                        <textarea class="form-control @error('descripcion') is-invalid @enderror" name="descripcion" rows="3"
                                            placeholder="Breve perfil profesional">{{ old('descripcion', $doctor->descripcion) }}</textarea>
                                        @error('descripcion')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Observaciones</label>
                                        <textarea class="form-control @error('observaciones') is-invalid @enderror" name="observaciones" rows="3"
                                            placeholder="Observaciones adicionales">{{ old('observaciones', $doctor->observaciones) }}</textarea>
                                        @error('observaciones')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Fotografía</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="ti ti-photo"></i></span>
                                            <input type="file"
                                                class="form-control @error('fotografia') is-invalid @enderror"
                                                name="fotografia" id="foto-input" accept="image/*">
                                        </div>
                                        @error('fotografia')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="mt-2 text-center" id="foto-preview">
                                            @if ($doctor->fotografia)
                                                <img src="{{ asset('storage/' . $doctor->fotografia) }}" alt="Foto"
                                                    class="img-thumbnail" style="max-height: 120px;">
                                            @else
                                                <div class="border rounded d-flex align-items-center justify-content-center text-muted"
                                                    style="height: 120px; max-width: 200px; margin: 0 auto;">
                                                    <i class="ti ti-photo" style="font-size: 2rem;"></i>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('foto-input').addEventListener('change', function(e) {
            var preview = document.getElementById('foto-preview');
            var file = e.target.files[0];

            if (file) {
                var reader = new FileReader();
                reader.onload = function(event) {
                    preview.innerHTML = '<img src="' + event.target.result +
                        '" alt="Foto" class="img-thumbnail" style="max-height: 120px;">';
                };
                reader.readAsDataURL(file);
            } else {
                @if ($doctor->fotografia)
                    preview.innerHTML =
                        '<img src="{{ asset('storage/' . $doctor->fotografia) }}" alt="Foto" class="img-thumbnail" style="max-height: 120px;">';
                @else
                    preview.innerHTML =
                        '<div class="border rounded d-flex align-items-center justify-content-center text-muted" style="height: 120px; max-width: 200px; margin: 0 auto;"><i class="ti ti-photo" style="font-size: 2rem;"></i></div>';
                @endif
            }
        });
    </script>
@endsection