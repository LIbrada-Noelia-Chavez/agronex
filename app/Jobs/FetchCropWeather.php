<?php
namespace App\Jobs;

use App\Models\Crop;
use App\Models\WeatherReading;
use App\Services\Weather\OpenMeteoService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class FetchCropWeather implements ShouldQueue
{
    use Dispatchable, Queueable;

    public function __construct(public ?int $cropId = null) {}

    public function handle(OpenMeteoService $om): void
    {
        // Coordenadas base (si el cultivo no tiene lat/lon propios)
        $lat = (float) (config('app.farm_lat') ?? env('FARM_LAT'));
        $lon = (float) (config('app.farm_lon') ?? env('FARM_LON'));
        $tz  = env('FARM_TIMEZONE', 'auto');

        $crop = null;
        if ($this->cropId) {
            $crop = Crop::find($this->cropId);
            // Si tu tabla crops tiene lat/lon, descomentá y usá:
            // $lat = (float) ($crop->lat ?? $lat);
            // $lon = (float) ($crop->lon ?? $lon);
        }

        $data = $om->fetchHourly($lat, $lon, $tz, 1);
        if (empty($data['hourly']) || empty($data['hourly']['time'])) return;

        // Tomamos la última hora disponible
        $h       = $data['hourly'];
        $lastIdx = count($h['time']) - 1;
        $readAt  = $h['time'][$lastIdx] ?? now();

        // Mapeo: clave de Open-Meteo => tipo nuestro
        $map = [
            'temperature_2m'            => 'temperature',
            'relative_humidity_2m'      => 'humidity',
            'precipitation_probability' => 'precipitation_probability',
            'rain'                      => 'rain',
            'wind_speed_10m'            => 'wind_speed',
            'soil_temperature_0cm'      => 'soil_temperature',
        ];

        foreach ($map as $k => $type) {
            if (isset($h[$k][$lastIdx])) {
                WeatherReading::create([
                    'crop_id' => $crop?->id,
                    'source'  => 'open-meteo',
                    'type'    => $type,
                    'value'   => (float) $h[$k][$lastIdx],
                    'payload' => $data,
                    'read_at' => $readAt,
                ]);
            }
        }
    }
}
