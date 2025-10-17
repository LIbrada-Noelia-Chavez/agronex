<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Ganado - Agronex</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-light">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-success shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">
                <i class="fas fa-tractor"></i> Agronex
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <i class="fas fa-arrow-left"></i> Volver al Panel
                </a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="text-success">
                <i class="fas fa-cow"></i> Gestión de Ganado
            </h1>
            <a href="{{ route('ganado.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Agregar Animal
            </a>
        </div>

        <!-- Filtros y Búsqueda -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" id="searchInput" class="form-control" placeholder="Buscar animal...">
                    </div>
                    <div class="col-md-3">
                        <select id="filterRaza" class="form-select">
                            <option value="">Todas las razas</option>
                            <option value="Angus">Angus</option>
                            <option value="Hereford">Hereford</option>
                            <option value="Holstein">Holstein</option>
                            <option value="Brahman">Brahman</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select id="filterEstado" class="form-select">
                            <option value="">Todos los estados</option>
                            <option value="saludable">Saludable</option>
                            <option value="enfermo">Enfermo</option>
                            <option value="tratamiento">En tratamiento</option>
                            <option value="gestacion">En gestación</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-outline-secondary w-100" onclick="resetFilters()">
                            <i class="fas fa-refresh"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alertas -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Tabla de Ganado -->
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped" id="ganadoTable">
                        <thead class="table-success">
                            <tr>
                                <th>ID</th>
                                <th>Identificador</th>
                                <th>Raza</th>
                                <th>Edad</th>
                                <th>Peso (kg)</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ganados as $ganado)
                            <tr>
                                <td>{{ $ganado->id }}</td>
                                <td>
                                    <strong>{{ $ganado->identificador }}</strong>
                                </td>
                                <td>{{ $ganado->raza }}</td>
                                <td>
                                    @if($ganado->edad)
                                        {{ $ganado->edad }} años
                                    @else
                                        <span class="text-muted">No especificado</span>
                                    @endif
                                </td>
                                <td>
                                    @if($ganado->peso)
                                        {{ $ganado->peso }} kg
                                    @else
                                        <span class="text-muted">No registrado</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $badgeClass = [
                                            'saludable' => 'bg-success',
                                            'enfermo' => 'bg-danger',
                                            'tratamiento' => 'bg-warning text-dark',
                                            'gestacion' => 'bg-info'
                                        ][$ganado->estado] ?? 'bg-secondary';
                                    @endphp
                                    <span class="badge {{ $badgeClass }}">
                                        {{ ucfirst($ganado->estado) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('ganado.show', $ganado->id) }}" 
                                           class="btn btn-outline-primary" 
                                           title="Ver detalles">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('ganado.edit', $ganado->id) }}" 
                                           class="btn btn-outline-warning" 
                                           title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-outline-danger" 
                                                title="Eliminar"
                                                onclick="confirmDelete({{ $ganado->id }}, '{{ $ganado->identificador }}')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    <i class="fas fa-cow fa-3x mb-3"></i>
                                    <p>No hay animales registrados.</p>
                                    <a href="{{ route('ganado.create') }}" class="btn btn-success">
                                        <i class="fas fa-plus"></i> Agregar primer animal
                                    </a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
@if($ganados instanceof \Illuminate\Pagination\AbstractPaginator && $ganados->hasPages())
<div class="d-flex justify-content-between align-items-center mt-3">
    <div class="text-muted">
        @if($ganados->total() > 0)
            Mostrando {{ $ganados->firstItem() }} - {{ $ganados->lastItem() }} de {{ $ganados->total() }} animales
        @else
            No hay animales registrados
        @endif
    </div>
    {{ $ganados->links() }}
</div>
@endif

        <!-- Estadísticas Rápidas -->
        <div class="row mt-4">
            <div class="col-md-3">
                <div class="card text-white bg-primary">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4>{{ $ganados->count() }}</h4>
                                <p class="mb-0">Total Animales</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-cow fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-success">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4>{{ $ganados->where('estado', 'saludable')->count() }}</h4>
                                <p class="mb-0">Saludables</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-heart fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-warning">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4>{{ $ganados->whereIn('estado', ['enfermo', 'tratamiento'])->count() }}</h4>
                                <p class="mb-0">Necesitan atención</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-stethoscope fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-info">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4>{{ $ganados->where('estado', 'gestacion')->count() }}</h4>
                                <p class="mb-0">En gestación</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-baby fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Confirmación de Eliminación -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmar Eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>¿Estás seguro de que deseas eliminar al animal <strong id="animalName"></strong>?</p>
                    <p class="text-danger"><small>Esta acción no se puede deshacer.</small></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <form id="deleteForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Filtros y Búsqueda
        function filterTable() {
            const search = document.getElementById('searchInput').value.toLowerCase();
            const raza = document.getElementById('filterRaza').value;
            const estado = document.getElementById('filterEstado').value;
            
            const rows = document.querySelectorAll('#ganadoTable tbody tr');
            
            rows.forEach(row => {
                const identificador = row.cells[1].textContent.toLowerCase();
                const razaCell = row.cells[2].textContent;
                const estadoCell = row.cells[5].textContent.toLowerCase();
                
                const matchSearch = identificador.includes(search);
                const matchRaza = !raza || razaCell === raza;
                const matchEstado = !estado || estadoCell.includes(estado.toLowerCase());
                
                row.style.display = (matchSearch && matchRaza && matchEstado) ? '' : 'none';
            });
        }

        function resetFilters() {
            document.getElementById('searchInput').value = '';
            document.getElementById('filterRaza').value = '';
            document.getElementById('filterEstado').value = '';
            filterTable();
        }

        // Event Listeners para filtros
        document.getElementById('searchInput').addEventListener('input', filterTable);
        document.getElementById('filterRaza').addEventListener('change', filterTable);
        document.getElementById('filterEstado').addEventListener('change', filterTable);

        // Eliminación
        function confirmDelete(id, name) {
            document.getElementById('animalName').textContent = name;
            document.getElementById('deleteForm').action = `/ganado/${id}`;
            new bootstrap.Modal(document.getElementById('deleteModal')).show();
        }

        // Auto-ocultar alertas después de 5 segundos
        setTimeout(() => {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>
</body>
</html>