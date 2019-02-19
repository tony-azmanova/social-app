<?php

use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsTableSeeder extends Seeder
{
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create(['guard_name' => 'admin', 'name' => 'edit all posts']);
        Permission::create(['guard_name' => 'admin', 'name' => 'edit all users']);
        Permission::create(['guard_name' => 'admin', 'name' => 'edit all comments']);
        Permission::create(['guard_name' => 'web', 'name' => 'edit all users']);
        Permission::create(['guard_name' => 'web', 'name' => 'edit all posts']);
        Permission::create(['guard_name' => 'web', 'name' => 'edit all comments']);
        Permission::create(['guard_name' => 'web', 'name' => 'edit own posts']);
        Permission::create(['guard_name' => 'web', 'name' => 'edit own comments']);
        Permission::create(['guard_name' => 'web', 'name' => 'edit profile']);

        $role = Role::create(['name' => 'admin'])
            ->givePermissionTo(['edit all users', 'edit all comments']);

        $role = Role::create(['name' => 'user'])
            ->givePermissionTo(['edit own posts', 'edit own comments', 'edit profile']);

        $role = Role::create(['name' => 'moderator'])
            ->givePermissionTo(['edit all posts', 'edit all comments']);

        $users = User::all();
        foreach ($users as $user) {
            $user->assignRole('user');
        }
    }
}
