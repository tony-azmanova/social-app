<?php
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsTableSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['guard_name' => 'admin', 'name' => 'edit all posts']);
        Permission::create(['guard_name' => 'admin', 'name' => 'edit all users']);
        Permission::create(['guard_name' => 'admin', 'name' => 'edit all comments']);
        Permission::create(['guard_name' => 'web', 'name' => 'edit all users']);
        Permission::create(['guard_name' => 'web', 'name' => 'edit all posts']);
        Permission::create(['guard_name' => 'web', 'name' => 'edit all comments']);
        Permission::create(['guard_name' => 'web', 'name' => 'edit own posts']);
        Permission::create(['guard_name' => 'web', 'name' => 'edit own comments']);
        Permission::create(['guard_name' => 'web', 'name' => 'edit profile']);


        // create roles and assign created permissions

        // this can be done as separate statements
        $role = Role::create(['name' => 'admin']);
        //$role->givePermissionTo()
        $role->givePermissionTo(['edit all users', 'edit all comments']);

        // or may be done by chaining
        $role = Role::create(['name' => 'user'])
            ->givePermissionTo(['edit own posts', 'edit own comments', 'edit profile']);

        $role = Role::create(['name' => 'moderator']);
        $role->givePermissionTo(['edit all posts', 'edit all comments']);
        //$role->givePermissionTo(Permission::all());
        
        $users = App\User::all();
        foreach ($users as $user) {
            $user->assignRole('user');
        }
    }
}
