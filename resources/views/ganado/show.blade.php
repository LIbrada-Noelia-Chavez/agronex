<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Animal - Agronex</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .estado-badge {
            font-size: 0.9em;
            padding: 0.5em 0.8em;
        }
        .info-card {
            border-left: 4px solid #198754;
        }
        .detail-item {
            border-bottom: 1px solid #e9ecef;
            padding: 0.75rem 0;
        }
        .detail-item:last-child {
            border-bottom: none;
        }
    </style>
</head>
<body class="bg-light">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-success shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">
                <i class="fas fa-tractor"></i> Agronex
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="{{ route('ganado.index') }}">
                    <i class="fas fa-arrow-left"></i> Volver al Listado
                </a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <!-- Alertas -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Tarjeta Principal -->
                <div class="card shadow-lg">
                    <div class="card-header bg-success text-white py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-cow fa-2x me-3"></i>
                                <div>
                                    <h4 class="mb-0">Detalles del Animal</h4>
                                    <small class="opacity-75">Información completa del registro</small>
                                </div>
                            </div>
                            <div>
                                @php
                                    $badgeClass = [
                                        'saludable' => 'bg-success',
                                        'en_tratamiento' => 'bg-warning text-dark',
                                        'enfermo' => 'bg-danger',
                                        'gestacion' => 'bg-info',
                                        'lactancia' => 'bg-primary',
                                        'recuperacion' => 'bg-warning',
                                        'cuarentena' => 'bg-secondary'
                                    ][$ganado->estado] ?? 'bg-secondary';
                                @endphp
                                <span class="badge {{ $badgeClass }} estado-badge">
                                    {{ ucfirst(str_replace('_', ' ', $ganado->estado)) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <!-- Información Principal -->
                            <div class="col-md-6">
                                <div class="card info-card h-100">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0 text-success">
                                            <i class="fas fa-info-circle me-2"></i>Información Básica
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="detail-item">
                                            <strong><i class="fas fa-tag text-success me-2"></i>Identificador:</strong>
                                            <span class="float-end">{{ $ganado->identificador }}</span>
                                        </div>
                                        <div class="detail-item">
                                            <strong><i class="fas fa-paw text-success me-2"></i>Raza:</strong>
                                            <span class="float-end">{{ $ganado->raza }}</span>
                                        </div>
                                        <div class="detail-item">
                                            <strong><i class="fas fa-venus-mars text-success me-2"></i>Sexo:</strong>
                                            <span class="float-end">
                                                @if($ganado->sexo)
                                                    {{ ucfirst($ganado->sexo) }}
                                                @else
                                                    <span class="text-muted">No especificado</span>
                                                @endif
                                            </span>
                                        </div>
                                        <div class="detail-item">
                                            <strong><i class="fas fa-calendar-alt text-success me-2"></i>Edad:</strong>
                                            <span class="float-end">
                                                @if($ganado->edad)
                                                    {{ $ganado->edad }} años
                                                @else
                                                    <span class="text-muted">No especificado</span>
                                                @endif
                                            </span>
                                        </div>
                                        <div class="detail-item">
                                            <strong><i class="fas fa-weight-scale text-success me-2"></i>Peso:</strong>
                                            <span class="float-end">
                                                @if($ganado->peso)
                                                    {{ $ganado->peso }} kg
                                                @else
                                                    <span class="text-muted">No registrado</span>
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Información Adicional -->
                            <div class="col-md-6">
                                <div class="card info-card h-100">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0 text-success">
                                            <i class="fas fa-map-marker-alt me-2"></i>Ubicación y Estado
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="detail-item">
                                            <strong><i class="fas fa-heartbeat text-success me-2"></i>Estado:</strong>
                                            <span class="float-end">
                                                @php
                                                    $estadoText = [
                                                        'saludable' => '🟢 Saludable',
                                                        'en_tratamiento' => '🟡 En tratamiento',
                                                        'enfermo' => '🔴 Enfermo',
                                                        'gestacion' => '👶 En gestación',
                                                        'lactancia' => '🥛 En lactancia',
                                                        'recuperacion' => '🟠 En recuperación',
                                                        'cuarentena' => '🚧 En cuarentena'
                                                    ][$ganado->estado] ?? $ganado->estado;
                                                @endphp
                                                {{ $estadoText }}
                                            </span>
                                        </div>
                                        <div class="detail-item">
                                            <strong><i class="fas fa-calendar-day text-success me-2"></i>Fecha Ingreso:</strong>
                                            <span class="float-end">
                                                @if($ganado->fecha_ingreso)
                                                    {{ \Carbon\Carbon::parse($ganado->fecha_ingreso)->format('d/m/Y') }}
                                                @else
                                                    <span class="text-muted">No registrada</span>
                                                @endif
                                            </span>
                                        </div>
                                        <div class="detail-item">
                                            <strong><i class="fas fa-map-marker-alt text-success me-2"></i>Lote/Corral:</strong>
                                            <span class="float-end">
                                                @if($ganado->lote)
                                                    {{ $ganado->lote }}
                                                @else
                                                    <span class="text-muted">No asignado</span>
                                                @endif
                                            </span>
                                        </div>
                                        <div class="detail-item">
                                            <strong><i class="fas fa-calendar-plus text-success me-2"></i>Registrado:</strong>
                                            <span class="float-end">
                                                {{ $ganado->created_at->format('d/m/Y H:i') }}
                                            </span>
                                        </div>
                                        <div class="detail-item">
                                            <strong><i class="fas fa-calendar-check text-success me-2"></i>Actualizado:</strong>
                                            <span class="float-end">
                                                {{ $ganado->updated_at->format('d/m/Y H:i') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Observaciones -->
                        @if($ganado->observaciones)
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="card info-card">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0 text-success">
                                            <i class="fas fa-sticky-note me-2"></i>Observaciones
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <p class="mb-0">{{ $ganado->observaciones }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Botones de Acción -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('ganado.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-arrow-left me-2"></i>Volver al Listado
                                    </a>
                                    <div class="btn-group">
                                        <a href="{{ route('ganado.edit', $ganado->id) }}" class="btn btn-warning">
                                            <i class="fas fa-edit me-2"></i>Editar
                                        </a>
                                        <form action="{{ route('ganado.destroy', $ganado->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" 
                                                    onclick="return confirm('¿Está seguro de eliminar a {{ $ganado->identificador }}?')">
                                                <i class="fas fa-trash me-2"></i>Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>