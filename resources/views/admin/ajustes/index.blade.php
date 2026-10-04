@extends('tablar::page')

@section('title', 'Dashboard')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">Ajustes</h2>
                @auth
                    <div class="text-secondary mt-1">
                       Rellena el formulario para completar los ajustes del sistema.
                    </div>
                @endauth
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">

        @if (session('success'))
            <div class="alert alert-success alert-dismissible" role="alert">
                <div class="d-flex">
                    <div><i class="ti ti-check me-2"></i></div>
                    <div>{{ session('success') }}</div>
                </div>
                <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
            </div>
        @endif
        <form action="{{ route('ajustes.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row row-cards">

                {{-- Logo --}}
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header bg-primary-lt ">
                            <h3 class="card-title">Logo</h3>
                        </div>
                        <div class="card-body text-center">
                            <img id="logo-preview"
                                 src="{{ !empty($ajuste->url_logo) ? asset('storage/' . $ajuste->url_logo) : 'https://placehold.co/200x200?text=Logo' }}"
                                 alt="Logo" class="img-thumbnail mb-3"
                                 style="max-height: 200px; max-width: 100%; object-fit: contain;">
                            <input type="file" name="url_logo" id="url_logo" accept="image/*"
                                   class="form-control @error('url_logo') is-invalid @enderror">
                            @error('url_logo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                {{-- Datos --}}
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header bg-primary-lt ">
                            <h3 class="card-title text-blue-300 ">Datos generales</h3>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-8">
                                    <label class="form-label required">Nombre</label>
                                    <input type="text" name="nombre" maxlength="150"
                                           class="form-control @error('nombre') is-invalid @enderror"
                                           value="{{ old('nombre', $ajuste->nombre ?? '') }}" required>
                                    @error('nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label required">Divisa</label>
                                   
                                    <input type="text" name="divisa" maxlength="50"
                                           class="form-control @error('divisa') is-invalid @enderror"
                                           value="{{ old('divisa', $ajuste->divisa ?? '') }}" required>
                                    @error('divisa') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Descripción</label>
                                    <textarea name="decripcion" rows="3"
                                              class="form-control @error('decripcion') is-invalid @enderror">{{ old('decripcion', $ajuste->decripcion ?? '') }}</textarea>
                                    @error('decripcion') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="card-header bg-primary-lt  border-top">
                            <h3 class="card-title ">Contacto</h3>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label required">Dirección</label>
                                    <input type="text" name="direccion"
                                           class="form-control @error('direccion') is-invalid @enderror"
                                           value="{{ old('direccion', $ajuste->direccion ?? '') }}" required>
                                    @error('direccion') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label required">Teléfono</label>
                                    <input type="text" name="telefono" maxlength="20"
                                           class="form-control @error('telefono') is-invalid @enderror"
                                           value="{{ old('telefono', $ajuste->telefono ?? '') }}" required>
                                    @error('telefono') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label required">Email</label>
                                    <input type="email" name="email" maxlength="100"
                                           class="form-control @error('email') is-invalid @enderror"
                                           value="{{ old('email', $ajuste->email ?? '') }}" required>
                                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-12">
                                    <label class="form-label required">Sitio web</label>
                                    <input type="text" name="web" maxlength="100"
                                           class="form-control @error('web') is-invalid @enderror"
                                           value="{{ old('web', $ajuste->web ?? '') }}" required>
                                    @error('web') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="card-footer text-end">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('url_logo').addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (file) {
            document.getElementById('logo-preview').src = URL.createObjectURL(file);
        }
    });
</script>
@endsection
