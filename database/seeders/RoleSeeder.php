<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = Permission::pluck('id');

        $role = Role::create([
            'title' => 'مدیر کل',
            'description' => 'دسترسی به همه قسمت های وبسایت',
        ]);

        $role->permissions()->sync($permissions);
    }
}
