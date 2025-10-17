<?php

namespace App\Services\Weather;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class OpenMeteoService
{
    /**
     * Devuelve pronóstico horario (sin API key).
     * Variables: temp, humedad relativa, prob. precipitación, lluvia, viento, temp suelo 0cm
     */
    public function fetchHourly(float $lat, float $lon, string $timezone = 'auto', int $days = 1): array
    {
        $url = 'https://api.open-meteo.com/v1/forecast';

        $params = [
            'latitude'       => $lat,
            'longitude'      => $lon,
            'timezone'       => $timezone,        // 'auto' usa la zona local
            'forecast_days'  => $days,            // 1 día (podés subirlo)
            'hourly' => implode(',', [
                'temperature_2m',
                'relative_humidity_2m',
                'precipitation_probability',
                'rain',
                'wind_speed_10m',
                'soil_temperature_0cm',
            ]),
        ];

        $cacheKey = 'openmeteo-hourly-'.md5(json_encode($params));
        return Cache::remember($cacheKey, now()->addMinutes(15), function () use ($url, $params) {
            $res = Http::timeout(10)->get($url, $params);
            $res->throw();
            return $res->json();
        });
    }
}
