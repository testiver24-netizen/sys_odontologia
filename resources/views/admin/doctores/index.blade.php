@extends('tablar::page')

@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">Administración</div>
                    <h2 class="page-title">Doctores</h2>
                </div>
                <div class="col-12 col-md-auto ms-auto d-print-none">
                    {{-- @can('Ver formulario de creacion de doctores') --}}
                        <a href="{{ route('doctores.create') }}" class="btn btn-primary">
                            <i class="ti ti-plus"></i> Nuevo Doctor
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
                    <h3 class="card-title text-white">Listado de Doctores</h3>
                </div>
                <div class="card-body border-bottom">
                    <form action="{{ route('doctores.index') }}" method="get" class="row g-2 align-items-center">
                        <div class="col-auto">
                            <label class="form-label mb-0">Buscar doctor</label>
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" name="buscar" value="{{ request('buscar') }}"
                                placeholder="Escribe el nombre, apellido, documento o especialidad">
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-sm btn-primary">
                                <i class="ti ti-search"></i> Buscar
                            </button>
                            @if (request('buscar'))
                                <a href="{{ route('doctores.index') }}" class="btn btn-sm btn-outline-secondary ms-1">
                                    <i class="ti ti-x"></i> Limpiar
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
                @if (request('buscar'))
                    <div class="alert alert-info m-3">
                        <i class="ti ti-info-circle"></i>
                        Se encontraron {{ $doctors->total() }} resultado(s) para
                        <strong>"{{ request('buscar') }}"</strong>.
                    </div>
                @endif
                <div class="table-responsive">
                    <table class="table table-striped table-hover card-table table-vcenter text-nowrap">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Nombre</th>
                                <th class="text-center">Especialidad</th>
                                <th class="text-center">Colegiatura</th>
                                <th class="text-center">Teléfono</th>
                                <th class="text-center">Estado</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($doctors as $doctor)
                                <tr>
                                    <td class="text-center">{{ $doctors->firstItem() + $loop->index }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if ($doctor->fotografia)
                                                <span class="avatar avatar-sm me-2 rounded"
                                                    style="background-image: url('{{ asset('storage/' . $doctor->fotografia) }}')"></span>
                                            @else
                                                <span class="avatar avatar-sm me-2 rounded bg-primary text-white">
                                                    {{ strtoupper(substr($doctor->nombres, 0, 1) . substr($doctor->apellidos, 0, 1)) }}
                                                </span>
                                            @endif
                                            <span>{{ $doctor->nombres }} {{ $doctor->apellidos }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span
                                            class="badge bg-primary text-white">{{ $doctor->especialidad->nombre}}</span>
                                    </td>
                                    <td>{{ $doctor->colegiatura }}</td>
                                    <td>{{ $doctor->telefono }}</td>
                                    <td class="text-center">
                                        <span
                                            class="badge {{ $doctor->user?->estado === 'activo' ? 'bg-success text-white' : 'bg-danger text-white' }}">
                                            {{ $doctor->user?->estado ?? 'Sin acceso' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        {{-- @can('Ver datos de doctores') --}}
                                            <a href="{{ route('doctores.show',$doctor->id) }}"
                                                class="btn btn-sm btn-icon btn-info" title="Ver">
                                                <i class="ti ti-eye"></i>
                                            </a>
                                        {{-- @endcan --}}
                                        {{-- @can('Ver formulario de edicion de doctores') --}}
                                            <a href="{{ route('doctores.edit',$doctor->id) }}"
                                                class="btn btn-sm btn-icon btn-success" title="Editar">
                                                <i class="ti ti-edit"></i>
                                            </a>
                                        {{-- @endcan --}}
                                        {{-- @can('Eliminar doctores') --}}
                                            <button type="button" class="btn btn-sm btn-icon btn-danger" title="Eliminar"
                                                data-id="{{ $doctor->id }}"
                                                data-name="{{ $doctor->nombres }} {{ $doctor->apellidos }}"
                                                data-bs-toggle="modal" data-bs-target="#modal-doctor-delete">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        {{-- @endcan --}}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        No hay doctores registrados
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="card-footer d-flex align-items-center">
                    {{ $doctors->links('tablar::pagination') }}
                </div>
                </div>
                
            </div>
        </div>
    </div>

    <div class="modal modal-blur fade" id="modal-doctor-delete" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <form action="" method="post" id="form-delete-doctor">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header bg-danger">
                        <h5 class="modal-title text-white">Eliminar Doctor</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            style="filter: brightness(0) invert(1);"></button>
                    </div>
                    <div class="modal-body text-center py-4">
                        <i class="ti ti-alert-triangle text-danger" style="font-size: 3rem;"></i>
                        <p class="mt-3">¿Estás seguro de eliminar al doctor <strong id="delete-name"></strong>?</p>
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
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('modal-doctor-delete').addEventListener('show.bs.modal', function(e) {
                var btn = e.relatedTarget;
                var id = btn.getAttribute('data-id');
                var name = btn.getAttribute('data-name');
                document.getElementById('form-delete-doctor').action = '{{ url('doctores') }}/' +
                    id + '/eliminar';
                document.getElementById('delete-name').textContent = name;
            });
        });
    </script>
@endpush