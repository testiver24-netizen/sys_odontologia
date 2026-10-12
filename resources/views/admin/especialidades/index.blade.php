@extends('tablar::page')

@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">Administración</div>
                    <h2 class="page-title">Especialidades</h2>
                </div>
                <div class="col-12 col-md-auto ms-auto d-print-none">
                    {{-- @can('Guardar especialidades') --}}
                        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-especialidad">
                            <i class="ti ti-plus"></i> Nueva Especialidad
                        </a>
                    {{-- @endcan --}}
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">

            <div class="card">
                <div class="card-header bg-primary">
                    <h3 class="card-title text-white">Listado de Especialidades</h3>
                </div>
                <div class="card-body border-bottom">
                    <form action="{{ route('especialidades.index') }}" method="get"
                        class="row g-2 align-items-center">
                        <div class="col-auto">
                            <label class="form-label mb-0">Buscar especialidad</label>
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" name="buscar" value="{{ request('buscar') }}"
                                placeholder="Escribe el nombre de la especialidad">
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-sm btn-primary">
                                <i class="ti ti-search"></i> Buscar
                            </button>
                            @if (request('buscar'))
                                <a href="{{ route('especialidades.index') }}"
                                    class="btn btn-sm btn-outline-secondary ms-1">
                                    <i class="ti ti-x"></i> Limpiar
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
                @if (request('buscar'))
                    <div class="alert alert-info m-3">
                        <i class="ti ti-info-circle"></i>
                        Se encontraron {{ $especialidades->total() }} resultado(s) para
                        <strong>"{{ request('buscar') }}"</strong>.
                    </div>
                @endif
                <div class="table-responsive">
                    <table class="table table-striped table-hover card-table table-vcenter text-nowrap">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Nombre</th>
                                <th class="text-center">Descripción</th>
                                <th class="text-center">Estado</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($especialidades as $especialidad)
                                <tr>
                                    <td class="text-center">{{ $especialidades->firstItem() + $loop->index }}</td>
                                    <td><center>{{ $especialidad->nombre }}</center></td>
                                    <td><center>{{ $especialidad->descripcion ?: '—' }}</center></td>
                                    <td class="text-center">
                                        @if ($especialidad->estado)
                                            <span class="badge bg-success text-white">Activo</span>
                                        @else
                                            <span class="badge bg-danger text-white">Inactivo</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        {{-- @can('Editar especialidades') --}}
                                            <button type="button" class="btn btn-sm btn-icon btn-success" title="Editar"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modal-especialidad-edit-{{ $especialidad->id }}">
                                                <i class="ti ti-edit"></i>
                                            </button>
                                        {{-- @endcan --}}
                                        {{-- @can('Eliminar especialidades') --}}
                                            <button type="button" class="btn btn-sm btn-icon btn-danger" title="Eliminar"
                                                data-id="{{ $especialidad->id }}" data-name="{{ $especialidad->nombre }}"
                                                data-bs-toggle="modal" data-bs-target="#modal-especialidad-delete">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        {{-- @endcan --}}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        No hay especialidades registradas
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                     <div class="card-footer d-flex align-items-center">
                    {{ $especialidades->links('tablar::pagination')  }}
                </div>
                </div>
               
            </div>
        </div>
    </div>
{{-- modal create --}}
    <div class="modal modal-blur fade" id="modal-especialidad" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form class="modal-content" action="{{ route('especialidades.store') }}" method="post">
                @csrf
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white">Nueva Especialidad</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        style="filter: brightness(0) invert(1);"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nombre <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="ti ti-clipboard"></i>
                            </span>
                            <input type="text" class="form-control @if (session('open_modal') === 'modal-especialidad' && $errors->has('nombre')) is-invalid @endif"
                                name="nombre" value="{{ old('nombre') }}" placeholder="Ej: Ortodoncia">
                        </div>
                        @if (session('open_modal') === 'modal-especialidad')
                            @error('nombre')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        @endif
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descripción</label>
                        <textarea class="form-control @if (session('open_modal') === 'modal-especialidad' && $errors->has('descripcion')) is-invalid @endif" name="descripcion" rows="2"
                            placeholder="Descripción breve (opcional)">{{ old('descripcion') }}</textarea>
                        @if (session('open_modal') === 'modal-especialidad')
                            @error('descripcion')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        @endif
                    </div>
                    
                            <div>
    <input type="hidden" name="estado" value="0">
                            
