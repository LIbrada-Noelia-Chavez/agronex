<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agronex - Plataforma Agropecuaria</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex flex-column align-items-center justify-content-center vh-100">
    <div class="text-center">
        <h1 class="display-4 text-success fw-bold mb-3">🌾 Bienvenido a Agronex</h1>
        <p class="lead text-muted mb-4">Gestión integral del establecimiento agropecuario</p>
        <a href="{{ route('dashboard') }}" class="btn btn-success btn-lg shadow-sm">
            Entrar al panel
        </a>
    </div>

    <footer class="text-muted mt-5 small">
        &copy; {{ date('Y') }} Agronex - Todos los derechos reservados
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
