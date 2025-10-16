<?php

namespace App\Http\Controllers;

use App\Models\Crop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CropController extends Controller
{
    // ✅ Presets centralizados (editá valores si querés)
    private function presets(): array
    {
        return [
            'papa' => [
                'name' => 'Papa (semilla)',
                'crop_type' => 'Papa',
                'presentation' => 'Bolsa 25 kg',
                'price' => 85000.00,
                'coverage_value' => 0.5,   // 1 bolsa ≈ 0.5 ha
                'coverage_unit' => 'ha',
                'moisture_threshold' => 35,
                'status' => 'healthy',
            ],
            'zapallo' => [
                'name' => 'Zapallo (semilla en lata)',
                'crop_type' => 'Zapallo',
                'presentation' => 'Lata 1 kg',
                'price' => 42000.00,
                'coverage_value' => 1,     // 1 lata ≈ 1 ha
                'coverage_unit' => 'ha',
                'moisture_threshold' => 30,
                'status' => 'healthy',
            ],
            'maiz' => [
                'name' => 'Maíz (híbrido)',
                'crop_type' => 'Maíz',
                'presentation' => 'Bolsa 60.000 semillas',
                'price' => 130000.00,
                'coverage_value' => 2.5,   // 1 bolsa ≈ 2.5 ha
                'coverage_unit' => 'ha',
                'moisture_threshold' => 35,
                'status' => 'healthy',
            ],
            'soja' => [
                'name' => 'Soja (inoculada)',
                'crop_type' => 'Soja',
                'presentation' => 'Bolsa 40 kg',
                'price' => 98000.00,
                'coverage_value' => 1,     // 1 bolsa ≈ 1 ha
                'coverage_unit' => 'ha',
                'moisture_threshold' => 35,
                'status' => 'healthy',
            ],
            'trigo' => [
                'name' => 'Trigo (semilla)',
                'crop_type' => 'Trigo',
                'presentation' => 'Bolsa 40 kg',
                'price' => 76000.00,
                'coverage_value' => 0.8,   // 1 bolsa ≈ 0.8 ha
                'coverage_unit' => 'ha',
                'moisture_threshold' => 35,
                'status' => 'healthy',
            ],
        ];
    }

    public function index()
    {
        $crops = Crop::orderBy('name')->get();
        return view('crops.index', compact('crops'));
    }

    // 👉 Ahora create solo muestra tarjetas de presets
    public function create()
    {
        $presets = $this->presets();
        return view('crops.select', compact('presets'));
    }

    // ❌ Ya no usamos store() desde inputs libres para "crear", pero podés dejarlo si otros flujos lo necesitan

    // ✅ Crear cultivo desde preset (sin inputs del usuario)
    public function storeFromPreset(Request $request)
    {
        $data = $request->validate([
            'preset_key' => 'required|string',
        ]);

        $presets = $this->presets();
        $key = $data['preset_key'];

        if (!array_key_exists($key, $presets)) {
            return redirect()->route('cultivos.create')->with('error', 'Preset inválido.');
        }

        $preset = $presets[$key];

        // Campos fijos o nulos (sin edición manual)
        $payload = array_merge($preset, [
            'field_location'     => null,
            'planted_at'         => null,
            'temp_min'           => null,
            'temp_max'           => null,
        ]);

        Crop::create($payload);

        return redirect()->route('cultivos.index')->with('success', 'Cultivo creado desde preset: '.$preset['name']);
    }

   public function show(\App\Models\Crop $crop)
{
    $latestSoil = collect([
        (object)[
            'value' => 25,
            'meta' => ['sensor_id' => 'SOIL-1'],
            'created_at' => now()->subDays(3)->toDateTimeString(),
        ],
        (object)[
            'value' => 40,
            'meta' => ['sensor_id' => 'SOIL-1'],
            'created_at' => now()->subDays(2)->toDateTimeString(),
        ],
        (object)[
            'value' => 70,
            'meta' => ['sensor_id' => 'SOIL-2'],
            'created_at' => now()->subDay()->toDateTimeString(),
        ],
    ]);

    return view('crops.show', compact('crop', 'latestSoil'));
}


    // Si querés bloquear edición manual totalmente, podés deshabilitar edit/update:
    // public function edit() { abort(404); }
    // public function update() { abort(404); }
    // Eliminar sí suele tener sentido:
    public function destroy($id)
{
    $crop = \App\Models\Crop::find($id);

    if (!$crop) {
        return redirect()
            ->route('cultivos.index')
            ->with('error', 'Cultivo no encontrado.');
    }

    try {
        $ok = $crop->delete(); // bool|null

        // En algunos drivers puede devolver null; confirmamos en DB
        $stillExists = \App\Models\Crop::whereKey($id)->exists();

        if ($ok !== false && !$stillExists) {
            return redirect()
                ->route('cultivos.index')
                ->with('success', 'Cultivo eliminado.')
                ->with('deleted_id', $id);
        }

        // Log para inspección rápida
        Log::warning('No se pudo eliminar cultivo', [
            'id' => $id,
            'delete_return' => $ok,
            'still_exists' => $stillExists,
        ]);

        return redirect()
            ->route('cultivos.index')
            ->with('error', 'No se pudo eliminar.');

    } catch (\Throwable $e) {
        Log::error('Error eliminando cultivo', ['id' => $id, 'msg' => $e->getMessage()]);
        return redirect()
            ->route('cultivos.index')
            ->with('error', 'No se pudo eliminar: '.$e->getMessage());
    }
}

}
