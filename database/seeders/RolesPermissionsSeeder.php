<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolesPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'view invoices']);
        Permission::create(['name' => 'create invoices']);
        Permission::create(['name' => 'edit invoices']);
        Permission::create(['name' => 'delete invoices']);

        Permission::create(['name' => 'view users']);
        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'edit users']);
        Permission::create(['name' => 'delete users']);

        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo([
            'view invoices',
            'create invoices',
            'edit invoices',
            'delete invoices',
            'view users',
            'create users',
            'edit users',
            'delete users'
        ]);

        $role = Role::create(['name' => 'user']);
        $role->givePermissionTo([
            'view invoices',
            'create invoices',
            'edit invoices'
        ]);

        $roles = Role::all();

        $users = User::all();
        foreach ($users as $user) {
            $user->assignRole($roles->random()->name);
        }
    }
}
