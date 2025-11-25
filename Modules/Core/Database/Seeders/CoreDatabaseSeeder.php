<?php

namespace Modules\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Core\Database\Seeders\CustomerTableSeeder;
use Modules\Core\Database\Seeders\PermissionsSeeder;
use Modules\Core\Database\Seeders\RolePermissionSeeder;
use Modules\Core\Database\Seeders\RolesSeeder;
use Modules\Core\Database\Seeders\UsersSeeder;
use Modules\Core\Database\Seeders\VendorTableSeeder;

class CoreDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            RolesSeeder::class,
            PermissionsSeeder::class,
            RolePermissionSeeder::class,
            UsersSeeder::class,
            CustomerTableSeeder::class,
            VendorTableSeeder::class,
        ]);
    }
}