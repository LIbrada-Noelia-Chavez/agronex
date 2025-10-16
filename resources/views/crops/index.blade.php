@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="text-success">🌱 Lista de Cultivos</h2>
    <a href="{{ route('cultivos.create') }}" class="btn btn-success mb-3">➕ Nuevo Cultivo</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nombre</th><th>Tipo</th><th>Ubicación</th><th>Estado</th><th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        @foreach($crops as $c)
            <tr>
                <td>{{ $c->name }}</td>
                <td>{{ $c->crop_type }}</td>
                <td>{{ $c->field_location }}</td>
                <td><span class="badge bg-{{ $c->status == 'healthy' ? 'success' : 'warning' }}">{{ $c->status }}</span></td>
                <td>
                    <a href="{{ route('cultivos.edit', $c) }}" class="btn btn-warning btn-sm">Editar</a>
                    <form action="{{ route('cultivos.destroy', $c) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm">Eliminar</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
