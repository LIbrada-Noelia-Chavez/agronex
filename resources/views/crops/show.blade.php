@extends('layouts.app')

@section('title', $crop->name)

@section('content')
<div class="container py-5">
    <h1 class="text-success fw-bold mb-3">{{ $crop->name }}</h1>
    <p class="text-muted">{{ $crop->crop_type }} — {{ $crop->field_location }}</p>

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

    <h5>Lecturas recientes de humedad (suelo)</h5>
    <table class="table table-sm">
        <thead><tr><th>Valor</th><th>Sensor ID</th><th>Leído</th></tr></thead>
        <tbody>
            @foreach($latestSoil as $r)
                <tr>
                    <td>{{ $r->value }}</td>
                    <td>{{ $r->meta['sensor_id'] ?? '-' }}</td>
                    <td>{{ $r->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('cultivos.index') }}" class="btn btn-outline-success mt-3">⬅ Volver a Cultivos</a>
</div>
@endsection
