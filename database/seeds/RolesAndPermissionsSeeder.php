<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create(['name' => 'manage users']);
        Permission::create(['name' => 'edit parser']);

        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo(Permission::all());

        $role = Role::create(['name' => 'co-admin']);
        $role->givePermissionTo(Permission::all());

        $role = Role::create(['name' => 'editor']);
        $role->givePermissionTo('edit parser');

        $role = Role::create(['name' => 'user']);
    }
}
