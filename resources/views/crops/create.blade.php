@extends('layouts.app')

@section('title', 'Crear Cultivo')

@section('content')
<div class="container py-5">
    <h1 class="text-success fw-bold mb-3">➕ Nuevo Cultivo</h1>

    <form action="{{ route('cultivos.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3 row">
            <div class="col">
                <label class="form-label">Tipo</label>
                <input type="text" name="crop_type" class="form-control">
            </div>
            <div class="col">
                <label class="form-label">Ubicación</label>
                <input type="text" name="field_location" class="form-control">
            </div>
        </div>

        <div class="mb-3 row">
            <div class="col">
                <label class="form-label">Umbral humedad (%)</label>
                <input type="number" name="moisture_threshold" class="form-control" min="0" max="100" value="35">
            </div>
            <div class="col">
                <label class="form-label">Fecha plantado</label>
                <input type="date" name="planted_at" class="form-control">
            </div>
        </div>

        <button class="btn btn-success">Guardar</button>
        <a href="{{ route('cultivos.index') }}" class="btn btn-outline-secondary">Cancelar</a>
    </form>
</div>
@endsection
