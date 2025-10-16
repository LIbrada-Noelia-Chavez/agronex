@extends('layouts.app')

@section('title', 'Cultivos')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-success fw-bold">🌱 Estado de Cultivos</h1>
        <a href="{{ route('cultivos.create') }}" class="btn btn-success">
            <span class="me-1">+</span> Nuevo Cultivo
        </a>
    </div>

    @if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
  <div class="alert alert-danger">{{ session('error') }}</div>
@endif


    @if($crops->isEmpty())
        <div class="alert alert-info text-center">No hay cultivos registrados aún.</div>
    @else
    <div class="row">
        @foreach($crops as $crop)
            <div class="col-md-4 mb-4" data-crop-id="{{ $crop->id }}">
                <div class="card shadow-sm border-success h-100 position-relative">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title text-success fw-bold">{{ $crop->name }}</h5>
                        <p class="mb-1 text-muted">
                            {{ $crop->crop_type }}
                            @if($crop->field_location) — {{ $crop->field_location }} @endif
                        </p>

                        <p class="mb-1">
                            <strong>Estado:</strong>
                            @if($crop->status === 'healthy')
                                <span class="badge bg-success">Saludable</span>
                            @elseif($crop->status === 'needs_irrigation')
                                <span class="badge bg-warning text-dark">Necesita riego</span>
                            @else
                                <span class="badge bg-danger">Atención</span>
                            @endif
                        </p>

                        @if($crop->presentation)
                            <p class="mb-1"><strong>Presentación:</strong> {{ $crop->presentation }}</p>
                        @endif
                        @if($crop->price)
                            <p class="mb-1"><strong>Precio:</strong> ${{ number_format($crop->price, 2, ',', '.') }}</p>
                        @endif
                        @if($crop->coverage_value && $crop->coverage_unit)
                            <p class="mb-1"><strong>Cobertura:</strong>
                                {{ rtrim(rtrim(number_format($crop->coverage_value,2,',','.'),'0'),',') }} {{ $crop->coverage_unit }}
                            </p>
                        @endif

                        <p class="mb-1"><strong>Umbral humedad:</strong> {{ $crop->moisture_threshold }}%</p>

                        {{-- Acciones --}}
                        <div class="mt-3 d-flex gap-2">
                            <a href="{{ route('cultivos.show', $crop->id) }}"
                               class="btn btn-outline-success btn-sm" role="button">
                                👁️ Ver
                            </a>

                            <form action="{{ route('cultivos.destroy', $crop->id) }}"
                                  method="POST" class="m-0 p-0"
                                  onsubmit="return confirm('¿Eliminar este cultivo?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    🗑️ Eliminar
                                </button>
                            </form>
                        </div>
                    </div> {{-- card-body --}}
                </div>
            </div>
        @endforeach
    </div>
    @endif

    <a href="{{ route('dashboard') }}" class="btn btn-outline-success mt-3" role="button">
        ⬅ Volver al Panel
    </a>
</div>

{{-- Script para eliminar visualmente el cultivo --}}
@if(session('deleted_id'))
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const id = '{{ session('deleted_id') }}';
    const card = document.querySelector(`[data-crop-id="${id}"]`);
    if (card) {
        card.classList.add('fade-out');
        setTimeout(() => card.remove(), 400);
    }
  });
</script>

<style>
.fade-out {
    opacity: 0;
    transform: scale(0.95);
    transition: opacity 0.4s ease, transform 0.4s ease;
}
</style>
@endif

@endsection
