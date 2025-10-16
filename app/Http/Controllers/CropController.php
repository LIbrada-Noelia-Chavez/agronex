<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Crop;
use App\Models\SensorReading;

class CropController extends Controller
{
    public function index()
    {
        $crops = Crop::orderBy('name')->get();
        return view('crops.index', compact('crops'));
    }

    public function show(Crop $crop)
    {
        // Lecturas recientes relacionadas (simulación: tomamos últimas lecturas de tipo soil_moisture)
        $latestSoil = SensorReading::where('sensor_type', 'soil_moisture')
                    ->orderBy('created_at', 'desc')
                    ->limit(10)
                    ->get();

        return view('crops.show', compact('crop', 'latestSoil'));
    }

    public function create()
    {
        return view('crops.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'crop_type' => 'nullable|string|max:255',
            'field_location' => 'nullable|string|max:255',
            'planted_at' => 'nullable|date',
            'moisture_threshold' => 'nullable|integer|min:0|max:100',
            'temp_min' => 'nullable|numeric',
            'temp_max' => 'nullable|numeric',
        ]);

        Crop::create($data);

        return redirect()->route('cultivos.index')->with('success','Cultivo agregado.');
    }
}
