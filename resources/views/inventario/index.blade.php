@extends('layouts.app')

@section('title', 'Inventario')

@section('content')
<div class="container py-5">
    <h1 class="text-success fw-bold mb-4">📦 Inventario</h1>

    <div class="d-flex justify-content-between mb-3">
        <p class="text-muted">Control de insumos, herramientas y alimentos.</p>
        <a href="#" class="btn btn-success">➕ Agregar Ítem</a>
    </div>

    <table class="table table-bordered shadow-sm">
        <thead class="table-success">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Cantidad</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Balanceado Premium</td>
                <td>Alimento</td>
                <td>20 sacos</td>
                <td>Disponible</td>
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
