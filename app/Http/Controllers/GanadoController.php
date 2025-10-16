<?php

namespace App\Http\Controllers;

use App\Models\Ganado;
use Illuminate\Http\Request;

class GanadoController extends Controller
{
    public function index() {
        $ganados = Ganado::all();
        return view('ganado.index', compact('ganados'));
    }

    public function create() {
        return view('ganado.create');
    }

    public function store(Request $request) {
        $data = $request->validate([
            'identificador' => 'required|string',
            'raza' => 'required|string',
            'edad' => 'nullable|integer',
            'peso' => 'nullable|numeric',
            'estado' => 'nullable|string',
        ]);
        Ganado::create($data);
        return redirect()->route('ganado.index')->with('success', 'Animal agregado correctamente.');
    }

    public function edit(Ganado $ganado) {
        return view('ganado.edit', compact('ganado'));
    }

    public function update(Request $request, Ganado $ganado) {
        $ganado->update($request->all());
        return redirect()->route('ganado.index')->with('success', 'Registro de ganado actualizado.');
    }

    public function destroy(Ganado $ganado) {
        $ganado->delete();
        return redirect()->route('ganado.index')->with('success', 'Animal eliminado.');
    }
}
