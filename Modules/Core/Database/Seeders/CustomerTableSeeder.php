<?php

namespace Modules\Core\Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Models\Customer;

class CustomerTableSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();

        $roles = Role::where('guard_name', 'customer')->get();

        foreach ($roles as $role) {
            $user = Customer::create([
                'id' => Customer::generateId(),
                'name' => $role->name,
                'avatar' => null,
                'email' => Str::slug($role->name, '_') . '_customer@app.com',
                'email_verified_at' => now(),
                'password' => bcrypt('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $user->assignRole($role->name);
        }
    }
}
