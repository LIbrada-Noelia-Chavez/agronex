<?php
namespace App\Console\Commands;
use Illuminate\Console\Command;
use App\Models\SensorReading;

class SimulateSensors extends Command
{
    protected $signature = 'simulate:sensors {--count=10}';
    protected $description = 'Simula lecturas de sensores y las guarda en la base de datos';

    public function handle()
    {
        $count = (int) $this->option('count');
        $types = ['soil_moisture','air_temp','humidity','livestock_location'];
        for($i=0;$i<$count;$i++){
            $type = $types[array_rand($types)];
            $value = match($type){
                'soil_moisture' => rand(200,800)/10,
                'air_temp' => rand(100,350)/10,
                'humidity' => rand(200,900)/10,
                'livestock_location' => null,
            };
            SensorReading::create([
                'sensor_type'=>$type,
                'value'=>$value,
                'meta'=>['sensor_id'=>rand(1,12),'note'=>'simulated']
            ]);
            $this->info("Simulated: $type -> ".($value ?? 'n/a'));
            usleep(100000);
        }
        return 0;
    }
}
