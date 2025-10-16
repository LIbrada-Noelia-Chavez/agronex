@extends('layouts.app')

@section('title', 'Cultivos')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-success fw-bold">🌱 Estado de Cultivos</h1>
        <a href="{{ route('cultivos.create') }}" class="btn btn-success">➕ Nuevo Cultivo</a>
    </div>

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        @foreach($crops as $crop)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">{{ $crop->name }}</h5>
                        <p class="mb-1 text-muted">{{ $crop->crop_type }} — {{ $crop->field_location }}</p>
                        <p class="mb-1"><strong>Estado:</strong>
                            @if($crop->status === 'healthy')
                                <span class="badge bg-success">Saludable</span>
                            @elseif($crop->status === 'needs_irrigation')
                                <span class="badge bg-warning text-dark">Necesita riego</span>
                            @else
                                <span class="badge bg-danger">Atención</span>
                            @endif
                        </p>
                        <p class="mb-1"><strong>Umbral humedad:</strong> {{ $crop->moisture_threshold }}%</p>
                        <a href="{{ route('cultivos.show', $crop->id) }}" class="btn btn-outline-success btn-sm mt-2">Ver detalle</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <a href="{{ route('dashboard') }}" class="btn btn-outline-success mt-3">⬅ Volver al Panel</a>
</div>
@endsection
