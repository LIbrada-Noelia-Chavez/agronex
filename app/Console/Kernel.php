<?php
namespace App\Console;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        \App\Console\Commands\SimulateSensors::class,
    ];

   protected function schedule(\Illuminate\Console\Scheduling\Schedule $schedule): void
{
    // cada 30 minutos (ajustá si querés)
    $schedule->job(new \App\Jobs\FetchCropWeather())->everyThirtyMinutes();
}

}
