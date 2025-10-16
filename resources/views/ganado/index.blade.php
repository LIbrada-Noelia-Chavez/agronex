@extends('layouts.app')

@section('title', 'Gestión de Ganado')

@section('content')
<div class="container py-5">
    <h1 class="text-success fw-bold mb-4">🐄 Gestión de Ganado</h1>

    <div class="d-flex justify-content-between mb-3">
        <p class="text-muted">Controla tus animales, su raza, edad y estado de salud.</p>
        <a href="#" class="btn btn-success">➕ Agregar Animal</a>
    </div>

    <table class="table table-bordered shadow-sm">
        <thead class="table-success">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Raza</th>
                <th>Edad</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Lola</td>
                <td>Angus</td>
                <td>3 años</td>
                <td>Saludable</td>
                <td>
                    <a href="#" class="btn btn-sm btn-warning">✏️ Editar</a>
                    <a href="#" class="btn btn-sm btn-danger">🗑️ Eliminar</a>
                </td>
            </tr>
        </tbody>
    </table>

    <a href="{{ route('dashboard') }}" class="btn btn-outline-success mt-3">⬅ Volver al Panel</a>
</div>
@endsection
