@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="text-success">{{ isset($crop) ? '✏️ Editar Cultivo' : '➕ Nuevo Cultivo' }}</h2>

    <form action="{{ isset($crop) ? route('cultivos.update', $crop) : route('cultivos.store') }}" method="POST">
        @csrf
        @if(isset($crop)) @method('PUT') @endif

        <div class="mb-3">
            <label>Nombre</label>
            <input name="name" class="form-control" value="{{ $crop->name ?? '' }}" required>
        </div>

        <div class="row">
            <div class="col mb-3">
                <label>Tipo</label>
                <input name="crop_type" class="form-control" value="{{ $crop->crop_type ?? '' }}">
            </div>
            <div class="col mb-3">
                <label>Ubicación</label>
                <input name="field_location" class="form-control" value="{{ $crop->field_location ?? '' }}">
            </div>
        </div>

        <div class="mb-3">
            <label>Fecha Plantado</label>
            <input type="date" name="planted_at" class="form-control" value="{{ $crop->planted_at ?? '' }}">
        </div>

        <div class="mb-3">
            <label>Umbral de Humedad (%)</label>
            <input type="number" name="moisture_threshold" class="form-control" value="{{ $crop->moisture_threshold ?? 30 }}">
        </div>

        <button class="btn btn-success">{{ isset($crop) ? 'Actualizar' : 'Guardar' }}</button>
        <a href="{{ route('cultivos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
