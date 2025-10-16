<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Crop;
use Carbon\Carbon;

class CropSeeder extends Seeder
{
    public function run()
    {
        Crop::create([
            'name' => 'Trigo - Lote A',
            'crop_type' => 'Trigo',
            'field_location' => 'Lote A',
            'planted_at' => Carbon::now()->subWeeks(6),
            'moisture_threshold' => 35,
            'temp_min' => 10,
            'temp_max' => 30,
            'status' => 'healthy'
        ]);

        Crop::create([
            'name' => 'Maíz - Lote B',
            'crop_type' => 'Maíz',
            'field_location' => 'Lote B',
            'planted_at' => Carbon::now()->subWeeks(3),
            'moisture_threshold' => 40,
            'temp_min' => 15,
            'temp_max' => 32,
            'status' => 'healthy'
        ]);
    }
}
$this->call([
    \Database\Seeders\CropSeeder::class,
    // otros seeders...
]);
