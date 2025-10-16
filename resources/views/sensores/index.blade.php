@extends('layouts.app')

@section('title', 'Monitoreo de Sensores')

@section('content')
<div class="container py-5">
    <h1 class="text-success fw-bold mb-4">🌡️ Monitoreo de Sensores</h1>

    <p class="text-muted">Lecturas en tiempo real de tus sensores de temperatura, humedad y ambiente.</p>

    <table class="table table-bordered shadow-sm">
        <thead class="table-success">
            <tr>
                <th>ID</th>
                <th>Tipo</th>
                <th>Ubicación</th>
                <th>Valor</th>
                <th>Última Lectura</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Temperatura</td>
                <td>Galpón 1</td>
                <td>25°C</td>
                <td>Hace 5 min</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Humedad</td>
                <td>Campo Sur</td>
                <td>68%</td>
                <td>Hace 8 min</td>
            </tr>
        </tbody>
    </table>

    <a href="{{ route('dashboard') }}" class="btn btn-outline-success mt-3">⬅ Volver al Panel</a>
</div>
@endsection
