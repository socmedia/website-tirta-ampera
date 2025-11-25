<?php

namespace Modules\Common\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Modules\Common\Models\Province;

class ProvinceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get(base_path('Modules/Common/Database/Seeders/json/province.json'));
        $provinces = json_decode($json, true);

        return Province::insert($provinces);
    }
}
