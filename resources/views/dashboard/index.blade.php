<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agronex - Panel de Control</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-success shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ url('/') }}">🌾 Agronex</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('ganado') }}">🐄 Ganado</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('inventario') }}">📦 Inventario</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('sensores') }}">🌡️ Sensores</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container text-center mt-5">
        <h1 class="mb-4 fw-bold text-success">Panel Principal</h1>
        <p class="text-muted">Selecciona una sección para administrar tu establecimiento agropecuario.</p>

        <div class="row justify-content-center mt-5">
            <!-- Ganado -->
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">🐄 Ganado</h5>
                        <p class="card-text text-muted">Gestiona los animales, su salud y producción.</p>
                        <a href="{{ route('ganado') }}" class="btn btn-success">Ir a Ganado</a>
                    </div>
                </div>
            </div>

            <!-- Inventario -->
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">📦 Inventario</h5>
                        <p class="card-text text-muted">Controla insumos, herramientas y alimentos.</p>
                        <a href="{{ route('inventario') }}" class="btn btn-success">Ir a Inventario</a>
                    </div>
                </div>
            </div>

            <!-- Sensores -->
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">🌡️ Sensores</h5>
                        <p class="card-text text-muted">Monitorea temperatura, humedad y más.</p>
                        <a href="{{ route('sensores') }}" class="btn btn-success">Ir a Sensores</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="text-center text-muted mt-5 mb-3 small">
        &copy; {{ date('Y') }} Agronex - Gestión Agropecuaria
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<!-- Bloque resumen de Cultivos -->
<div class="row mt-4">
    <div class="col-md-12">
        <h3 class="text-success">🌱 Cultivos</h3>
    </div>

    @php
        $crops = \App\Models\Crop::orderBy('name')->limit(4)->get();
    @endphp

    @foreach($crops as $c)
    <div class="col-md-3">
        <div class="card mb-3 shadow-sm">
            <div class="card-body">
                <h5 class="card-title">{{ $c->name }}</h5>
                <p class="mb-1 text-muted">{{ $c->crop_type }} — {{ $c->field_location }}</p>
                <p class="mb-1">
                    Estado:
                    @if($c->status === 'healthy')
                        <span class="badge bg-success">Saludable</span>
                    @elseif($c->status === 'needs_irrigation')
                        <span class="badge bg-warning text-dark">Necesita riego</span>
                    @else
                        <span class="badge bg-danger">Atención</span>
                    @endif
                </p>
                <a href="{{ route('cultivos.show', $c->id) }}" class="btn btn-outline-success btn-sm">Ver</a>
            </div>
        </div>
    </div>
    @endforeach

    <div class="col-md-12 text-end">
        <a href="{{ route('cultivos.index') }}" class="btn btn-success">Ver todos los cultivos</a>
    </div>
</div>
