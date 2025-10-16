@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="text-success">{{ isset($ganado) ? '✏️ Editar Ganado' : '➕ Nuevo Ganado' }}</h2>

    <form action="{{ isset($ganado) ? route('ganado.update', $ganado) : route('ganado.store') }}" method="POST">
        @csrf
        @if(isset($ganado)) @method('PUT') @endif

        <div class="mb-3">
            <label>Identificador</label>
            <input name="identificador" class="form-control" value="{{ $ganado->identificador ?? '' }}" required>
        </div>
        <div class="mb-3">
            <label>Raza</label>
            <input name="raza" class="form-control" value="{{ $ganado->raza ?? '' }}">
        </div>
        <div class="row">
            <div class="col mb-3">
                <label>Edad (meses)</label>
                <input type="number" name="edad" class="form-control" value="{{ $ganado->edad ?? '' }}">
            </div>
            <div class="col mb-3">
                <label>Peso (kg)</label>
                <input type="number" name="peso" class="form-control" value="{{ $ganado->peso ?? '' }}">
            </div>
        </div>
        <div class="mb-3">
            <label>Estado</label>
            <select name="estado" class="form-control">
                <option value="saludable" {{ isset($ganado) && $ganado->estado == 'saludable' ? 'selected' : '' }}>Saludable</option>
                <option value="enfermo" {{ isset($ganado) && $ganado->estado == 'enfermo' ? 'selected' : '' }}>Enfermo</option>
            </select>
        </div>

        <button class="btn btn-success">{{ isset($ganado) ? 'Actualizar' : 'Guardar' }}</button>
        <a href="{{ route('ganado.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
