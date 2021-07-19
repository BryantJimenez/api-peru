<?php

use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Permiso para Acceder al Panel Administrativo
        Permission::create(['name' => 'dashboard']);

        // Permisos de Usuarios
        Permission::create(['name' => 'users.index']);
        Permission::create(['name' => 'users.create']);
        Permission::create(['name' => 'users.show']);
        Permission::create(['name' => 'users.edit']);
        Permission::create(['name' => 'users.delete']);
        Permission::create(['name' => 'users.active']);
        Permission::create(['name' => 'users.deactive']);

        // Permisos de Códigos
        Permission::create(['name' => 'codes.create']);
        Permission::create(['name' => 'codes.edit']);
        Permission::create(['name' => 'codes.delete']);
        Permission::create(['name' => 'codes.active']);
        Permission::create(['name' => 'codes.deactive']);
        Permission::create(['name' => 'codes.revert']);

    	$superadmin=Role::create(['name' => 'Super Admin']);
        $superadmin->givePermissionTo(Permission::all());
        
        $admin=Role::create(['name' => 'Administrador']);
    	$admin->givePermissionTo(Permission::all());

        $supervisor=Role::create(['name' => 'Supervisor']);
        $supervisor->givePermissionTo(['dashboard', 'codes.revert']);

        $client=Role::create(['name' => 'Cliente']);

    	$user=User::find(1);
    	$user->assignRole('Super Admin');
    }
}
