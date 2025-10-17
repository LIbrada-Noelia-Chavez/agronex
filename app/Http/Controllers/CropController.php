<?php

namespace App\Http\Controllers;

use App\Models\Crop;
use App\Models\WeatherReading;            // <- faltaba
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\Weather\OpenMeteoService;

class CropController extends Controller
{
    // ✅ Presets centralizados
    private function presets(): array
    {
        return [
            'papa' => [
                'name' => 'Papa (semilla)',
                'crop_type' => 'Papa',
                'presentation' => 'Bolsa 25 kg',
                'price' => 85000.00,
                'coverage_value' => 0.5, // 1 bolsa ≈ 0.5 ha
                'coverage_unit' => 'ha',
                'moisture_threshold' => 35,
                'status' => 'healthy',
            ],
            'zapallo' => [
                'name' => 'Zapallo (semilla en lata)',
                'crop_type' => 'Zapallo',
                'presentation' => 'Lata 1 kg',
                'price' => 42000.00,
                'coverage_value' => 1,   // 1 lata ≈ 1 ha
                'coverage_unit' => 'ha',
                'moisture_threshold' => 30,
                'status' => 'healthy',
            ],
            'maiz' => [
                'name' => 'Maíz (híbrido)',
                'crop_type' => 'Maíz',
                'presentation' => 'Bolsa 60.000 semillas',
                'price' => 130000.00,
                'coverage_value' => 2.5, // 1 bolsa ≈ 2.5 ha
                'coverage_unit' => 'ha',
                'moisture_threshold' => 35,
                'status' => 'healthy',
            ],
            'soja' => [
                'name' => 'Soja (inoculada)',
                'crop_type' => 'Soja',
                'presentation' => 'Bolsa 40 kg',
                'price' => 98000.00,
                'coverage_value' => 1,   // 1 bolsa ≈ 1 ha
                'coverage_unit' => 'ha',
                'moisture_threshold' => 35,
                'status' => 'healthy',
            ],
            'trigo' => [
                'name' => 'Trigo (semilla)',
                'crop_type' => 'Trigo',
                'presentation' => 'Bolsa 40 kg',
                'price' => 76000.00,
                'coverage_value' => 0.8, // 1 bolsa ≈ 0.8 ha
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

    // 👉 Muestra tarjetas/presets
    public function create()
    {
        $presets = $this->presets();
        return view('crops.select', compact('presets'));
    }

    // ✅ Crear cultivo desde preset
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

        $payload = array_merge($preset, [
            'field_location' => null,
            'planted_at'     => null,
            'temp_min'       => null,
            'temp_max'       => null,
        ]);

        Crop::create($payload);

        return redirect()
            ->route('cultivos.index')
            ->with('success', 'Cultivo creado desde preset: '.$preset['name']);
    }

    // ✅ Mostrar cultivo + clima en vivo + guardar lecturas (6b)
    public function show(Crop $crop, OpenMeteoService $om)
    {
        // Coordenadas (si luego agregás lat/lon en crops, usalas aquí)
        $lat = (float) ($crop->lat ?? env('FARM_LAT', -34));
        $lon = (float) ($crop->lon ?? env('FARM_LON', -64));
        $tz  = env('FARM_TIMEZONE', 'auto');

        // 1) Clima en vivo (Open-Meteo)
        $live = $om->fetchHourly($lat, $lon, $tz, 1);

        // 2) Guardar la última lectura en DB (weather_readings)
        if (!empty($live['hourly']['time'])) {
            $h = $live['hourly'];
            $i = count($h['time']) - 1;

            $map = [
                'temperature_2m'            => 'temperature',
                'relative_humidity_2m'      => 'humidity',
                'precipitation_probability' => 'precipitation_probability',
                'rain'                      => 'rain',
                'wind_speed_10m'            => 'wind_speed',
                'soil_temperature_0cm'      => 'soil_temperature',
            ];

            foreach ($map as $k => $type) {
                if (isset($h[$k][$i])) {
                    WeatherReading::create([
                        'crop_id' => $crop->id,
                        'source'  => 'open-meteo',
                        'type'    => $type,
                        'value'   => (float) $h[$k][$i],
                        'payload' => $live,
                        'read_at' => $h['time'][$i],
                    ]);
                }
            }
        }

        // 3) Consultar lecturas guardadas (agrupadas por tipo)
        $latest = WeatherReading::where('crop_id', $crop->id)
            ->orderByDesc('read_at')
            ->get()
            ->groupBy('type');

        // 4) Datos de suelo simulados (tu tabla legacy)
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

        return view('crops.show', compact('crop', 'live', 'latest'));
    }

    // 🗑️ Eliminar cultivo
    public function destroy($id)
    {
        $crop = Crop::find($id);

        if (!$crop) {
            return redirect()
                ->route('cultivos.index')
                ->with('error', 'Cultivo no encontrado.');
        }

        try {
            $ok = $crop->delete();
            $stillExists = Crop::whereKey($id)->exists();

            if ($ok !== false && !$stillExists) {
                return redirect()
                    ->route('cultivos.index')
                    ->with('success', 'Cultivo eliminado.')
                    ->with('deleted_id', $id);
            }

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
