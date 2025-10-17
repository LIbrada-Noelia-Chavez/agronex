@extends('layouts.app')

@section('title', $crop->name)

@section('content')
<div class="container py-5">
    <h1 class="text-success fw-bold mb-1">{{ $crop->name }}</h1>
    <p class="text-muted mb-4">
        {{ $crop->crop_type }}@if($crop->field_location) — {{ $crop->field_location }} @endif
    </p>

    {{-- Estado del cultivo --}}
    <div class="mb-4">
        <strong>Estado:</strong>
        @if($crop->status === 'healthy')
            <span class="badge bg-success">Saludable</span>
        @elseif($crop->status === 'needs_irrigation')
            <span class="badge bg-warning text-dark">Necesita riego</span>
        @else
            <span class="badge bg-danger">Atención</span>
        @endif
    </div>

    {{-- Clima en vivo (Open-Meteo) --}}
    @if(!empty($live['hourly']) && !empty($live['hourly']['time']))
        @php
            $h = $live['hourly'];
            $i = count($h['time']) - 1; // última hora disponible
            $fmt = fn($v) => is_null($v) ? '-' : $v;
        @endphp

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h5 class="mb-3">🌤️ Clima (última hora - Open-Meteo)</h5>
                <div class="row gy-2">
                    <div class="col-md-3"><strong>Temperatura:</strong> {{ $fmt($h['temperature_2m'][$i] ?? null) }} °C</div>
                    <div class="col-md-3"><strong>Humedad:</strong> {{ $fmt($h['relative_humidity_2m'][$i] ?? null) }} %</div>
                    <div class="col-md-3"><strong>Viento:</strong> {{ $fmt($h['wind_speed_10m'][$i] ?? null) }} m/s</div>
                    <div class="col-md-3"><strong>Lluvia:</strong> {{ $fmt($h['rain'][$i] ?? null) }} mm</div>
                </div>
                <div class="row gy-2 mt-2">
                    <div class="col-md-4"><strong>Prob. precipitación:</strong> {{ $fmt($h['precipitation_probability'][$i] ?? null) }} %</div>
                    <div class="col-md-4"><strong>Temp. suelo 0 cm:</strong> {{ $fmt($h['soil_temperature_0cm'][$i] ?? null) }} °C</div>
                    <div class="col-md-4 text-muted"><strong>Leído:</strong> {{ $h['time'][$i] ?? '-' }}</div>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-info">No hay datos de clima disponibles por ahora.</div>
    @endif

    {{-- Lecturas guardadas (de la tabla weather_readings) --}}
    <h5 class="mt-4">Lecturas guardadas</h5>
    <table class="table table-sm">
      <thead>
        <tr><th>Tipo</th><th>Valor</th><th>Leído</th></tr>
      </thead>
      <tbody>
        @php
          $fmtVal = function($t, $v) {
            if ($v === null) return '-';
            return match($t) {
              'temperature','soil_temperature' => $v.' °C',
              'humidity','precipitation_probability' => $v.' %',
              'wind_speed' => $v.' m/s',
              'rain' => $v.' mm',
              default => (string)$v
            };
          };
          $tipos = ['temperature','humidity','wind_speed','rain','precipitation_probability','soil_temperature'];
        @endphp

        @php $hayDatos = false; @endphp
        @foreach ($tipos as $t)
          @php $r = $latest[$t][0] ?? null; @endphp
          <tr>
            <td>{{ $t }}</td>
            <td>{{ $fmtVal($t, $r?->value) }}</td>
            <td>{{ optional($r?->read_at)->format('d/m/Y H:i') ?? '-' }}</td>
          </tr>
          @php if($r) $hayDatos = true; @endphp
        @endforeach

        @if(!$hayDatos)
          <tr>
            <td colspan="3" class="text-center text-muted">
              Aún no hay lecturas guardadas. Abrí esta vista y recargá una vez para generar las primeras.
            </td>
          </tr>
        @endif
      </tbody>
    </table>

    <a href="{{ route('cultivos.index') }}" class="btn btn-outline-success mt-3">⬅ Volver a Cultivos</a>
</div>
@endsection
