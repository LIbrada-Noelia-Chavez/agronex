@extends('layouts.app')

@section('title', 'Elegir cultivo')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-success fw-bold">🌱 Elegí un cultivo</h1>
        <a href="{{ route('cultivos.index') }}" class="btn btn-outline-success">⬅ Volver</a>
    </div>

    @if(session('error'))
      <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row">
        @foreach($presets as $key => $p)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm border-success h-100">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title text-success fw-bold">{{ $p['name'] }}</h5>
                        <p class="mb-1 text-muted">{{ $p['crop_type'] }}</p>

                        <ul class="list-unstyled small mb-3">
                            <li><strong>Presentación:</strong> {{ $p['presentation'] }}</li>
                            <li><strong>Precio:</strong> ${{ number_format($p['price'], 2, ',', '.') }}</li>
                            <li><strong>Cobertura:</strong>
                                {{ rtrim(rtrim(number_format($p['coverage_value'],2,',','.'),'0'),',') }}
                                {{ $p['coverage_unit'] }}
                            </li>
                            <li><strong>Umbral humedad:</strong> {{ $p['moisture_threshold'] }}%</li>
                            <li><strong>Estado:</strong> <span class="badge bg-success">Saludable</span></li>
                        </ul>

                        <form action="{{ route('cultivos.storePreset') }}" method="POST" class="mt-auto">
                            @csrf
                            <input type="hidden" name="preset_key" value="{{ $key }}">
                            <button class="btn btn-success w-100">Seleccionar</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
