<?php

namespace Modules\Common\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Modules\Common\Models\Regency;

class RegencyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get(base_path('Modules/Common/Database/Seeders/json/regency.json'));
        $regencies = json_decode($json, true);

        return Regency::insert($regencies);
    }
}
