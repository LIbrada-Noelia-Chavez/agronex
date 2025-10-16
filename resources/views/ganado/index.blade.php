@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="text-success">🐄 Lista de Ganado</h2>
    <a href="{{ route('ganado.create') }}" class="btn btn-success mb-3">➕ Nuevo Animal</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr><th>ID</th><th>Raza</th><th>Edad</th><th>Peso</th><th>Estado</th><th>Acciones</th></tr>
        </thead>
        <tbody>
        @foreach($ganados as $g)
            <tr>
                <td>{{ $g->identificador }}</td>
                <td>{{ $g->raza }}</td>
                <td>{{ $g->edad }}</td>
                <td>{{ $g->peso }}</td>
                <td><span class="badge bg-{{ $g->estado == 'saludable' ? 'success' : 'warning' }}">{{ $g->estado }}</span></td>
                <td>
                    <a href="{{ route('ganado.edit', $g) }}" class="btn btn-warning btn-sm">Editar</a>
                    <form action="{{ route('ganado.destroy', $g) }}" method="POST" class="d-inline">
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
