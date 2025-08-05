<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class SpatieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'view invoice']);
        Permission::create(['name' => 'create invoice']);
        Permission::create(['name' => 'edit invoice']);
        Permission::create(['name' => 'delete invoice']);

        Permission::create(['name' => 'view user']);
        Permission::create(['name' => 'create user']);
        Permission::create(['name' => 'edit user']);
        Permission::create(['name' => 'delete user']);

        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo(['view invoice', 'create invoice', 'edit invoice', 'delete invoice']);
        $role->givePermissionTo(['view user', 'create user', 'edit user', 'delete user']);

        $role = Role::create(['name' => 'user']);
        $role->givePermissionTo(['view invoice']);
        $role->givePermissionTo(['view user']);

        $roles = Role::pluck('name');
        $users = \App\Models\User::all();
        foreach ($users as $user) {
            $user->assignRole($roles->random());
        }
    }
}
