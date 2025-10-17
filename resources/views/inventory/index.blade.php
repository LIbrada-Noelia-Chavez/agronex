{{-- resources/views/inventory/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">

    <h1 class="text-3xl font-bold text-gray-800 mb-6">Inventario</h1>

    {{-- Estadísticas --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-2xl shadow p-6 text-center">
            <h2 class="text-lg font-semibold text-gray-600">Bajo stock</h2>
            <p class="text-3xl font-bold text-red-500 mt-2">{{ $stats['bajo_stock'] ?? 0 }}</p>
        </div>

        <div class="bg-white rounded-2xl shadow p-6 text-center">
            <h2 class="text-lg font-semibold text-gray-600">Próximos a vencer</h2>
            <p class="text-3xl font-bold text-yellow-500 mt-2">{{ $stats['proximo_vencer'] ?? 0 }}</p>
        </div>

        <div class="bg-white rounded-2xl shadow p-6 text-center">
            <h2 class="text-lg font-semibold text-gray-600">Valor total</h2>
            <p class="text-3xl font-bold text-green-500 mt-2">
                ${{ number_format($stats['valor_total'] ?? 0, 2) }}
            </p>
        </div>
    </div>

    {{-- Botón para crear nuevo elemento --}}
    <div class="mb-4 text-right">
        <a href="{{ route('inventario.create') }}"
           class="inline-block bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition">
            + Agregar nuevo
        </a>
    </div>

    {{-- Tabla de inventario --}}
    <div class="bg-white rounded-2xl shadow overflow-hidden">
        <table class="min-w-full text-left border-collapse">
            <thead class="bg-gray-100 text-gray-600 uppercase text-sm font-semibold">
                <tr>
                    <th class="py-3 px-4">ID</th>
                    <th class="py-3 px-4">Nombre</th>
                    <th class="py-3 px-4">Tipo</th>
                    <th class="py-3 px-4">Cantidad</th>
                    <th class="py-3 px-4">Valor</th>
                    <th class="py-3 px-4">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($inventario as $item)
                    <tr class="hover:bg-gray-50">
                        <td class="py-3 px-4">{{ $item->id }}</td>
                        <td class="py-3 px-4 font-medium">{{ $item->nombre }}</td>
                        <td class="py-3 px-4">{{ $item->tipo }}</td>
                        <td class="py-3 px-4">{{ $item->cantidad }}</td>
                        <td class="py-3 px-4">${{ number_format($item->valorTotal, 2) }}</td>
                        <td class="py-3 px-4">
                            <a href="{{ route('inventario.show', $item) }}" class="text-blue-600 hover:underline">Ver</a>
                            <a href="{{ route('inventario.edit', $item) }}" class="ml-2 text-yellow-600 hover:underline">Editar</a>
                            <form action="{{ route('inventario.destroy', $item) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('¿Seguro que deseas eliminar este elemento?')" class="ml-2 text-red-600 hover:underline">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-4 text-center text-gray-500">No hay elementos en el inventario.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
