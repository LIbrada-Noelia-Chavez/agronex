<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | Agronex</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

  <nav class="navbar navbar-expand-lg navbar-dark bg-success shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">🌾 Agronex</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('cultivos.index') }}">🌱 Cultivos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('ganado.index') }}">🐄 Ganado</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('inventario') }}">📦 Inventario</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('sensores') }}">🌡️ Sensores</a>
                </li>
            </ul>
        </div>
    </div>
</nav>


    <main>
        @yield('content')
    </main>

    <footer class="text-center text-muted mt-5 mb-3 small">
        &copy; {{ date('Y') }} Agronex - Gestión Agropecuaria
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