</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Cancelar</button>
                    {{-- @can('Guardar especialidades') --}}
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-plus"></i> Crear
                        </button>
                    {{-- @endcan --}}
                </div>
            </form>
        </div>
    </div>
    {{-- fin modal create --}}

    @foreach ($especialidades as $especialidad)
    {{-- modal edit --}}
        <div class="modal modal-blur fade" id="modal-especialidad-edit-{{ $especialidad->id }}" tabindex="-1"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <form class="modal-content" action="{{ route('especialidades.update', $especialidad->id) }}"
                    method="post">
                    @csrf
                    @method('PUT')
                    <div class="modal-header bg-success">
                        <h5 class="modal-title text-white">Editar Especialidad</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            style="filter: brightness(0) invert(1);"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nombre <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="ti ti-clipboard"></i>
                                </span>
                                <input type="text"
                                    class="form-control @if (session('open_modal') === 'modal-especialidad-edit-' . $especialidad->id && $errors->has('nombre')) is-invalid @endif"
                                    name="nombre"
                                    value="{{ session('open_modal') === 'modal-especialidad-edit-' . $especialidad->id ? old('nombre', $especialidad->nombre) : $especialidad->nombre }}"
                                    placeholder="Ej: Ortodoncia">
                            </div>
                            @if (session('open_modal') === 'modal-especialidad-edit-' . $especialidad->id)
                                @error('nombre')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            @endif
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Descripción</label>
                            <textarea class="form-control @if (session('open_modal') === 'modal-especialidad-edit-' . $especialidad->id && $errors->has('descripcion')) is-invalid @endif" name="descripcion" rows="2"
                                placeholder="Descripción breve (opcional)">{{ session('open_modal') === 'modal-especialidad-edit-' . $especialidad->id ? old('descripcion', $especialidad->descripcion) : $especialidad->descripcion }}</textarea>
                            @if (session('open_modal') === 'modal-especialidad-edit-' . $especialidad->id)
                                @error('descripcion')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            @endif
                        </div>
                        {{-- <div>
                            <label class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="activo" value="1"
                                    {{ (session('open_modal') === 'modal-especialidad-edit-' . $especialidad->id ? old('activo', $especialidad->activo) : $especialidad->activo) ? 'checked' : '' }}>
                                <span class="form-check-label">Especialidad activa</span>
                            </label>
                        </div> --}}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn me-auto" data-bs-dismiss="modal">Cancelar</button>
                    {{-- @can('Editar especialidades') --}}
                        <button type="submit" class="btn btn-success">
                            <i class="ti ti-check"></i> Actualizar
                        </button>
                    {{-- @endcan --}}
                    </div>
                </form>
            </div>
        </div>
    @endforeach

    <div class="modal modal-blur fade" id="modal-especialidad-delete" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <form action="" method="post" id="form-delete-especialidad">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header bg-danger">
                        <h5 class="modal-title text-white">Eliminar Especialidad</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            style="filter: brightness(0) invert(1);"></button>
                    </div>
                    <div class="modal-body text-center py-4">
                        <i class="ti ti-alert-triangle text-danger" style="font-size: 3rem;"></i>
                        <p class="mt-3">¿Estás seguro de eliminar la especialidad <strong id="delete-name"></strong>?
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn me-auto" data-bs-dismiss="modal">Cancelar</button>
                        {{-- @can('Eliminar especialidades') --}}
                            <button type="submit" class="btn btn-danger">
                                <i class="ti ti-trash"></i> Eliminar
                            {{-- </button> --}}
                        {{-- @endcan --}}
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        function openModal(modalId) {
            var modal = document.getElementById(modalId);
            if (!modal) return;
            modal.classList.add('show');
            modal.style.display = 'block';
            modal.setAttribute('aria-modal', 'true');
            modal.removeAttribute('aria-hidden');

            var backdrop = document.createElement('div');
            backdrop.className = 'modal-backdrop fade show';
            document.body.appendChild(backdrop);
            document.body.classList.add('modal-open');

            function closeModal() {
                modal.classList.remove('show');
                modal.style.display = 'none';
                modal.setAttribute('aria-hidden', 'true');
                modal.removeAttribute('aria-modal');
                backdrop.remove();
                document.body.classList.remove('modal-open');
            }
            modal.querySelectorAll('[data-bs-dismiss="modal"]').forEach(function(el) {
                el.addEventListener('click', closeModal);
            });
            backdrop.addEventListener('click', closeModal);
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('modal-especialidad-delete').addEventListener('show.bs.modal', function(e) {
                var btn = e.relatedTarget;
                var id = btn.getAttribute('data-id');
                var name = btn.getAttribute('data-name');
                document.getElementById('form-delete-especialidad').action =
                    '{{ url('especialidades') }}' +
                    '/' + id + '/eliminar';
                document.getElementById('delete-name').textContent = name;
            });

            @if (session('open_modal'))
                openModal('{{ session('open_modal') }}');
            @endif
        });
    </script>
@endpush