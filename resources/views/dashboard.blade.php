@extends('layouts.app')

@section('content')
<div class="container-fluid bg-light p-4">
    <div class="row mb-4">
        <div class="col text-center">
            <h1 class="fw-bold text-success">🌾 Panel de Gestión Agronex</h1>
            <p class="text-muted">Monitoreo general del establecimiento</p>
        </div>
    </div>

    <!-- Tarjetas resumen -->
    <div class="row text-center">
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-success">
                <div class="card-body">
                    <h5 class="card-title text-success">Cultivos</h5>
                    <h2 class="fw-bold">{{ $totalCrops }}</h2>
                    <a href="{{ route('cultivos.index') }}" class="btn btn-outline-success btn-sm mt-2">Ver cultivos</a>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-success">
                <div class="card-body">
                    <h5 class="card-title text-success">Ganado</h5>
                    <h2 class="fw-bold">{{ $totalGanado }}</h2>
                    <a href="{{ route('ganado.index') }}" class="btn btn-outline-success btn-sm mt-2">Ver ganado</a>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-success">
                <div class="card-body">
                    <h5 class="card-title text-success">Animales Enfermos</h5>
                    <h2 class="fw-bold text-danger">{{ $enfermos }}</h2>
                    <p class="text-muted small">Seguimiento sanitario</p>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-success">
                <div class="card-body">
                    <h5 class="card-title text-success">Promedio Humedad</h5>
                    <h2 class="fw-bold">{{ $promedioHumedad }}%</h2>
                    <p class="text-muted small">Cultivos monitoreados</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráficos -->
    <div class="row mt-5">
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="text-success mb-3">🌱 Estado de Cultivos</h5>
                    <canvas id="cultivosChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="text-success mb-3">🐄 Estado del Ganado</h5>
                    <canvas id="ganadoChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Cultivos Chart
    new Chart(document.getElementById('cultivosChart'), {
        type: 'doughnut',
        data: {
            labels: ['Saludables', 'En riesgo', 'Enfermos'],
            datasets: [{
                data: [{{ $cultivosSaludables }}, {{ $cultivosRiesgo }}, {{ $cultivosEnfermos }}],
                backgroundColor: ['#198754', '#ffc107', '#dc3545']
            }]
        }
    });

    // Ganado Chart
    new Chart(document.getElementById('ganadoChart'), {
        type: 'bar',
        data: {
            labels: ['Saludable', 'Enfermo'],
            datasets: [{
                label: 'Animales',
                data: [{{ $ganadoSaludable }}, {{ $enfermos }}],
                backgroundColor: ['#198754', '#dc3545']
            }]
        },
        options: { scales: { y: { beginAtZero: true } } }
    });
</script>
@endsection
