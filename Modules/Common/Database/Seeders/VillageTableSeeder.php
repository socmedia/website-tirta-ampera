<?php

namespace Modules\Common\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Common\Models\Village;
use Illuminate\Support\Facades\File;
use App\Traits\Cacheable;

class VillageTableSeeder extends Seeder
{
    use Cacheable;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get(base_path('Modules/Common/Database/Seeders/json/village.json'));
        $villages = json_decode($json, true);

        $chunk = array_chunk($villages, 5000);

        if (config('app.env') == 'local') {
            foreach (array_slice($chunk, 0, 3) as $data) {
                Village::insert($data);
            }
        } else {
            foreach ($chunk as $data) {
                Village::insert($data);
            }
        }
    }
}
