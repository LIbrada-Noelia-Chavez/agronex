<?php

namespace App\Http\Controllers;

use App\Models\Ganado;
use Illuminate\Http\Request;

class GanadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ganados = Ganado::latest()->paginate(10);
        return view('ganado.index', compact('ganados'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ganado.create');
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
{
    $request->validate([
        'identificador' => 'required|string|max:255|unique:ganados',
        'raza' => 'required|string|max:255',
        'edad' => 'nullable|integer|min:0|max:30',
        'peso' => 'nullable|numeric|min:0|max:2000',
        'sexo' => 'nullable|string|in:hembra,macho',
        'estado' => 'required|string|in:saludable,en_tratamiento,enfermo,gestacion,lactancia,recuperacion,cuarentena',
        'fecha_ingreso' => 'nullable|date',
        'lote' => 'nullable|string|max:50',
        'observaciones' => 'nullable|string|max:500',
    ]);

    try {
        Ganado::create($request->all());
        return redirect()->route('ganado.index')
                         ->with('success', 'Animal agregado correctamente.');
    } catch (\Exception $e) {
        return redirect()->back()
                         ->with('error', 'Error al agregar el animal: ' . $e->getMessage())
                         ->withInput();
    }
}
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $ganado = Ganado::findOrFail($id);
            return view('ganado.show', compact('ganado'));
        } catch (\Exception $e) {
            return redirect()->route('ganado.index')
                             ->with('error', 'Animal no encontrado.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $ganado = Ganado::findOrFail($id);
            return view('ganado.edit', compact('ganado'));
        } catch (\Exception $e) {
            return redirect()->route('ganado.index')
                             ->with('error', 'Animal no encontrado.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'identificador' => 'required|string|max:255|unique:ganados,identificador,' . $id,
            'raza' => 'required|string|max:255',
            'edad' => 'nullable|integer|min:0|max:30',
            'peso' => 'nullable|numeric|min:0|max:2000',
            'sexo' => 'nullable|string|in:hembra,macho',
            'estado' => 'required|string|in:saludable,en_tratamiento,enfermo,gestacion,lactancia,recuperacion,cuarentena',
            'fecha_ingreso' => 'nullable|date',
            'lote' => 'nullable|string|max:50',
            'observaciones' => 'nullable|string|max:500',
        ]);

        try {
            $ganado = Ganado::findOrFail($id);
            $ganado->update($request->all());
            return redirect()->route('ganado.index')
                             ->with('success', 'Animal actualizado correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()
                             ->with('error', 'Error al actualizar el animal: ' . $e->getMessage())
                             ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $ganado = Ganado::findOrFail($id);
            $nombre = $ganado->identificador;
            $ganado->delete();
            
            return redirect()->route('ganado.index')
                             ->with('success', "Animal '$nombre' eliminado correctamente.");
        } catch (\Exception $e) {
            return redirect()->route('ganado.index')
                             ->with('error', 'Error al eliminar el animal: ' . $e->getMessage());
        }
    }
}