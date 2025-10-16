<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Crop;
use App\Models\SensorReading;
use Illuminate\Support\Facades\Log;

class EvaluateCrops extends Command
{
    protected $signature = 'crops:evaluate {--minutes=60}';
    protected $description = 'Evalúa el estado de los cultivos según lecturas de sensores';

    public function handle()
    {
        $minutes = (int) $this->option('minutes');
        $this->info("Evaluando cultivos usando lecturas de los últimos {$minutes} minutos...");

        $crops = Crop::all();
        foreach ($crops as $crop) {
            // Tomamos promedio de las últimas lecturas de humedad en el periodo
            $since = now()->subMinutes($minutes);
            $readings = SensorReading::where('sensor_type', 'soil_moisture')
                        ->where('created_at', '>=', $since)
                        ->orderBy('created_at', 'desc')
                        ->limit(20)
                        ->get();

            if ($readings->isEmpty()) {
                $this->line(" - {$crop->name}: sin lecturas recientes.");
                continue;
            }

            $avg = $readings->avg('value');

            if ($avg === null) {
                $status = 'attention';
            } else {
                if ($avg < $crop->moisture_threshold) {
                    $status = 'needs_irrigation';
                } else {
                    $status = 'healthy';
                }
            }

            if ($crop->status !== $status) {
                $old = $crop->status;
                $crop->status = $status;
                $crop->save();
                $this->info(" -> {$crop->name}: {$old} -> {$status} (avg={$avg})");
                Log::info("Crop status changed: {$crop->name} {$old} => {$status}");
            } else {
                $this->line(" -> {$crop->name}: sin cambio ({$status}) (avg={$avg})");
            }
        }

        $this->info('Evaluación finalizada.');
        return 0;
    }
}
