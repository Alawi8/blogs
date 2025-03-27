<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissons
        $permissions = [
            'view dashboard',
            'manage users',
            'edit questions',
            'take quiz',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // create permissions and rols 
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->givePermissionTo(Permission::all());

        $teacher = Role::firstOrCreate(['name' => 'teacher']);
        $teacher->givePermissionTo(['edit questions', 'view dashboard']);

        $user = Role::firstOrCreate(['name' => 'user']);
        $user->givePermissionTo(['take quiz']);

        // choose first is any thing
        $firstUser = \App\Models\User::first();
        if ($firstUser && !$firstUser->hasRole('admin')) {
            $firstUser->assignRole('admin');
        }
    }
}
