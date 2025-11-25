<?php

namespace Modules\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Models\Vendor;
use Spatie\Permission\Models\Role;

class VendorTableSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();

        $roles = Role::where('guard_name', 'vendor')->get();

        foreach ($roles as $role) {
            $user = Vendor::create([
                'id' => Vendor::generateId(),
                'name' => $role->name,
                'email' => Str::slug($role->name, '_') . '_vendor@app.com',
                'avatar' => null,
                'email_verified_at' => now(),
                'password' => bcrypt('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $user->assignRole($role->name);
        }
    }
}
