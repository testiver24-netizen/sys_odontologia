@extends('tablar::page')

@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">Administración</div>
                    <h2 class="page-title">Pacientes</h2>
                </div>
                <div class="col-12 col-md-auto ms-auto d-print-none">
                    {{-- @can('Ver formulario de creacion de pacientes') --}}
                        <a href="{{ route('pacientes.create') }}" class="btn btn-primary">
                            <i class="ti ti-plus"></i> Nuevo Paciente
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
                    <h3 class="card-title text-white">Listado de Pacientes</h3>
                </div>
                <div class="card-body border-bottom">
                    <form action="{{ route('pacientes.index') }}" method="get" class="row g-2 align-items-center">
                        <div class="col-auto">
                            <label class="form-label mb-0">Buscar paciente</label>
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" name="buscar" value="{{ request('buscar') }}"
                                placeholder="Escribe el nombre, apellido o documento">
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-sm btn-primary">
                                <i class="ti ti-search"></i> Buscar
                            </button>
                            @if (request('buscar'))
                                <a href="{{ route('pacientes.index') }}"
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
                        Se encontraron {{ $pacientes->total() }} resultado(s) para
                        <strong>"{{ request('buscar') }}"</strong>.
                    </div>
                @endif
                <div class="table-responsive">
                    <table class="table table-striped table-hover card-table table-vcenter text-nowrap">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Nombre</th>
                                <th class="text-center">Documento</th>
                                <th class="text-center">Telefono</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Genero</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pacientes as $paciente)
                                <tr>
                                    <td class="text-center">{{ $pacientes->firstItem() + $loop->index }}</td>
                                    <td>{{ $paciente->nombres }} {{ $paciente->apellidos }}</td>
                                    <td>{{ $paciente->tipo_documento }}: {{ $paciente->numero_documento }}</td>
                                    <td>{{ $paciente->telefono }}</td>
                                    <td>{{ $paciente->user->email }}</td>
                                    <td>
                                        <span
                                            class="badge {{ $paciente->genero === 'M' ? 'bg-blue text-white' : 'bg-pink text-white' }}">
                                            {{ $paciente->genero === 'M' ? 'Masculino' : 'Femenino' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                       
                                            {{-- <a href="{{ route('historial.show', $paciente->id) }}"
                                                class="btn btn-sm btn-icon btn-info" title="Historial Clínico">
                                                <i class="ti ti-notes"></i>
                                            </a> --}}
                                      
                                       
                                            {{-- <a href="{{ route('odontograma.show', $paciente->id) }}"
                                                class="btn btn-sm btn-icon btn-primary" title="Odontograma Interactivo">
                                                <i class="ti ti-dental"></i>
                                            </a> --}}
                                      
                                        
                                            <a href="{{ route('pacientes.show', $paciente->id)  }}"
                                                class="btn btn-sm btn-icon btn-info" title="Ver Datos">
                                                <i class="ti ti-eye"></i>
                                            </a>
                                       
                                        
                                   <a href="{{ route('pacientes.edit', $paciente->id) }}" class="btn btn-sm btn-icon btn-success" title="Editar">
                                            <i class="ti ti-edit"></i>
                                        </a>
                                       
                                        
                                            <button type="button" class="btn btn-sm btn-icon btn-danger" title="Eliminar"
                                                data-id="{{ $paciente->id }}"
                                                data-name="{{ $paciente->nombres }} {{ $paciente->apellidos }}"
                                                data-bs-toggle="modal" data-bs-target="#modal-paciente-delete">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        No hay pacientes registrados
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer d-flex align-items-center">
                    {{ $pacientes->links('tablar::pagination') }}
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-blur fade" id="modal-paciente-delete" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <form action="" method="post" id="form-delete-paciente">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header bg-danger">
                        <h5 class="modal-title text-white">Eliminar Paciente</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            style="filter: brightness(0) invert(1);"></button>
                    </div>
                    <div class="modal-body text-center py-4">
                        <i class="ti ti-alert-triangle text-danger" style="font-size: 3rem;"></i>
                        <p class="mt-3">¿Estás seguro de eliminar al paciente <strong id="delete-name"></strong>?</p>
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
            document.getElementById('modal-paciente-delete').addEventListener('show.bs.modal', function(e) {
                var btn = e.relatedTarget;
                var id = btn.getAttribute('data-id');
                var name = btn.getAttribute('data-name');
                document.getElementById('form-delete-paciente').action = '{{ url('pacientes') }}/' +
                    id + '/eliminar';
                document.getElementById('delete-name').textContent = name;
            });
        });
    </script>
@endpush