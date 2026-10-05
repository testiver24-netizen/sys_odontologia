@extends('tablar::page')

@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
             @if (session('success'))
            <div class="alert alert-success alert-dismissible" role="alert">
                <i class="ti ti-check"></i> {{ session('success') }}
                <a href="#" class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
            </div>
        @endif
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">Administración</div>
                    <h2 class="page-title">Roles</h2>
                </div>
                {{-- Boton modal-create --}}
                <div class="col-12 col-md-auto ms-auto d-print-none">
                  
                        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-rol">
                            <i class="ti ti-plus"></i> Nuevo Rol
                        </a>
                    
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">

            <div class="card">
                <div class="card-header bg-primary">
                    <h3 class="card-title text-white">Listado de Roles</h3>
                </div>
                <div class="card-body border-bottom">
                    <form action="{{ route('roles.index') }}" method="get" class="row g-2 align-items-center">
                        <div class="col-auto">
                            <label class="form-label mb-0">Buscar rol</label>
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" name="buscar" value="{{ request('buscar') }}"
                                placeholder="Escribe el nombre del rol">
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-sm btn-primary">
                                <i class="ti ti-search"></i> Buscar
                            </button>
                            @if (request('buscar'))
                                <a href="{{ route('roles.index') }}" class="btn btn-sm btn-outline-secondary ms-1">
                                    <i class="ti ti-x"></i> Limpiar
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
                @if (request('buscar'))
                    <div class="alert alert-info m-3">
                        <i class="ti ti-info-circle"></i>
                        Se encontraron {{ $roles->total() }} resultado(s) para
                        <strong>"{{ request('buscar') }}"</strong>.
                    </div>
                @endif
                <div class="table-responsive">
                    <table class="table table-striped table-hover card-table table-vcenter text-nowrap">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Nombre</th>
                                <th class="text-center">Permisos</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($roles as $rol)
                                <tr>
                                    <td class="text-center">{{ $roles->firstItem() + $loop->index }}</td>
                                    <td>{{ $rol->name }}</td>
                                    <td class="text-center">
                                        <div class="d-flex align-items-center justify-content-center gap-2">
                                            <span class="avatar avatar-sm bg-warning-lt text-warning">
                                                <i class="ti ti-lock"></i>
                                            </span>
                                            <div class="lh-sm">
                                                <div class="text-muted small">Permisos Asignados</div>
                                                <div>
                                                    <strong>{{ $rol->permissions_count }}</strong>
                                                    {{ $rol->permissions_count == 1 ? 'Permiso' : 'Permisos' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                     
                                            <a href="{{ url('roles/' . $rol->id . '/permisos') }}" type="button"
                                                class="btn btn-sm btn-icon btn-warning" title="Permisos">
                                                <i class="ti ti-lock"></i>
                                            </a>
                                        
                                       
                                            <button type="button" class="btn btn-sm btn-icon btn-success" title="Editar"
                                                data-bs-toggle="modal" data-bs-target="#modal-rol-edit-{{ $rol->id }}">
                                                <i class="ti ti-edit"></i>
                                            </button>
                                        
                                      
                                            <button type="button" class="btn btn-sm btn-icon btn-danger" title="Eliminar"
                                                data-id="{{ $rol->id }}" data-name="{{ $rol->name }}"
                                                data-bs-toggle="modal" data-bs-target="#modal-rol-delete">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">
                                        No hay roles registrados
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer d-flex align-items-center">
                    {{ $roles->links('tablar::pagination') }}
                </div>
            </div>
        </div>
    </div>
{{-- modal-create --}}
    <div class="modal modal-blur fade" id="modal-rol" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form class="modal-content" action="{{ route('roles.store') }}" method="post">
                @csrf
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white">Nuevo Rol</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        style="filter: brightness(0) invert(1);"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nombre <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="ti ti-user-shield"></i>
                            </span>
                            <input type="text" class="form-control @if (session('open_modal') === 'modal-rol' && $errors->has('name')) is-invalid @endif"
                                name="name" value="{{ old('name') }}" placeholder="Ej: admin, doctor">
                        </div>
                        @if (session('open_modal') === 'modal-rol')
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Cancelar</button>
                  
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-plus"></i> Crear
                        </button>
                    
                </div>
            </form>
        </div>
    </div>
    {{-- /modal-create --}}

    @foreach ($roles as $rol)
        <div class="modal modal-blur fade" id="modal-rol-edit-{{ $rol->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <form class="modal-content" action="{{ route('roles.update', $rol->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="modal-header bg-success">
                        <h5 class="modal-title text-white">Editar Rol</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            style="filter: brightness(0) invert(1);"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nombre <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="ti ti-user-shield"></i>
                                </span>
                                <input type="text"
                                    class="form-control @if (session('open_modal') === 'modal-rol-edit-' . $rol->id && $errors->has('name')) is-invalid @endif"
                                    name="name"
                                    value="{{ session('open_modal') === 'modal-rol-edit-' . $rol->id ? old('name', $rol->name) : $rol->name }}"
                                    placeholder="Ej: admin, doctor">
                            </div>
                            @if (session('open_modal') === 'modal-rol-edit-' . $rol->id)
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn me-auto" data-bs-dismiss="modal">Cancelar</button>
                      
                            <button type="submit" class="btn btn-success">
                                <i class="ti ti-check"></i> Actualizar
                            </button>
                        
                    </div>
                </form>
            </div>
        </div>
    @endforeach

    <div class="modal modal-blur fade" id="modal-rol-delete" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <form action="" method="post" id="form-delete-rol">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header bg-danger">
                        <h5 class="modal-title text-white">Eliminar Rol</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            style="filter: brightness(0) invert(1);"></button>
                    </div>
                    <div class="modal-body text-center py-4">
                        <i class="ti ti-alert-triangle text-danger" style="font-size: 3rem;"></i>
                        <p class="mt-3">¿Estás seguro de eliminar el rol <strong id="delete-name"></strong>?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn me-auto" data-bs-dismiss="modal">Cancelar</button>
                       
                            <button type="submit" class="btn btn-danger">
                                <i class="ti ti-trash"></i> Eliminar
                            </button>
                        
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
            document.getElementById('modal-rol-delete').addEventListener('show.bs.modal', function(e) {
                var btn = e.relatedTarget;
                var id = btn.getAttribute('data-id');
                var name = btn.getAttribute('data-name');
                document.getElementById('form-delete-rol').action = '{{ url('roles') }}/' + id +
                    '/eliminar';
                document.getElementById('delete-name').textContent = name;
            });

            @if (session('open_modal'))
                openModal('{{ session('open_modal') }}');
            @endif
        });
    </script>
@endpush