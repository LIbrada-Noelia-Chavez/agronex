<?php

namespace App\Http\Controllers;

use App\Models\Crop;
use Illuminate\Http\Request;

class CropController extends Controller
{
    public function index() {
        $crops = Crop::all();
        return view('crops.index', compact('crops'));
    }

    public function create() {
        return view('crops.create');
    }

    public function store(Request $request) {
        $data = $request->validate([
            'name' => 'required|string',
            'crop_type' => 'nullable|string',
            'field_location' => 'nullable|string',
            'planted_at' => 'nullable|date',
            'moisture_threshold' => 'nullable|integer',
            'status' => 'nullable|string',
        ]);
        Crop::create($data);
        return redirect()->route('cultivos.index')->with('success', 'Cultivo agregado correctamente.');
    }

    public function edit(Crop $crop) {
        return view('crops.edit', compact('crop'));
    }

    public function update(Request $request, Crop $crop) {
        $crop->update($request->all());
        return redirect()->route('cultivos.index')->with('success', 'Cultivo actualizado.');
    }

    public function destroy(Crop $crop) {
        $crop->delete();
        return redirect()->route('cultivos.index')->with('success', 'Cultivo eliminado.');
    }
}
