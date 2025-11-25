<?php

namespace Modules\Core\Database\Seeders;

use Modules\Core\Models\Role;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        return Role::insert(array_merge(
            $this->userRoles(),
            // $this->customerRoles(),
            // $this->vendorRoles()
        ));
    }

    /**
     * Generate user role datas
     *
     * @return array
     */
    protected function userRoles()
    {
        return [
            [
                'name' => 'Developer',
                'guard_name' => 'web',
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString(),
            ],
            [
                'name' => 'Super Admin',
                'guard_name' => 'web',
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString(),
            ],
            [
                'name' => 'Admin',
                'guard_name' => 'web',
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString(),
            ],
            [
                'name' => 'Finance',
                'guard_name' => 'web',
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString(),
            ],
            [
                'name' => 'Human Resource',
                'guard_name' => 'web',
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString(),
            ],
            [
                'name' => 'Business Development',
                'guard_name' => 'web',
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString(),
            ],
            [
                'name' => 'Product',
                'guard_name' => 'web',
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString(),
            ],
            [
                'name' => 'Marcom',
                'guard_name' => 'web',
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString(),
            ],
        ];
    }

    /**
     * Generate customer role datas
     *
     * @return array
     */
    protected function customerRoles()
    {
        return [
            [
                'name' => 'Developer',
                'guard_name' => 'customer',
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString(),
            ],
            [
                'name' => 'Super Admin',
                'guard_name' => 'customer',
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString(),
            ],
            [
                'name' => 'Customer',
                'guard_name' => 'customer',
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString(),
            ],
        ];
    }

    /**
     * Generate vendor role datas
     *
     * @return array
     */
    protected function vendorRoles()
    {
        return [
            [
                'name' => 'Developer',
                'guard_name' => 'vendor',
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString(),
            ],
            [
                'name' => 'Super Admin',
                'guard_name' => 'vendor',
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString(),
            ],
            [
                'name' => 'Vendor',
                'guard_name' => 'vendor',
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString(),
            ],
        ];
    }
}
